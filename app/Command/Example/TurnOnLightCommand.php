<?php

namespace App\Command\Example;

// 3. Concrete Commands (အလုပ်တစ်ခုချင်းစီအတွက် Class ခွဲထုတ်ခြင်း)
class TurnOnLightCommand implements Command {
    private $light;

    public function __construct(Light $light) {
        $this->light = $light;
    }

    public function execute() {
        $this->light->turnOn();
    }
}
