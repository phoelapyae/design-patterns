<?php

namespace App\Facades;

class OrderFacade
{
    protected $inventory;
    protected $payment;
    protected $shipping;

    public function __construct()
    {
        $this->inventory = new Inventory();
        $this->payment = new Payment();
        $this->shipping = new Shipping();
    }

    // Client သုံးဖို့အတွက် ရိုးရှင်းတဲ့ Method တစ်ခုတည်း ပေးလိုက်မယ်
    public function placeOrder($productId, $amount) {
        if ($this->inventory->checkStock($productId)) {
            $this->payment->charge($amount);
            $this->shipping->arrangeShipping();
            echo "Order placed successfully!\n";
        }
    }
}
