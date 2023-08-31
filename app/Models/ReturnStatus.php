<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/*
 * status_name
 */

/**
 * App\Models\ReturnStatus
 *
 * @property int $id
 * @property string $status_name
 * @property-read Collection<int, \App\Models\ReturnEntry> $returns
 * @property-read int|null $returns_count
 * @method static Builder|ReturnStatus newModelQuery()
 * @method static Builder|ReturnStatus newQuery()
 * @method static Builder|ReturnStatus query()
 * @method static Builder|ReturnStatus whereId($value)
 * @method static Builder|ReturnStatus whereStatusName($value)
 * @mixin \Eloquent
 */
class ReturnStatus extends Model
{
    protected $table = 'return_status';

    use HasFactory;

    protected $fillable = [
        'status_id'
    ];

    public function returns()
    {
        return $this->hasMany(ReturnEntry::class, 'status_id');
    }

    public static function getPendingId(){
        return ReturnStatus::where('status_name', 'pending')->value('id');
    }

    public static function getApprovedId(){
        return ReturnStatus::where('status_name', 'approved')->value('id');
    }

    public static function getRejectedId(){
        return ReturnStatus::where('status_name', 'rejected')->value('id');
    }
}
