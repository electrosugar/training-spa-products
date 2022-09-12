<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class OrderProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $products = Product::all()->pluck('id')->toArray();
        $orders = Order::all()->pluck('id')->toArray();
        $id_product = $this->faker->randomElement($products);
        $price = Product::where('id', $id_product)->pluck('price')[0];
        return [
            'product_id' => $id_product,
            'order_id' => $this->faker->randomElement($orders),
            'price' => $price
        ];
    }
}
