<?php

namespace App\Adapter;

// third party services အားလုံးကို ပုံစံတစ်မျိုးတည်း ဖြစ်အောင် အရင်ညှိမည့် Interface
interface ThirdPartySmsWrapper {
    public function send(string $to, string $text);
}
