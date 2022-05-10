<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallets extends Model
{
    use HasFactory;
    
    /**
    * The attributes that are mass assignable.
    *
    * @var string[]
    */
    protected $fillable = [
        'id',
        'user_id',
        'payment_id',
        'wallet_amount',
        'paymentThrough',
        'paymentFrom',
        'payment_type',
        'status'
    ];
}
