<?php

namespace App\ChainOfResponsibility;

class DataHandler extends HttpHandler
{
    public function handle($request)
    {
        // Request အချက်အလက်ကို ကုန်ခံပြီး အချက်အလက်များကို ကိုင်တွယ်ပေးပါသည်
        echo 'Data processing completed.'.PHP_EOL;

        return $this->passToNext($request);
    }
}
