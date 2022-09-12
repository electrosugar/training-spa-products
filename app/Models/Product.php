<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use function Symfony\Component\String\__construct;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $primaryKey = 'id';

    public $timestamps = false;
    protected $fillable = [
        'title',
        'description',
        'price',
        'image_path'
    ];

    public static function create($properties)
    {
        $product = new Product();
        $product->id = $properties->id;
        $product->title = $properties->title;
        $product->description = $properties->description;
        $product->price = $properties->price;
        $product->image_path = $properties->image_path;
        return $product;
    }


    public static function notInCart()
    {
        $indexProducts = Product::whereNotIn('id', Session::get('cart') ?? [])->get();
        if (!$indexProducts) {
            throw new ModelNotFoundException();
        }
        return $indexProducts;
    }

    public static function inCart()
    {
        $cartProducts = Product::whereIn('id', Session::get('cart') ?? [])->get();

        if (!$cartProducts) {
            throw new ModelNotFoundException();
        }

        return $cartProducts;

    }

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }

}
