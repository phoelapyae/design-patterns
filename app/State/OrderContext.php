<?php

namespace App\State;

class OrderContext {
    private OrderState $state;

    public function __construct() {
        $this->state = new PendingState();
    }

    public function setState(OrderState $state) {
        $this->state = $state;
    }

    public function cancelOrder() {
        $this->state->cancelOrder($this);
    }

    public function confirmOrder() {
        $this->state->confirmOrder($this);
    }

    public function payOrder() {
        $this->state->payOrder($this);
    }

    public function shipOrder() {
        $this->state->shipOrder($this);
    }

    public function getStatus(): string {
        return $this->state->getStatus();
    }
}
