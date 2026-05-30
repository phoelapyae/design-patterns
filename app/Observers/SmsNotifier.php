<?php

namespace App\Observers;

class SmsNotifier implements Observer
{
    public function update(Subject $subject)
    {
        if ($subject instanceof UserRegistration) {
            $userData = $subject->userData;
            echo "Sending SMS notification for new user registration: " . $userData['name'] . "\n";
        }
    }
}
