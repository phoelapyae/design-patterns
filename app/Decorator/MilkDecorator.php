<?php

namespace App\Decorator;

class MilkDecorator extends CoffeeDecorator {
    public function getCost() {
        return $this->coffee->getCost() + 300;
    }

    public function getDescription() {
        return $this->coffee->getDescription() . ", Milk";
    }
}
