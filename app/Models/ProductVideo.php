<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/*
 * id
 * product_id
 * imgName
 * priority
 */
/**
 * App\Models\ProductVideo
 *
 * @property int $id
 * @property int $product_id
 * @property string $link
 * @property int $priority
 * @property-read \App\Models\Product $product
 * @method static Builder|ProductVideo newModelQuery()
 * @method static Builder|ProductVideo newQuery()
 * @method static Builder|ProductVideo query()
 * @method static Builder|ProductVideo whereId($value)
 * @method static Builder|ProductVideo whereLink($value)
 * @method static Builder|ProductVideo wherePriority($value)
 * @method static Builder|ProductVideo whereProductId($value)
 * @mixin \Eloquent
 */
class ProductVideo extends Model
{
    protected $table = 'product_videos';

    public $timestamps = false;

    use HasFactory;

    protected $fillable = [
        'product_id',
        'link',
        'priority'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public static function path_array($product){
        return $product->links->map(fn($link) => $link->link)->toArray();
    }

    public static function priority_dict($product){
        return $product->links->mapWithKeys(fn($link) => [$link->link => $link->priority])->toArray();
    }
}
