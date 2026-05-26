<?php

namespace App\Command\Example;

// 1. Receiver (လက်တွေ့ အလုပ်လုပ်မည့်သူ)
class Light {
    public function turnOn() {
        echo "The light is ON\n";
    }

    public function turnOff() {
        echo "The light is OFF\n";
    }
}
