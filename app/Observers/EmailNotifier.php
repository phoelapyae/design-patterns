<?php

namespace App\Observers;

class EmailNotifier implements Observer
{
    public function update(Subject $subject)
    {
        if ($subject instanceof UserRegistration) {

            $userData = $subject->userData;

            echo "Sending email notification for new user registration: " . $userData['email'] . "\n";
        }
    }
}
