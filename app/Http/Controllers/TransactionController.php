<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Order::with('customer','order_items')->get();
        return response()->json($transactions);
    }

    public function show($id)
    {
        $order = Order::where('id', $id)->with('customer','order_items')->first();
        return response()->json($order);    
    }

    public function create(Request $request)
    {
        $order = Order::create([
            'customer_id' => $request->customer_id,
            'date' => date('d-M'),
            'subtotal' => $request->subtotal,
            'discount' => $request->discount,
            'total' => $request->total
        ]);
        $orderDetail = $request->order_detail;
        foreach($orderDetail as $item) {
            OrderItem::create([
                'code' => $item['code'],
                'qty' => $item['qty'],
                'price' => $item['price'],
                'total' => $item['total'],
                'order_id' => $order->id,
                'item_id' => $item['id']
            ]);
        }

        return response()->json([
            'message' => 'success',
        ]);
    }

    public function update(Order $order, Request $request)
    {
        $order->update([
            'customer_id' => $request->customer_id,
            'subtotal' => $request->subtotal,
            'discount' => $request->discount,
            'total' => $request->total,
        ]);
        
        foreach($request->order_detail as $item) {
            $orderItem = OrderItem::find($item['id']);
            $orderItem->update([
                'code' => $item['code'],
                'qty' => $item['qty'],
                'price' => $item['price'],
                'total' => $item['total'],
                'item_id' => $item['item_id']
            ]);
        }

        return response()->json([
            'message' => 'Success'
        ]);
    }

    public function delete(Order $order)
    {
        OrderItem::where('order_id', $order->id)->delete();
        $order->delete();
    }
}
