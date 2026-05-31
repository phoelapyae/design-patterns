<?php

namespace App\State;

class ConfirmedState implements OrderState {
    public function cancelOrder(Context $context) {
        echo "Order cancelled.\n";
        $context->setState(new CancelledState());
    }

    public function confirmOrder(Context $context) {
        echo "Order is already confirmed.\n";
    }

    public function payOrder(Context $context) {
        echo "Order paid.\n";
        $context->setState(new PaidState());
    }

    public function shipOrder(Context $context) {
        echo "Cannot ship order. Payment pending.\n";
    }

    public function getStatus(): string {
        return "Confirmed";
    }
}
