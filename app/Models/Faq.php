<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Faq extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'question', 'answer', 'status', 'orderno' , 'product_filter'
    ];

    protected   $dates  =   ['created_at', 'updated_at'];

}
