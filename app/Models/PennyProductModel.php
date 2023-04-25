<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class PennyProductModel extends Eloquent
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $collection = 'Penny_Products';
    protected $fillable = [
        'Category', 'images', 'name', 'unitLong', 'unitShort', 'unitPrice', 'price', 'validityStart', 'validityEnd',
        'isPublished', 'volumeLabelLong', 'weight', 'published', 'productMarketing', 'product_ident_id', 'priceScore'
    ];
    public function productIdent()
    {
        return $this->belongsTo(Product_IdentModel::class, 'product_ident_id');
    }
    public function shoppingCarts()
    {
        return $this->hasMany(ShoppingCartModel::class, "user_id");
    }
}
