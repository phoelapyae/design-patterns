<?php

namespace App\Command\Example;

class Main {
    public function run() {
        // 4. Invoker (ခလုတ် သို့မဟုတ် စေခိုင်းသူ)
        $remote = new RemoteControl();

        // 1. Receiver (လက်တွေ့ အလုပ်လုပ်မည့်သူ)
        $light = new Light();

        // 2. Command Objects
        $turnOn = new TurnOnLightCommand($light);
        $turnOff = new TurnOffLightCommand($light);

        // မီးဖွင့်မယ်
        $remote->setCommand($turnOn);
        $remote->pressButton(); // Output: The light is ON

        // မီးပိတ်မယ်
        $remote->setCommand($turnOff);
        $remote->pressButton(); // Output: The light is OFF
    }
}
