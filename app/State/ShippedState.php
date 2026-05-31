<?php

namespace App\State;

class ShippedState implements OrderState {
    public function cancelOrder(Context $context) {
        echo "Cannot cancel order. It is already shipped.\n";
    }

    public function confirmOrder(Context $context) {
        echo "Order is already confirmed.\n";
    }

    public function payOrder(Context $context) {
        echo "Order is already paid.\n";
    }

    public function shipOrder(Context $context) {
        echo "Order is already shipped.\n";
    }

    public function getStatus(): string {
        return "Shipped";
    }
}
