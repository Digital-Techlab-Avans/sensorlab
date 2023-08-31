<?php

namespace App\Http\Controllers;

    use App\Models\Category;
    use App\Models\DueDate;
    use App\Models\LoanEntry;
    use App\Models\Product;
    use App\Models\User;
    use Exception;
    use Illuminate\Contracts\Foundation\Application;
    use Illuminate\Contracts\View\Factory;
    use Illuminate\Contracts\View\View;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use function setcookie;

    define('COOKIENAME', 'productCookie');
    define('COOKIE_LIFESPAN', 600);

    class LoanProductsController extends Controller
    {
        public function index(): Factory|View|Application
        {
            $user = User::getLoggedInUser();
            return $this->indexCommon($user->id);
        }

        private function indexCommon($userId, $isAdmin = false): Factory|View|Application
        {
            $sort_columns_model = [
                'name' => __('loaner.product_search.name'),
                'created_at' => __('loaner.product_search.new'),
            ];
            $sort_columns_special = [
                /* SPECIAL SORTING CAN BE ADDED HERE LIKE THIS:
                'loans' => __('loaner.product_search.loans'),*/
            ];
            $sort_columns = $sort_columns_special + $sort_columns_model;

            $products_query = Product::whereNull('archived')
                ->search(request('search'), request('description'))
                ->filterCategory(request('category'));

            $sort = request('sort', 'name');
            $ascending = request('order', 'asc') == 'asc';
            $ascending_string = $ascending ? 'asc' : 'desc';
            if (request('sort') && array_key_exists(request('sort'), $sort_columns_model)) {
                $products_query->orderBy(request('sort'), $ascending_string);
                $products = $products_query->get();
            }
            else {
                $products = $products_query->get();
                switch (request('sort')) {
                    /* SPECIAL SORTING CAN BE ADDED HERE LIKE THIS:
                    case 'loans':
                        $products = $products->sortBy(function ($product) {
                            return $product->loans->count();
                        }, SORT_REGULAR, $ascending);
                        break;*/
                    default:
                        $products = $products->sortBy('name', SORT_NATURAL, $ascending);
                        break;
                }
            }

            $allCategories = Category::allActive()->get();
            $user = User::find($userId);

            $loanerCookieName = $this->getLoanerCookieName($userId);
            $productArray = [];

            if (isset($_COOKIE[$loanerCookieName])) {
                $productArray = unserialize($_COOKIE[$loanerCookieName]); // set productArray to what is currently set in the cookie
            }

            $viewName = $isAdmin ? 'loaningpage.overview_admin' : 'loaningpage.overview';

            return view($viewName, [
                'loaner' => $user,
                'products' => $products,
                'categories' => $allCategories,
                'sort_columns' => $sort_columns,
                'sort' => $sort,
                'order' => $ascending_string,
                'added_products' => $productArray,
            ]);
        }

        private function getLoanerCookieName($userId = null): string
        {
            $user = $userId ? User::find($userId) : User::getLoggedInUser();
            $loanerCookieName = $userId ? COOKIENAME . "_lener_" . $user->id : COOKIENAME;

            return $loanerCookieName;
        }

        public function indexAdmin($id): Factory|View|Application
        {
            return $this->indexCommon($id, true);
        }

        public function getCheckOutPage(): Factory|View|Application
        {
            $productArray = $this->getProductArray(COOKIENAME);
            return view('loaners.index', ['products' => $productArray]);
        }

        private function getProductArray(string $cookieName = COOKIENAME): array
        {
            $productArray = [];

            if (isset($_COOKIE[$cookieName])) {
                $productArray = unserialize($_COOKIE[$cookieName]);
            }
            return $productArray;
        }

        public function deleteCartRow(Request $request): Factory|View|Application
        {
            $productIdToDelete = $request->input('id');
            $productArray = $this->getProductArray(COOKIENAME);

            foreach ($productArray as $index => $product) {
                if ($product['id'] == $productIdToDelete) {
                    unset($productArray[$index]);
                }
            }

            $this->updateCookie(COOKIENAME, $productArray);
            return view('loaners.index', ['products' => $productArray]);
        }

        private function updateCookie(string $cookieName, array $productArray): void
        {
            $cookieProductArray = serialize($productArray);
            setcookie($cookieName, $cookieProductArray, time() + (COOKIE_LIFESPAN), "/");
        }

        public function deleteCartRowAdmin(Request $request, $userId): RedirectResponse
        {
            $loanerCookieName = $this->getLoanerCookieName($userId);
            $productIdToDelete = $request->input('id');
            $productArray = $this->getProductArray($loanerCookieName);

            foreach ($productArray as $index => $product) {
                if ($product['id'] == $productIdToDelete) {
                    unset($productArray[$index]);
                }
            }
            $this->updateCookie($loanerCookieName, $productArray);
            return redirect()->route('loaners_loaning', ['id' => $userId]);
        }

        public function store(Request $request): RedirectResponse
        {
            $products = $request->input('products');
            $productArray = $this->getProductArray(COOKIENAME);
            foreach($products as $product){
                $id = $product['id'];
                $amount = $product['amount'];
                if(!$amount < 1){
                    foreach($productArray as $key => &$arrayProduct){
                        if($arrayProduct['id']  == $id){
                            $arrayProduct['amount'] = $amount;
                            break;
                        }
                    }
                }else{
                    foreach($productArray as $key => $arrayProduct){
                        if($arrayProduct['id']  == $id){
                            unset($productArray[$key]);
                            break;
                        }
                    }
                }
            }
            $isPosted = false;
            $user = User::getLoggedInUser()->id;

            $isPosted = $this->storeProduct($productArray, $user, $isPosted);
            if ($isPosted) {
                $this->updateCookie(COOKIENAME, []);
                return redirect()->route('hand_in')->with('success', 'Product(en) zijn succesvol geleend!');
            } else {
                return redirect()->route('product_add')->with('error', 'Er is iets mis gegaan! Je product(en) zijn niet geleend.');
            }
        }

        public function storeProduct(mixed $products, $userId, bool $isPosted): bool
        {
            if (!empty($products)) {
                foreach ($products as $product) {
                    $productId = $product['id'];
                    $amount = $product['amount'];
                    if ($amount > 0) {
                        // get the current active due date or the default due date
                        $activeDueDate = DueDate::activeDueDate() ?? DueDate::defaultDueDate();
                        $returnDate = $activeDueDate->due_date;
                        $loanEntry = LoanEntry::create(['amount' => $amount, 'product_id' => $productId, 'user_id' => $userId, 'due_at' => $returnDate]);
                        $loanEntry->save();
                        $isPosted = true;
                    }
                }
            }
            return $isPosted;
        }

        public function storeAdmin(Request $request, $userId): RedirectResponse
        {
            $loanerCookieName = $this->getLoanerCookieName($userId);
            $products = $request->input('products');
            $isPosted = false;

            $isPosted = $this->storeProduct($products, $userId, $isPosted);

            $this->updateCookie($loanerCookieName, []);

            if ($isPosted) {
                return redirect()->route('loaners_details', ['id' => $userId])->with('success', 'Product(en) zijn succesvol geleend!');
            } else {
                return redirect()->route('loaners_loaning', ['id' => $userId])->with('error', 'Er is iets mis gegaan! De product(en) zijn niet geleend.');
            }
        }

        public function addProductToCart(Request $request): JsonResponse
        {
            try {
                $productArray = $this->getProductArray();

                $productId = (int)$request->get('productId');
                $productQuantity = (int)$request->get('amount');

                $productArray = $this->addToProductArray($productArray, $productId, $productQuantity);

                $this->updateCookie(COOKIENAME, $productArray);

                return response()->json(['success' => true, 'cart' => serialize($productArray)]);
            } catch (Exception $e) {
                error_log($e->getMessage());
                return response()->json(['error' => $e->getMessage()]);
            }
        }

        private function addToProductArray(array $productArray, int $productId, int $productQuantity): array
        {
            $productIndex = null;
            foreach ($productArray as $index => $product) {
                if ($product['id'] === $productId) {
                    $productIndex = $index;
                    break;
                }
            }

            if ($productIndex !== null) {
                $productArray[$productIndex]['amount'] += $productQuantity;
            } else {
                $product = Product::find($productId);
                $productEntry = [
                    'amount' => $productQuantity,
                    'id' => $product->id,
                    'name' => $product->name,
                    'product' => ''
                ];
                $productArray[] = $productEntry;
            }

            return $productArray;
        }

        public function addProductToCartAdmin(Request $request, $loanerId): JsonResponse
        {
            try {
                $loanerCookieName = $this->getLoanerCookieName($loanerId);
                $productArray = $this->getProductArray($loanerCookieName);

                $productId = (int)$request->get('productId');
                $productQuantity = (int)$request->get('amount');

                $productArray = $this->addToProductArray($productArray, $productId, $productQuantity);

                $this->updateCookie($loanerCookieName, $productArray);

                return response()->json(['success' => true, 'cart' => serialize($productArray)]);
            } catch (Exception $e) {
                error_log($e->getMessage());
                return response()->json(['error' => $e->getMessage()]);
            }
        }
    }
