<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nfts extends Model
{
    use HasFactory;
    
    /**
    * The attributes that are mass assignable.
    *
    * @var string[]
    */
    protected $fillable = [
        'nftid',
        'creator_id',
        'owner_id',
        'title',
        'file',
        'category',
        'tags',
        'auction_time',
        'auction_end_time',
        'price',
        'status',
        'type',
        'is_favourite',
        'likes',
        'views'
    ];
}
