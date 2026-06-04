<?php

namespace App\Adapter;

class Main {
    public function run() {
        $adapter = new UniversalSmsAdapter();

        $adapter->sendSms('nexmo', '1234567890', 'Hello from Nexmo!');

        $adapter->sendSms('twilio', '0987654321', 'Hello from Twilio!');

        $adapter->sendSms('firebase', '5555555555', 'Hello from Firebase!');
    }
}
