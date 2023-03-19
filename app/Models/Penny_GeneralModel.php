<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Penny_GeneralModel extends Eloquent
{
    protected $connection = 'mongodb';
	protected $collection = 'Penny_General';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         '_id','Total'
    ];
}
