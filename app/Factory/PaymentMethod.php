<?php

namespace App\Factory;

interface PaymentMethod {
    public function pay(int $amount);
}
