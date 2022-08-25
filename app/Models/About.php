<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class About extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'text'
    ];

    protected   $dates  =   ['created_at', 'updated_at'];

}
