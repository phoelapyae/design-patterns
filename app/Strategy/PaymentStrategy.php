<?php

namespace App\Strategy;

interface PaymentStrategy {
    public function pay(int $amount);
}
