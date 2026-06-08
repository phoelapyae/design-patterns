<?php

namespace App\Factory;

class WaveMoney implements PaymentMethod {
    public function pay(int $amount) {
        echo "Paid $amount MMK using Wave Money.\n";
    }
}
