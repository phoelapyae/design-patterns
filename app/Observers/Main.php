<?php

namespace App\Observers;

class Main {
    public function run() {
        $registration = new UserRegistration();

        $emailListener = new EmailNotifier();
        $smsListener = new SmsNotifier();

        // ဘာတွေလုပ်ပေးရမလဲဆိုပြီး စာရင်းလာသွင်းထားကြတယ် (Attach)
        $registration->attach($emailListener);
        $registration->attach($smsListener);

        // User တစ်ယောက် အကောင့်ဖွင့်လိုက်ပြီ
        $registration->registerUser("John Doe", "john.doe@example.com");
    }
}
