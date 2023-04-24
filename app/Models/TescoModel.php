<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class TescoModel extends Eloquent
{

    use HasFactory;
    protected $connection = 'mongodb';
    protected $collection = 'Tesco_Products';
    protected $fillable = [
        'template', 'name', 'url', 'active', 'offerBegin', 'offerEnd', 'imageURL', 'unit',
        'bestUnitPrice', 'bestPrice', 'comment', 'product_ident_id', 'priceScore'
    ];
    public function productIdent()
    {
        return $this->belongsTo(App\Models\ProductIdent::class);
    }
    public function shoppingCarts()
    {

        return $this->hasMany(ShoppingCartModel::class, "user_id");
    }
}
