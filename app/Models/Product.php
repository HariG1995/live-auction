<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'image',
        'description',
        'base_price',
        'start_date',
        'end_date',
        'status',
        'bid_price',
        'highest_bidder_id'
    ];

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    public function highestBidder()
    {
        return $this->belongsTo(User::class, 'highest_bidder_id');
    }
}
