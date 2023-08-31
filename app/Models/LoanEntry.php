<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/*
 * id
 * user_email
 * loaned_at
 * due_at
 * product_id
 * amount
 */
/**
 * App\Models\LoanEntry
 *
 * @property int $id
 * @property int $user_id
 * @property string $loaned_at
 * @property string|null $due_at
 * @property int $product_id
 * @property int $amount
 * @property-read \App\Models\Product $product
 * @property-read Collection<int, \App\Models\ReturnEntry> $returns
 * @property-read int|null $returns_count
 * @property-read \App\Models\User $user
 * @method static Builder|LoanEntry newModelQuery()
 * @method static Builder|LoanEntry newQuery()
 * @method static Builder|LoanEntry query()
 * @method static Builder|LoanEntry whereAmount($value)
 * @method static Builder|LoanEntry whereDueAt($value)
 * @method static Builder|LoanEntry whereId($value)
 * @method static Builder|LoanEntry whereLoanedAt($value)
 * @method static Builder|LoanEntry whereProductId($value)
 * @method static Builder|LoanEntry whereUserId($value)
 * @mixin \Eloquent
 */
class LoanEntry extends Model
{
    protected $table = 'loans';

    protected $with = ['product', 'returns'];

    public $timestamps = false;

    use HasFactory;

    protected $fillable = [
        'amount',
        'user_id',
        'product_id',
        'due_at'
    ];

    public function returns(): BelongsToMany
    {
        return $this->belongsToMany(ReturnEntry::class, 'loans_and_returns', 'loan_id', 'return_id')->withPivot('amount');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function remainingAmount()
    {
        $returnedAmount = $this->returns->sum('pivot.amount');
        // add all the amounts of the returns that are rejected
        $rejectedReturns = $this->returns->filter(function ($return) {
            return $return->status_id === ReturnStatus::getRejectedId();
        });
        $rejectedAmount = $rejectedReturns->sum('pivot.amount');
        return $this->amount - $returnedAmount + $rejectedAmount;
    }

    public function isOverdue(): bool
    {
        return $this->due_at < now();
    }
}
