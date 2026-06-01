<?php

namespace App\Composite;

class Folder implements FileSystemComponent {
    private string $name;
    private $components = []; // File ကော Folder ကော ထည့်သိမ်းမည့် Array

    public function __construct(string $name) {
        $this->name = $name;
    }

    public function add(FileSystemComponent $component) {
        $this->components[] = $component;
    }

    public function getName() {
        return $this->name;
    }

    // အထဲက ကောင်တွေအားလုံးရဲ့ Size ကို လှည့်ပတ်ပြီး ပေါင်းတွက်ပေးမည်
    public function getSize() {
        $totalSize = 0;
        foreach ($this->components as $component) {
            $totalSize += $component->getSize(); // Recursion သဘောမျိုး အလုပ်လုပ်သွားသည်
        }
        return $totalSize;
    }
}
