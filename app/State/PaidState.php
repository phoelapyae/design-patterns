<?php

namespace App\State;

class PaidState implements OrderState {
    public function cancelOrder(Context $context) {
        echo "Cannot cancel order. It is already paid.\n";
    }

    public function confirmOrder(Context $context) {
        echo "Order is already confirmed.\n";
    }

    public function payOrder(Context $context) {
        echo "Order is already paid.\n";
    }

    public function shipOrder(Context $context) {
        echo "Order shipped.\n";
        $context->setState(new ShippedState());
    }

    public function getStatus(): string {
        return "Paid";
    }
}
