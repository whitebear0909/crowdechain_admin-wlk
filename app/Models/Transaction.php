<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Transaction extends Authenticatable
{
    //
    static $STARTED = 1;
    static $INPROGRESS = 2;
    static $PENDING = 300;
    static $APPROVED = 200;
    static $CANCELED = 400;
    static $DENIED = 404;

    use Notifiable;

    protected $fillable = [
        'transaction_info', 'APIKEY', 'timestamp', 'divisa', 'amount','codiceTransazione','mac','status','transaction_code'
    ];

    protected   $dates  =   ['created_at', 'updated_at'];
}
