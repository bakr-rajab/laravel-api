<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Buyer extends Model
{
    //
    use SoftDeletes;
    protected $dates =['deleted_at'];
    protected $table='users';
    public function transactions(){
        return $this->hasMany(Transaction::class);
    }

}
