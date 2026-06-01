<?php

namespace App\ChainOfResponsibility;

abstract class HttpHandler
{
    private $nextHandler;

    // နောက်ထပ် ဘယ် Handler လာမလဲဆိုတာ ချိတ်ဆက်ပေးမည့် Method
    public function setNext(HttpHandler $handler): HttpHandler
    {
        $this->nextHandler = $handler;

        return $handler; // Method Chaining လုပ်လို့ရအောင် ပြန်ပေးခြင်း
    }

    // Request ကို နောက်ကောင်ဆီ လွှဲပေးမည့် Method
    protected function passToNext($request)
    {
        if ($this->nextHandler) {
            return $this->nextHandler->handle($request);
        }

        return true; // အားလုံး အောင်မြင်စွာ ဖြတ်သန်းသွားနိုင်လျှင် True ပြန်မည်
    }

    abstract public function handle($request);
}
