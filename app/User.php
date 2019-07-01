<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;
    protected $dates =['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'verified',
        'verification_token',
        'admin'
    ];
    const VERIFIED_USER='1';
    const UNVERIFIED_USER='0';

    const ADMIN_USER='true';
    const REGULAR_USER='false';
    protected $table='users';



    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verification_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isAdmin()
    {
        return $this->admin == User::ADMIN_USER;
    }
    public function isVerified()
    {
        return $this->verfied == User::VERIFIED_USER;
    }

    public static function generateVerificationCode()
    {
        return str_random(40);
    }

// helpers
    public function setNameAttribute($name)
    {
        $this->attributes['name']=strtolower($name);
    }

    public function setEmailAttribute($email)
    {
        $this->attributes['email']=strtolower($email);
    }

    protected function getNameAttributes($name)
    {
        return ucwords($name);
    }
}
