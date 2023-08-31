<?php

    namespace App\Models;

    use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\HasMany;
    use Illuminate\Support\Carbon;
    use Illuminate\Support\Facades\DB;

    /**
 * App\Models\Product
 *
 * @property int $id
 * @property string $name
 * @property int|null $ean_code
 * @property string|null $description
 * @property string|null $archived
 * @property int $is_secured
 * @property int $no_loan_registration
 * @property int|null $stock
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $featured_date
 * @property-read Collection<int, \App\Models\Category> $categories
 * @property-read int|null $categories_count
 * @property-read Collection<int, \App\Models\ProductImage> $images
 * @property-read int|null $images_count
 * @property-read Collection<int, \App\Models\ProductVideo> $links
 * @property-read int|null $links_count
 * @property-read Collection<int, \App\Models\LoanEntry> $loans
 * @property-read int|null $loans_count
 * @property-read Collection<int, \App\Models\ProductCategory> $productCategories
 * @property-read int|null $product_categories_count
 * @method static \Database\Factories\ProductFactory factory($count = null, $state = [])
 * @method static Builder|Product filterCategory($categoryId)
 * @method static Builder|Product newModelQuery()
 * @method static Builder|Product newQuery()
 * @method static Builder|Product query()
 * @method static Builder|Product search($search, $searchInDescription = false)
 * @method static Builder|Product whereArchived($value)
 * @method static Builder|Product whereCreatedAt($value)
 * @method static Builder|Product whereDescription($value)
 * @method static Builder|Product whereEanCode($value)
 * @method static Builder|Product whereFeaturedDate($value)
 * @method static Builder|Product whereId($value)
 * @method static Builder|Product whereIsSecured($value)
 * @method static Builder|Product whereName($value)
 * @method static Builder|Product whereStock($value)
 * @method static Builder|Product whereUpdatedAt($value)
 * @mixin Eloquent
 */
    class Product extends Model
    {
        protected $table = 'products';

        protected $with = ['images'];
        use HasFactory;

        protected $fillable = [
            'name',
            'product_code',
            'stock',
            'archived',
            'description',
            'notes',
            'featured_date',
            // These 2 fields shouldn't be filled by the user during creation
            // 'archived',
            // 'deleted',
        ];

        protected $casts = [
            'info' => 'array',
        ];

        public function loans(): HasMany
        {
            return $this->hasMany(LoanEntry::class, 'product_id');
        }

        public function returns(): \Illuminate\Support\Collection
        {
            return DB::table('loans')
                ->join('loans_and_returns', 'loans.id', '=', 'loans_and_returns.loan_id')
                ->join('returns', 'returns.id', '=', 'loans_and_returns.return_id')
                ->join('users', 'users.id', '=', 'loans.user_id')
                ->where('loans.product_id', $this->id)
                ->select('returns.*', 'loans_and_returns.amount', 'users.id as user_id', 'users.name')
                ->orderByDesc('returns.returned_at')
                ->get();
        }

        public function images(): HasMany
        {
            return $this->hasMany(ProductImage::class, 'product_id')->orderBy('priority');
        }

        public function links(): HasMany
        {
            return $this->hasMany(ProductVideo::class, 'product_id');
        }

        public static function all_with_outstanding(): Collection|array
        {
            $products_with_outstanding = Product::with('loans')->get();
            foreach ($products_with_outstanding as $product) {
                $sum = 0;
                foreach ($product->loans as $loan) {
                    $sum += $loan->remainingAmount();
                }
                $product->outstanding = $sum;
            }
            return $products_with_outstanding;
        }

        public static function active_with_outstanding(): Collection|array
        {
            $products = self::all_with_outstanding();
            $activeProducts = $products->whereNull('archived');

            return $activeProducts;
        }

        public static function archived_with_outstanding(): Collection|array
        {
            $products = self::all_with_outstanding();
            $archivedProducts = $products->whereNotNull('archived');

            return $archivedProducts;
        }

        public static function secured_with_outstanding(): Collection|array
        {
            $products = self::all_with_outstanding();
            $securedProducts = $products->where('is_secured', true);

            return $securedProducts;
        }

        public static function no_registration_with_outstanding(){
            $products = self::all_with_outstanding();
            $no_registration_products = $products->where('no_loan_registration', true);

            return $no_registration_products;
        }

        /**
         * Returns the ledger and the current ownership of the product using just 2 queries.
         * @return array
         */
        public function getLedgerAndCurrentLoans(): array
        {
            $loan_entries = $this->loans()
                ->select(DB::raw('loans.loaned_at as moment, loans.user_id as user_id, loans.amount as amount'));
            $return_entries = $this->loans()
                ->join('loans_and_returns', 'loans.id', '=', 'loans_and_returns.loan_id')
                ->join('returns', 'loans_and_returns.return_id', '=', 'returns.id')
                ->select(DB::raw('returns.returned_at as moment, loans.user_id as moment, -loans_and_returns.amount as amount'));
            $ledger = $loan_entries->union($return_entries)
                ->orderBy('moment')
                // Orders by amount to make sure that loans come before returns when the moment is the same. (such as with the test data)
                ->orderBy('amount', 'desc')
                ->get(); // <- execute first query

            // Map with key: user_id and value: [user, amount]
            $current_ownership = [];

            $relevant_users = User::whereIn('id', $ledger->pluck('user_id'))->get(); // <- execute second query

            foreach ($ledger as $transaction) {
                $transaction->user = $relevant_users->firstWhere('id', $transaction->user_id);
                if (!array_key_exists($transaction->user_id, $current_ownership)) {
                    $current_ownership[$transaction->user_id] = [
                        'user' => $transaction->user,
                        'amount' => 0
                    ];
                }
                $current_ownership[$transaction->user_id]['amount'] += $transaction->amount;
            }
            foreach ($current_ownership as $key => $value) {
                if ($value['amount'] <= 0) {
                    unset($current_ownership[$key]);
                }
            }
            return [$ledger, $current_ownership];
        }

        public function activeLoans()
        {
            $loans = $this->loans;
            $activeLoans = $loans->filter(function ($loan) {
                // Filter out loans where the amount left is 0 or negative
                return $loan->remainingAmount() > 0;
            })->sortByDesc('loaned_at');
            return $activeLoans;
        }

        public function totalOverDueAmount()
        {
            $totalOverDue = 0;
            foreach ($this->overDueLoans() as $loan) {
                $totalOverDue += $loan->remainingAmount();
            }
            return $totalOverDue;
        }

        public function overDueLoans()
        {
            $loans = $this->loans;
            $overDueLoans = $loans->filter(function ($loan) {
                // Filter out loans where the amount left is 0 or negative
                return $loan->remainingAmount() > 0 && $loan->isOverDue();
            })->sortByDesc('loaned_at');
            return $overDueLoans;
        }

        public function scopeSearch($query, $search, $searchInDescription = false)
        {
            $query->when($search ?? false, fn($query, $search) => $query
                ->where('name', 'like', '%' . $search . '%')
                ->orWhereHas('productCategories', function ($query) use ($search) {
                    $query->whereHas('category', function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%');
                    });
                }))
                ->when((($searchInDescription ?? false) && $search ?? false) ?? false, function ($query) use ($search) {
                    $query->orWhere('description', 'like', '%' . $search . '%');
                });
        }

        public static function activeProducts()
        {
            return Product::whereNull('archived');
        }


        public function scopeFilterCategory($query, $categoryId)
        {
            $query->when($categoryId ?? false, fn($query, $categoryId) => $query
                ->whereHas('productCategories', function ($query) use ($categoryId) {
                    $query->where('category_id', $categoryId);
                })
            );
        }

        public function productCategories()
        {
            return $this->hasMany(ProductCategory::class);
        }


        public function categories()
        {
            return $this->hasManyThrough(Category::class, ProductCategory::class, 'product_id', 'id', 'id', 'category_id');
        }

        public function activeCategories()
        {
            return $this->categories()->whereNull('archived');
        }


        public static function featuredProducts()
        {
            return Product::activeProducts()->whereNotNull('featured_date')->orderBy('featured_date', 'desc');
        }

        public function featuredPosition()
        {
            if (!$this->featured_date) return null;
            return Product::featuredProducts()->get()->search(function ($product) {
                return $product->id === $this->id;
            }) + 1;
        }

        public static function getLoansDictionary($loans)
        {
            $loansDictionary = [];
            foreach ($loans as $loan) {
                if (!isset($loansDictionary[$loan->user_id])) {
                    $loansDictionary[$loan->user_id] = [];
                }
                $loansDictionary[$loan->user_id][] = $loan;
            }
            return $loansDictionary;
        }

        public static function getReturnsDictionary($returns)
        {
            $returnsDictionary = [];
            foreach ($returns as $return) {
                if (!isset($returnsDictionary[$return->user_id])) {
                    $returnsDictionary[$return->user_id] = [];
                }
                $returnsDictionary[$return->user_id][] = $return;
            }
            return $returnsDictionary;
        }

        public function getSecurityLevel()
        {
            if (old('is_secured', $this->is_secured)) {
                return 'secured';
            }
            else if (old('no_loan_registration', $this->no_loan_registration)) {
                return 'no_loan_registration';
            }
            else {
                return 'normal';
            }
        }
    }
