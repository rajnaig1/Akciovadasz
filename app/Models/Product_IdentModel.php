<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Product_IdentModel extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'Product_Ident';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'regex', 'category', 'basePrice'
    ];
    public function pennyProducts()
    {
        return $this->hasMany(PennyProductModel::class);
    }
    public function tescoProducts()
    {
        return $this->hasMany(TescoModel::class);
    }
}
