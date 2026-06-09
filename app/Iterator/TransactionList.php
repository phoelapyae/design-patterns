<?php

namespace App\Iterator;

class TransactionList implements \Iterator {
    private array $transactions = [];
    private int $currentIndex = 0;

    // Data တွေ ထည့်ရန်
    public function addTransaction($transaction) {
        $this->transactions[] = $transaction;
    }

    // ၁။ အစဆုံး နေရာသို့ ပြန်သွားရန်
    public function rewind(): void {
        $this->currentIndex = 0;
    }

    // ၂။ လက်ရှိ နေရာမှာ Data ရှိ/မရှိ စစ်ဆေးရန် (Loop မပတ်ခင် စစ်သည်)
    public function valid(): bool {
        return isset($this->transactions[$this->currentIndex]);
    }

    // ၃။ လက်ရှိ Data ကို ယူရန်
    public function current(): mixed {
        return $this->transactions[$this->currentIndex];
    }

    // ၄။ လက်ရှိ Index (Key) ကို ယူရန်
    public function key(): mixed {
        return $this->currentIndex;
    }

    // ၅။ နောက်ထပ် Data တစ်ခုသို့ ရွှေ့ရန်
    public function next(): void {
        $this->currentIndex++;
    }
}
