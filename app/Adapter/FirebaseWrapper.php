<?php

namespace App\Adapter;

class FirebaseWrapper implements ThirdPartySmsWrapper {
    public function send(string $to, string $text) {
        echo "Sending via Firebase Notification to $to: '$text'\n";
    }
}
