<?php

namespace App\Command\UndoRedoExample;

// Receiver (လက်တွေ့ Text တွေကို သိမ်းဆည်းပေးမည့်သူ)
class TextDocument {
    public $text = "";

    public function append($newText) {
        $this->text .= $newText;
    }

    public function erase($length) {
        $this->text = substr($this->text, 0, -$length);
    }
}
