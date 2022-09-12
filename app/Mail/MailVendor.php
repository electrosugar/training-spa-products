<?php

namespace App\Mail;

use App\Http\Controllers\OrderController;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailVendor extends Mailable
{
    use Queueable, SerializesModels;
    private $validated;

    /**
     * Create a new message instance.
     *
     * @param $validated
     */
    public function __construct($validated)
    {
        $this->validated = $validated;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $products = Product::inCart();
        return $this->view('cart', ['products'=>$products, 'displayMail' =>true, 'orderData' => $this->validated]);
    }
}
