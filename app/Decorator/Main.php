<?php

namespace App\Decorator;

class Main {
    public function run() {
        $coffee = new BasicCoffee();
        echo $coffee->getDescription() . " costs " . $coffee->getCost() . " kyats.\n";

        $coffeeWithSugar = new SugarDecorator($coffee);
        echo $coffeeWithSugar->getDescription() . " costs " . $coffeeWithSugar->getCost() . " kyats.\n";

        $coffeeWithMilkAndSugar = new MilkDecorator($coffeeWithSugar);
        echo $coffeeWithMilkAndSugar->getDescription() . " costs " . $coffeeWithMilkAndSugar->getCost() . " kyats.\n";
    }
}
