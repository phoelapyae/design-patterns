<?php

namespace App\Adapter;

class UniversalSmsAdapter implements SmsAdapterInterface {
    private array $providers = [];

    public function __construct() {
        $this->providers = [
            'twilio'   => new TwilioWrapper(),
            'nexmo'    => new NexmoWrapper(),
            'firebase' => new FirebaseWrapper(),
        ];
    }

    public function sendSms(string $providerName, string $to, string $message) {
        $provider = $this->providers[$providerName] ?? null;

        if (!$provider) {
            throw new \Exception("Provider '$providerName' not supported.");
        }

        // ဘာ Provider ပဲဖြစ်ဖြစ် Interface တူသွားပြီမို့ send() ကို တန်းခေါ်ရုံပါပဲ (Polymorphism)
        $provider->send($to, $message);
    }
}
