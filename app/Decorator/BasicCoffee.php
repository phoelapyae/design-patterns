<?php

namespace App\Decorator;

class BasicCoffee implements Coffee {
    public function getCost() {
        return 1000; // ရိုးရိုးကော်ဖီ ဈေးနှုန်း ၁၀၀၀ ကျပ်
    }
    public function getDescription() {
        return "Basic Coffee";
    }
}
