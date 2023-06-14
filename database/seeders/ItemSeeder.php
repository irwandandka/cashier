<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $itemCode = ['A','B','C','D','E'];
        for($i = 0; $i < count($itemCode); $i++) {
            Item::create([
                'code' => $itemCode[$i],
                'name' => "Item{$itemCode[$i]}",
            ]);
        }
    }
}
