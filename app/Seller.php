<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Seller extends Model
{
    //
    use SoftDeletes;
    protected $dates =['deleted_at'];

    protected $table='users';

    public function products(){
        return $this->hasMany(Product::class);
    }
}
