<?php

namespace App\State;

class PendingState implements OrderState {
    public function cancelOrder(Context $context) {
        echo "Order cancelled.\n";
        $context->setState(new CancelledState());
    }

    public function confirmOrder(Context $context) {
        echo "Order confirmed.\n";
        $context->setState(new ConfirmedState());
    }

    public function payOrder(Context $context) {
        echo "Order paid.\n";
        $context->setState(new PaidState());
    }

    public function shipOrder(Context $context) {
        echo "Cannot ship order. Payment pending.\n";
    }

    public function getStatus(): string {
        return "Pending";
    }
}
