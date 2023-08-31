<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

/*
 * returned_at
 * comment
 * status_id
 * admin_comment
 */

/**
 * App\Models\ReturnEntry
 *
 * @property int $id
 * @property string $returned_at
 * @property string|null $comment
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $status_id
 * @property string|null $admin_comment
 * @property-read Collection<int, \App\Models\LoanEntry> $loans
 * @property-read int|null $loans_count
 * @method static Builder|ReturnEntry newModelQuery()
 * @method static Builder|ReturnEntry newQuery()
 * @method static Builder|ReturnEntry query()
 * @method static Builder|ReturnEntry whereAdminComment($value)
 * @method static Builder|ReturnEntry whereComment($value)
 * @method static Builder|ReturnEntry whereCreatedAt($value)
 * @method static Builder|ReturnEntry whereId($value)
 * @method static Builder|ReturnEntry whereReturnedAt($value)
 * @method static Builder|ReturnEntry whereStatusId($value)
 * @method static Builder|ReturnEntry whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ReturnEntry extends Model
{
    protected $table = 'returns';

    use HasFactory;

    protected $fillable = [
        'comment',
        'status_id',
        'admin_comment'
    ];

    public function loans(): BelongsToMany
    {
        return $this->belongsToMany(LoanEntry::class, 'loans_and_returns', 'return_id', 'loan_id')->withPivot('amount');
    }

    public static function getPendingReturnsByUser()
    {
        $pendingId = ReturnStatus::getPendingId();
        $returns = ReturnEntry::selectRaw('returns.id, returns.returned_at, returns.comment, SUM(loans_and_returns.amount) as total_amount')
            ->where('status_id', $pendingId)
            ->join('loans_and_returns', 'loans_and_returns.return_id', '=', 'returns.id')
            ->groupBy('returns.id', 'returns.returned_at', 'returns.comment')
            ->with('loans.product', 'loans.user')
            ->orderBy('returned_at', 'ASC')
            ->get();

        $returnsByUser = $returns->groupBy(function ($return) {
            return $return->loans[0]->user->id;
        });
        return $returnsByUser;
    }
}
