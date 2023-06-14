<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customerCode = ['A','B','C'];
        $customerCity = ['Batam','Jakarta','Bandung','Surabaya'];
        for($i = 0; $i < count($customerCode); $i++) {
            Customer::create([
                'code' => $customerCode[$i],
                'name' => "Customer{$customerCode[$i]}",
                'city' => "{$customerCity[rand(0,3)]}"
            ]);
        }
    }
}
