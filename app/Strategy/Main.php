<?php

namespace App\Strategy;

class Main {
    public function run() {
        $cart = new ShoppingCart(100);

        $cart->setPaymentMethod(new CreditCardPayment('1234-5678-9012-3456'));
        $cart->checkout();

        $cart->setPaymentMethod(new PayPalPayment('user@example.com'));
        $cart->checkout();
    }
}
