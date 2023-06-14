<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $fillable = ['name','code'];

    // public function orders()
    // {
    //     return $this->belongsToMany(Order::class, 'order_items')->withPivot(['qty','price','total'])->withTimestamps();    
    // }

    public function order_items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
