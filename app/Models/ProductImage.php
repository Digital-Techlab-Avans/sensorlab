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
 * App\Models\ProductImage
 *
 * @property int $id
 * @property int $product_id
 * @property string $image_name
 * @property int $priority
 * @property-read \App\Models\Product $product
 * @method static Builder|ProductImage newModelQuery()
 * @method static Builder|ProductImage newQuery()
 * @method static Builder|ProductImage query()
 * @method static Builder|ProductImage whereId($value)
 * @method static Builder|ProductImage whereImageName($value)
 * @method static Builder|ProductImage wherePriority($value)
 * @method static Builder|ProductImage whereProductId($value)
 * @mixin \Eloquent
 */
class ProductImage extends Model
{
    protected $table = 'product_images';

    public $timestamps = false;

    use HasFactory;

    protected $fillable = [
        'product_id',
        'image_name',
        'priority'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function getImagePath(): string
    {
        return asset('images/'.$this->image_name);
    }
}
