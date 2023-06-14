<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Item;
use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // code, date, customer, city, 
        $customers = Customer::get('id');
        $items = Item::get(['id','name']);
        $randomNumberCustomer = rand(0,2);
        $randomNumberItem = rand(0,4);
        $order = Order::create([
            'code' => strtoupper(Str::random(8)),
            'customer_id' => $customers[$randomNumberCustomer],
            'date' => date('d-M'),
            'subtotal' => 200,
            'discount' => 300,
            'total' => 100,
        ]);
        for($i = 0; $i <= $randomNumberCustomer; $i++) {
            // $order->items->attach([''])
        }
    }
}
