<?php

namespace App\Decorator;

class SugarDecorator extends CoffeeDecorator {
    public function getCost() {
        return $this->coffee->getCost() + 100;
    }

    public function getDescription() {
        return $this->coffee->getDescription() . ", Sugar";
    }
}
