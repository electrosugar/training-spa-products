<?php

namespace App\Http\Controllers;

use App\Mail\MailVendor;
use App\Models\ArchivedProduct;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Str;
use PhpParser\Error;
use function Symfony\Component\HttpFoundation\Session\Storage\save;
use function Symfony\Component\Routing\Loader\Configurator\collection;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        //validate input data
        $validated = $request->validate([
            'name' => 'bail|required|max:255',
            'contact' => 'bail|required|email',
            'comment' => 'required|max:500',
        ]);
        //check if there are products
        if (empty(Session::get('cart'))) {
            return redirect()->back()->withInput()->withErrors(['errors' => new MessageBag([__('No products in cart')])]);
        }

        $products = Product::find(Session::get('cart'));

        //save order
        $order = new Order();
        $order = new Order();
        $order->name = $validated['name'];
        $order->contact = $validated['contact'];
        $order->comment = $validated['comment'];
        $order->save();

        //save all product-order key pair
        foreach ($products as $product) {
            $orderProduct = new OrderProduct();
            $orderProduct->product_id = $product->id;
            $orderProduct->order_id = $order->id;
            $orderProduct->price = $product->price;
            $orderProduct->save();
        }

        //mail to the vendor
        Mail::to(env('VENDOR_EMAIL'))->send(new MailVendor($validated));
        return redirect()->to('order/' . $order->id)->with('order', $order);
    }
}
