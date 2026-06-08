<?php

namespace App\Factory;

class Main {
    public static function run() {
        try {
            $payment1 = PaymentFactory::createPayment('kpay');
            $payment1->pay(5000);

            $payment2 = PaymentFactory::createPayment('wave');
            $payment2->pay(3000);
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage() . "\n";
        }
    }
}
