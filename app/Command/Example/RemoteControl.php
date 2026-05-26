<?php

namespace App\Command\Example;

// 4. Invoker (ခလုတ် သို့မဟုတ် စေခိုင်းသူ)
class RemoteControl {
    private $command;

    public function setCommand(Command $command) {
        $this->command = $command;
    }

    public function pressButton() {
        $this->command->execute();
    }
}

// --- လက်တွေ့ အသုံးပြုပုံ (Client Code) ---
$light = new Light(); // Receiver

$turnOn = new TurnOnLightCommand($light);
$turnOff = new TurnOffLightCommand($light);

$remote = new RemoteControl(); // Invoker

// မီးဖွင့်မယ်
$remote->setCommand($turnOn);
$remote->pressButton(); // Output: The light is ON

// မီးပိတ်မယ်
$remote->setCommand($turnOff);
$remote->pressButton(); // Output: The light is OFF
