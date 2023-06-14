<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Item;
use Illuminate\Http\Request;

class TransactionDataController extends Controller
{
    public function customers()
    {
        $customers = Customer::get();
        return response()->json($customers);
    }

    public function showCustomer(Customer $customer)
    {
        return response()->json($customer);
    }

    public function items()
    {
        $items = Item::get();
        return response()->json($items);
    }

    public function getId($code)
    {   $item = Item::where('code', $code)->get();
        return response()->json($item);
    }
}
