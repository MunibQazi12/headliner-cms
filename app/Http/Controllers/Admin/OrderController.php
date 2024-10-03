<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function orders(Request $request){

        $orders = Order::query()->with('user' , 'order_item','order_item.product', 'order_item.product_attribute');

        if ($request->name) {
            $industries = $orders->whereHas("user" , function($query) use($request) {
                $query->where('first_name', 'LIKE', '%' . $request->name . '%');
            });
        }
      
        $perPage = $request->perPage ?? 20;

        $orders = $orders
            ->orderBy('id', 'desc')
            ->paginate($perPage)
            ->withQueryString();
        
        return Inertia::render('Admin/Order/List', compact('orders'));
    }
    public function viewOrder($id){
        $order = Order::where("id" , $id)->with('user' , 'order_item','order_item.product', 'order_item.product_attribute')->get()->first();

        
        return Inertia::render('Admin/Order/View', compact('order'));
    }
    public function changeStatus(Request $request)
    {
        $industry = Order::findOrFail($request->id);
        $industry->fill(['status' => $request->status])->save();
        session()->flash('success', 'Status successfully changed');
        return back();
    }
}
