<?php

namespace App\Strategy;

class ShoppingCart {
    private int $amount = 0;
    private PaymentStrategy $paymentMethod;

    public function __construct(int $amount) {
        $this->amount = $amount;
    }

    public function setPaymentMethod(PaymentStrategy $method) {
        $this->paymentMethod = $method;
    }

    public function checkout() {
        $this->paymentMethod->pay($this->amount);
    }
}
