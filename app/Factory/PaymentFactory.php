<?php

namespace App\Factory;

class PaymentFactory {
    public static function createPayment(string $type): PaymentMethod {
        switch (strtolower($type)) {
            case 'kpay':
                return new KPay();
            case 'wave':
                return new WaveMoney();
            default:
                throw new \Exception("Payment method '$type' is not supported.");
        }
    }
}
