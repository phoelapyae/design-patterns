<?php

namespace App\State;

class Main {
    public function run() {
        $order = new OrderContext();
        $order->getStatus();

        $order->confirmOrder();
        $order->getStatus();

        $order->payOrder();
        $order->getStatus();

        $order->shipOrder();
        $order->getStatus();
    }
}
