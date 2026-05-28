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
