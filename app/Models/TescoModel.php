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
        'bestUnitPrice', 'bestPrice', 'comment'
    ];
}
