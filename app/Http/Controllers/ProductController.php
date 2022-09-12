<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\MessageBag;

class ProductController extends Controller
{

    public function add(Request $request)
    {
        Session::push('cart', $request->productID);
        return redirect('index');
    }

    public function remove(Request $request)
    {
        $cartSession = Session::get('cart');
        while (($key = array_search($request->productID, $cartSession)) !== false) {
            unset($cartSession[$key]);
        }
        Session::put('cart', $cartSession);
        Session::save();
        return redirect('cart');
    }

    public function delete(Request $request)
    {
        $product = Product::findOrFail($request->productID);
        $allProducts = Product::all();
        if(!($product->orders->count())){
            Product::destroy($request->productID);
        }
        else{
            $product->deleted = 1;
            $product->save();
            $errors = new MessageBag();

            // add your error messages:
            $errors->add('id', $request->productID);
            $errors->add('message', 'Product still in order, not deleted');
            return redirect()->back()->withInput()->withErrors($errors);
        }
        return view('products', ['products' => $allProducts]);
    }

    public function edit(Request $request, int $id)
    {
        $validated = $request->validate([
            'title' => 'required_without_all:description,price,image|nullable|string|max:50',
            'description' => 'required_without_all:title,price,image|nullable|string|max:500',
            'price' => 'required_without_all:description,title,image|nullable|numeric',
            'image' => 'required_without_all:description,price,title|nullable|image|max:6000',
        ]);
        $updateAssocArray = [];
        if ($title = $validated['title']) {
            $updateAssocArray['title'] = $title;
        }
        if ($description = $validated['description']) {
            $updateAssocArray['description'] = $description;
        }
        if ($price = $validated['price']) {
            $updateAssocArray['price'] = $price;
        }

        if ($image = $request->file('image')) {
            $image_path = 'storage\images\\' . $request->file('image')->hashName();
            $request->file('image')->store('public/images');
            $updateAssocArray['image_path'] = $image_path;
        }
        if ($updateAssocArray) {
            DB::table('products')->where('id', $id)->limit(1)->update($updateAssocArray);
        }
        return back()->withInput()->with('message', __('Successful Edit'));

    }

    public function insert(Request $request)
    {

        $validated = $request->validate([
            'title' => 'required|string|max:50',
            'description' => 'required|string|max:500',
            'price' => 'required|numeric',
            'image' => 'required|image',
        ]);
        $title = $validated['title'];
        $description = $validated['title'];
        $price = $validated['price'];
        if ($image = $validated['image']) {
            $image_path = 'storage\images\\' . $request->file('image')->hashName();
            $request->file('image')->store('public/images');

            DB::table('products')->insert([
                'title' => $title,
                'description' => $description,
                'price' => $price,
                'image_path' => $image_path
            ]);
        }

        return view('product')->with('message', __('Product Added Successfully'));

    }

}
