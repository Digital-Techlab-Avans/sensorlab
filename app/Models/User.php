<?php

    namespace App\Models;

    use Database\Factories\UserFactory;
    use Barryvdh\LaravelIdeHelper\Eloquent;
    use DateTime;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Relations\HasMany;
    use Illuminate\Foundation\Auth\User as Authenticatable;

    /**
 * App\Models\User
 *
 * @property int $id
 * @property string $email
 * @property string $name
 * @property string|null $password
 * @property int $is_admin
 * @property-read Collection<int, \App\Models\LoanEntry> $loans
 * @property-read int|null $loans_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereIsAdmin($value)
 * @method static Builder|User whereName($value)
 * @method static Builder|User wherePassword($value)
 * @mixin \Eloquent
 */
    class User extends Authenticatable
    {
        public $timestamps = false;
        protected $table = 'users';

        protected $with = ['loans'];

        use HasFactory;

        public static function getLoggedInUser() {
            return User::firstWhere('email', session('user_email'));
        }


        public function setPasswordAttribute($password): void
        {
            $this->attributes['password'] = bcrypt($password);
        }

        public static function userExists($email): bool
        {
            $user = User::firstWhere('email', $email);
            return ($user != null);
        }

        public function loans(): HasMany
        {
            return $this->hasMany(LoanEntry::class, 'user_id', 'id');
        }
        public function emailPreference(): string
        {
            return $this->hasOne(EmailPreference::class, 'user_id', 'id');
        }

        public function activeLoans(): Collection
        {
            $loans = $this->loans;
            return $loans->filter(function ($loan) {
                // Filter out loans where the amount left is 0 or negative
                return $loan->remainingAmount() > 0;
            })->sortByDesc('loaned_at');
        }

        public function returns(): Collection|\Illuminate\Support\Collection
        {
            return $this->loans->map(function ($loan) {
                // Get all the returns for the loan, also include the products and the loan
                return $loan->returns->map(function ($return) use ($loan) {
                    $return->product = $loan->product;
                    $return->loan = $loan;
                    return $return;
                });
            })->sortByDesc('returned_at')->flatten();
        }

        public function totalCurrentlyLoanedAmount(){
            $totalLoans = 0;
            foreach ($this->loans as $loan) {
                $totalLoans += $loan->remainingAmount();
            }
            return $totalLoans;
        }

        public function totalOverDueAmount(){
            $totalOverDue = 0;
            foreach ($this->overDueLoans() as $loan) {
                $totalOverDue += $loan->remainingAmount();
            }
            return $totalOverDue;
        }

        public function overDueLoans(): Collection
        {
            $loans = $this->loans;
            return $loans->filter(function ($loan) {
                // Filter out loans where the amount left is 0 or negative
                return $loan->remainingAmount() > 0 && $loan->isOverDue();
            })->sortByDesc('loaned_at');
        }

        public function getLoansDictionary($loans): array
        {
            $loansDictionary = [];
            foreach ($loans as $loan) {
                if (!isset($loansDictionary[$loan->product->id])) {
                    $loansDictionary[$loan->product->id] = [];
                }
                $loansDictionary[$loan->product->id][] = $loan;
            }
            return $loansDictionary;
        }

        public function getReturnsDictionary($returns): array
        {
            $returnsDictionary = [];
            foreach ($returns as $return) {
                if (!isset($returnsDictionary[$return->product->id])) {
                    $returnsDictionary[$return->product->id] = [];
                }
                $returnsDictionary[$return->product->id][] = $return;
            }
            return $returnsDictionary;
        }

        public function active(): bool
        {
            $time_interval = new DateTime('-2 months');
            $loans_within_interval = $this->loans()->where('loaned_at', '>', $time_interval);
            $returns_within_interval = $this->returns()->where('created_at', '>', $time_interval);
            return $loans_within_interval->count() > 0 || $returns_within_interval->count() > 0;
        }


    }
