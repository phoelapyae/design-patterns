<?php

namespace App\State;

class CancelledState implements OrderState {
    public function cancelOrder(Context $context) {
        echo "Order is already cancelled.\n";
    }

    public function confirmOrder(Context $context) {
        echo "Cannot confirm order. It is cancelled.\n";
    }

    public function payOrder(Context $context) {
        echo "Cannot pay for order. It is cancelled.\n";
    }

    public function shipOrder(Context $context) {
        echo "Cannot ship order. It is cancelled.\n";
    }

    public function getStatus(): string {
        return "Cancelled";
    }
}
