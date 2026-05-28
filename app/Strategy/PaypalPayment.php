<?php

namespace App\Strategy;

class PayPalPayment implements PaymentStrategy {
    private string $email;

    public function __construct(string $email) {
        $this->email = $email;
    }

    public function pay(int $amount) {
        echo "Paid $amount using PayPal account: {$this->email}\n";
    }
}
