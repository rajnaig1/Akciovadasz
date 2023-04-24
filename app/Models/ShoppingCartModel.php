<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class ShoppingCartModel extends Eloquent
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $collection = 'ShoppingCart';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'shop', 'amount', 'quantity', 'comment', 'product_id', 'user_id'
    ];
    public function user()
    {
        return $this->belongsTo(App\Models\User::class);
    }
    public function pennyProduct()
    {
        return $this->belongsTo(PennyProductModel::class, 'product_id');
    }
    public function tescoProduct()
    {
        return $this->belongsTo(TescoModel::class, 'product_id');
    }
}
