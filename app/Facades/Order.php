<?php

namespace App\Facades;

// Client Code (အသုံးရ အရမ်းလွယ်ကူသွားပါပြီ);
class Order {
    public function placeOrder(){
        $order = new OrderFacade();
        $order->placeOrder(101, 50);
    }
}
