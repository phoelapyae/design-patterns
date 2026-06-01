<?php

namespace App\ChainOfResponsibility;

class RateLimitHandler extends HttpHandler
{
    public function handle($request)
    {
        if ($request['clicks_per_minute'] > 60) {
            echo "Error 429: Too many requests!\n";

            return false; // ဒီအဆင့်မှာတင် ကုဒ်ကို ရပ်ပစ်လိုက်ခြင်း (Breaking the chain)
        }

        return $this->passToNext($request); // အဆင်ပြေရင် နောက်တစ်ဆင့်ကို လွှဲမယ်
    }
}
