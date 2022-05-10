<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auctions extends Model
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
        'owner_id',
        'nftid',
        'bid_amount',
        'amount_paid',
        'amount_pending',
        'status',
        'offer_status'
    ];
}
