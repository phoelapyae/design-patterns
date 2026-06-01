<?php

namespace App\ChainOfResponsibility;

class Main {
    public function run() {
        // Handlers ကို တည်ဆောက်ခြင်း
        $authHandler = new AuthHandler();
        $rateLimitHandler = new RateLimitHandler();
        $dataHandler = new DataHandler();

        // Handlers တွေကို ချိတ်ဆက်ခြင်း
        $authHandler->setNext($rateLimitHandler)->setNext($dataHandler);

        // Request တစ်ခုကို စမ်းသပ်ခြင်း
        $request = [
            'is_logged_in' => true,
            'clicks_per_minute' => 30
        ];

        $authHandler->handle($request);
    }
}


