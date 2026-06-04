<?php

namespace App\Adapter;

class NexmoWrapper implements ThirdPartySmsWrapper {
    public function send(string $to, string $text) {
        echo "Sending via Nexmo to $to: '$text'\n";
    }
}
