<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['customer_id','date','subtotal','discount','total'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    
    public function order_items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
