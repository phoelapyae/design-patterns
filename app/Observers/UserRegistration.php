<?php

namespace App\Observers;

class UserRegistration implements Subject
{
    private $observers = [];
    public $userData;

    // စောင့်ကြည့်မည့်သူကို စာရင်းသွင်းခြင်း (Subscribe)
    public function attach(Observer $observer)
    {
        $this->observers[] = $observer;
    }

    // စောင့်ကြည့်မည့်သူကို စာရင်းမှ ဖယ်ရှားခြင်း (Unsubscribe)
    public function detach(Observer $observer)
    {
        $index = array_search($observer, $this->observers);
        if ($index !== false) {
            unset($this->observers[$index]);
        }
    }

    // စောင့်ကြည့်မည့်သူများအား အသိပေးခြင်း (Notify)
    public function notify()
    {
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }


    // အသုံးပြုသူအသစ်ကို မှတ်ပုံတင်ခြင်း (Register a new user)
    public function registerUser(string $name, string $email)
    {
        echo "Registering user: $name with email: $email\n";

        $this->userData = ['name' => $name, 'email' => $email];

        // Notify observers about the new user registration
        $this->notify();
    }
}
