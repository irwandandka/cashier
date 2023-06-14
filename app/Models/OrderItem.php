<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    protected $fillable = ['code','qty','price','total','order_id','item_id'];

    public function order()
    {
        return $this->belongsTo(Order::class);    
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
