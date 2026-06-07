<?php

namespace App\Decorator;

abstract class CoffeeDecorator implements Coffee {
    protected Coffee $coffee;

    public function __construct(Coffee $coffee) {
        $this->coffee = $coffee;
    }

    public function getCost() {
        return $this->coffee->getCost();
    }

    public function getDescription() {
        return $this->coffee->getDescription();
    }
}
