<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function order($id)
    {
        $order = Order::findOrFail($id);
        $order->total_price = OrderProduct::where('order_id', $id)->sum('price');
        return view('order', ['order' => $order]);
    }

    public function orders()
    {
        $orders = [];
        foreach (Order::all() as $order){
            $order->total_price = OrderProduct::where('order_id', $order->id)->sum('price');
            $orders[] = $order;
        }
        return view('orders', ['orders' => $orders]);
    }

    public function index()
    {
        return response()->json(Product::notInCart());
    }

    public function cart()
    {
        //view('cart', ['products' => Product::inCart(), 'displayMail' => false])
        return response()->json(Product::inCart());
    }


    public function products()
    {
        return view('products', ['products' => Product::all()]);
    }

    public function product($id=null)
    {
        if (isset($id)) {
            $product = Product::findOrFail($id);
            return view('product', ['product' => $product]);

        } else {
            return view('product');

        }
    }


    public function app()
    {
        return view('app');
    }
}
