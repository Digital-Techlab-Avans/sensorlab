<?php

    namespace App\Http\Controllers;

    use App\Models\Category;
    use App\Models\Product;
    use App\Http\Controllers\Controller;
    use App\Models\ProductImage;
    use App\Models\ProductVideo;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    use App\Models\ProductCategory;

    class ProductController extends Controller
    {
        protected $cookie_lifespan_seconds = 600;
        protected $cookieName = 'productCookie';

        /**
         * Display a listing of the resource.
         *
         */
        public function index()
        {
            return view('products.overview', ["products" => Product::all_with_outstanding(),
                "active_products" => Product::active_with_outstanding(), "archived_products" => Product::archived_with_outstanding(),
                "secured_products" => Product::secured_with_outstanding(), "no_registration_products" => Product::no_registration_with_outstanding()]);
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param \Illuminate\Http\Request $request
         */
        public function store(Request $request)
        {
            $attributes = $request->validate([
                'name' => ['required', 'max:50', 'unique:products'],
                'product_code' => ['nullable'],
                'stock' => ['nullable', 'integer'],
                'description' => ['nullable'],
                'notes' => [],
                'featured' => ['nullable', 'boolean'],
                'youtube_priority' => ['nullable'],
                'images' => ['nullable', 'array'],
                'images.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webm,webp', 'max:2048'],
                'categories' => ['nullable', 'array'],
            ]);
            $attributes['featured_date'] = $request->has('featured') ? now() : null;
            $attributes['notes'] = $attributes['notes'] ?? '';

            $newProduct = Product::create($attributes);

            foreach ($request->input('categories') ?? [] as $categoryNameInput) {
                if (is_numeric($categoryNameInput)) {
                    $categoryId = $categoryNameInput;
                } else {
                    $category = Category::firstWhere('name', $categoryNameInput);

                    if (!$category) {
                        $category = Category::create(['name' => $categoryNameInput]);
                    }
                    $categoryId = $category->id;
                }
                ProductCategory::create([
                    'product_id' => $newProduct->id,
                    'category_id' => $categoryId
                ]);
            }

            $newProduct->is_secured = $request->input('security') == 'secured';
            $newProduct->no_loan_registration = $request->input('security') == 'no_loan_registration';

            if ($request->has('archived')) {
                $newProduct->archived = date('Y-m-d h:i:s');
            } else {
                $newProduct->archived = null;
            }

            $newProduct->save();

            if ($request->has('images')) {
                // Upload images that aren't already in the project
                UploadController::uploadImages($request);

                // Add all the images to the database
                foreach ($request->file('images') as $image) {
                    // only create if it is unique
                    ProductImage::create([
                        'product_id' => $newProduct->id,
                        'image_name' => $image->getClientOriginalName(),
                        'priority' => '1'
                    ]);
                }
            }
            $youtube_priority = json_decode($request->input('youtube_priority'), true) ?? [];

            foreach ($youtube_priority as $key => $value) {
                $product_link = ProductVideo::whereProductId($newProduct->id)->where('link', '=', $key)->first();

                if ($product_link == null) {
                    ProductVideo::create([
                        'product_id' => $newProduct->id,
                        'link' => $key,
                        'priority' => $value
                    ]);
                    $product_link = ProductVideo::whereProductId($newProduct->id)->where('link', '=', $key)->first();
                }
                $product_link->priority = $value;
                $product_link->save();
            }

            return redirect()->route('product_details', ['product' => $newProduct]);
        }

        /**
         * Show the form for creating a new resource.
         *
         */
        public function create()
        {
            return view('products.create', [
                "categories" => Category::all()
            ]);
        }

        /**
         * Display the specified resource.
         *
         * @param \App\Models\Product $product
         */
        public function show(Product $product)
        {
            $product_id = $product->id;

            [$ledger, $current_ownership] = $product->getLedgerAndCurrentLoans();

            return view('products.details', [
                "product" => Product::with('loans')->firstWhere('id', "=", $product_id),
                "ledger" => $ledger,
                "current_ownership" => $current_ownership
            ]);
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param \App\Models\Product $product
         */

        function show_loaner(Product $product)
        {
            $categories = $product->activeCategories()->get();

            return view('products.loaner.details', [
                "product" => $product,
                "categories" => $categories,
            ]);
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param \App\Models\Product $product
         */
        public function preview(Product $product)
        {
            $categories = $product->categories()->get();

            return view('products.preview', [
                "product" => $product,
                "categories" => $categories,
            ]);
        }


        /**
         * Show the form for editing the specified resource.
         *
         * @param \App\Models\Product $product
         */
        public function edit(Product $product)
        {
            return view('products.edit', [
                "product" => Product::find($product->id),
                "categories" => Category::all(),
            ]);
        }

        /**
         * Update the specified resource in storage.
         *
         * @param \Illuminate\Http\Request $request
         * @param \App\Models\Product $product
         */
        public function update(Product $product, Request $request)
        {
            if ($request->has('delete')) {
                return $this->destroy($product);
            }

            $attributes = $request->validate([
                'name' => ['required', 'max:50', 'unique:products,name,' . $product->id],
                'product_code' => ['nullable'],
                'stock' => ['nullable', 'integer'],
                'description' => ['nullable'],
                'notes' => [],
                'featured' => ['nullable', 'boolean'],
                'images_priority' => ['nullable'],
                'images' => ['nullable', 'array'],
                'youtube_priority' => ['nullable'],
                'images.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webm,webp', 'max:2048'],
                'categories' => ['nullable', 'array'],
            ]);
            $attributes['notes'] = $attributes['notes'] ?? '';

            $product->productCategories()->delete();
            foreach ($request->input('categories') ?? [] as $categoryNameInput) {
                if (is_numeric($categoryNameInput)) {
                    $categoryId = $categoryNameInput;
                } else {
                    $category = Category::firstWhere('name', $categoryNameInput);

                    if (!$category) {
                        $category = Category::create(['name' => $categoryNameInput]);
                    }
                    $categoryId = $category->id;
                }
                ProductCategory::create([
                    'product_id' => $product->id,
                    'category_id' => $categoryId
                ]);
            }

            $product->is_secured = $request->input('security') == 'secured';
            $product->no_loan_registration = $request->input('security') == 'no_loan_registration';

            if ($request->has('archived')) {
                $product->archived = date('Y-m-d h:i:s');
            } else {
                $product->archived = null;
            }

            // don't update the featured date if it is already set and the featured checkbox is still checked
            if ($product->featured_date == null || !$request->has('featured')) {
                $attributes['featured_date'] = $request->has('featured') ? now() : null;
            }

            ProductImage::where('product_id', '=', $product->id)->delete();
            // unstringify the images_priority variable to a dictionary
            $images_priority = json_decode($request->input('images_priority'), true);
            $youtube_priority = json_decode($request->input('youtube_priority'), true);

            foreach ($images_priority as $key => $value) {
                $product_image = ProductImage::whereProductId($product->id)->where('image_name', '=', $key)->first();
                if ($product_image) {
                    $product_image->priority = $value;
                    $product_image->save();
                }
            }
            foreach ($youtube_priority as $key => $value) {
                $product_link = ProductVideo::whereProductId($product->id)->where('link', '=', $key)->first();

                // Add the link if it doesn't exist in the database
                if ($product_link == null) {
                    ProductVideo::create([
                        'product_id' => $product->id,
                        'link' => $key,
                        'priority' => $value
                    ]);
                    $product_link = ProductVideo::whereProductId($product->id)->where('link', '=', $key)->first();
                }
                $product_link->priority = $value;
                $product_link->save();
            }

            if ($request->has('images')) {
                // Upload images that aren't already in the project
                UploadController::uploadImages($request);

                // Add all the images to the database
                foreach ($request->file('images') as $image) {
                    // only create if it is unique
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_name' => $image->getClientOriginalName(),
                        'priority' => $images_priority[$image->getClientOriginalName()] ?? 1
                    ]);
                }
            }

            $product->update($attributes);
            return redirect()->route('product_details', ['product' => $product]);
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param \App\Models\Product $product
         * @return \Illuminate\Http\Response
         */
        public function destroy(Product $product)
        {
            try {
                $product->delete();
                return redirect()->route('product_index');
            } catch (QueryException $e) {
                return redirect()->route('product_edit', ['product' => $product])->with('error', 'Product kon niet worden verwijderd.');
            }

        }
    }

