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
 * App\Models\ProductLink
 *
 * @property-read \App\Models\Product $product
 * @method static Builder|ProductLink newModelQuery()
 * @method static Builder|ProductLink newQuery()
 * @method static Builder|ProductLink query()
 * @mixin \Eloquent
 */
class ProductLink extends Model
{
    protected $table = 'product_links';

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
