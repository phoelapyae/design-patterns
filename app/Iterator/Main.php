<?php

namespace App\Iterator;

class Main {
    public function run() {
        $list = new TransactionList();
        $list->addTransaction("TRX-001: Sent $100 to Thailand");
        $list->addTransaction("TRX-002: Received $500 from Australia");
        $list->addTransaction("TRX-003: Sent $200 to Vietnam");

        // Client က နောက်ကွယ်က index တွေကို တိုက်ရိုက်ခေါ်စရာမလိုဘဲ foreach နဲ့ အလွယ်တကူ ပတ်လို့ရသွားပါပြီ
        foreach ($list as $key => $transaction) {
            echo "[$key] $transaction\n";
        }
        // ဤနေရာတွင် foreach သည် နောက်ကွယ်၌ rewind(), valid(), current(), next() တို့ကို အလိုအလျောက် ခေါ်ယူသွားခြင်းဖြစ်သည်။
    }
}
