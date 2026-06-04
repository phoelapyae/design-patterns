<?php

namespace App\Adapter;

// Client (ကျွန်တော်တို့ App) ဘက်က လှမ်းခေါ်မည့် ပင်မ Adapter Interface
interface SmsAdapterInterface {
    public function sendSms(string $provider, string $to, string $message);
}
