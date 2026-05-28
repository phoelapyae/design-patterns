<?php

namespace App\Template\Example2;

abstract class SocialMediaPost {
    // ဤအဆင့်ဆင့် (Workflow) အတိုင်းပဲ မောင်းနှင်ရမယ်
    final public function share() {
        $this->authenticate();
        $this->formatContent(); // ဤအဆင့်ကိုပဲ Subclass က ပြင်မယ်
        $this->publish();
    }

    protected function authenticate() { echo "Logging in...\n"; }

    abstract protected function formatContent();

    protected function publish() { echo "Posted successfully!\n"; }
}
