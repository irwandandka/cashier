<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        return view('customer.index', [
            'customers' => Customer::latest()->get(),
        ]);    
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'code' => "required",
            'name' => 'required|string',
            'city' => 'required'
        ]);

        Customer::create($data);
        return to_route('customer.index')->with('message','Customer Created Successfully!');
    }

    public function update(Request $request, Customer $customer)
    {
        $data = $request->validate([
            'code' => "required",
            'name' => 'required|string',
            'city' => 'required'
        ]);

        $customer->update($data);
        return to_route('customer.index')->with('message','Customer Updated Successfully!');
    }

    public function delete(Customer $customer)
    {
        $customer->delete();
        return to_route('customer.index')->with('message','Customer Deleted Successfully!');
    }
}
