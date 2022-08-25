<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Halloffame extends Authenticatable
{
    //
    use Notifiable;

    protected $fillable = [
        'title', 'property_alt', 'img', 'author', 'instagram_url' , 'product_filter' ,'home_order'
    ];

    protected   $dates  =   ['created_at', 'updated_at'];
}
