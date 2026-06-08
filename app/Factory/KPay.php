<?php

namespace App\Factory;

class KPay implements PaymentMethod {
    public function pay(int $amount) {
        echo "Paid $amount MMK using KBZ Pay.\n";
    }
}
