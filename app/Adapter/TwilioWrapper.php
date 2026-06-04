<?php

namespace App\Adapter;

class TwilioWrapper implements ThirdPartySmsWrapper {
    public function send(string $to, string $text) {
        echo "Sending via Twilio to $to: '$text'\n";
    }
}
