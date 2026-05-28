<?php

namespace App\Strategy;

class CreditCardPayment implements PaymentStrategy {
    private string $cardNumber;

    public function __construct(string $cardNumber) {
        $this->cardNumber = $cardNumber;
    }

    public function pay(int $amount) {
        echo "Paid $amount using Credit Card: {$this->cardNumber}\n";
    }
}
