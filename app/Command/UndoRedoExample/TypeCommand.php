<?php

namespace App\Command\UndoRedoExample;

class TypeCommand implements Command {
    private $document;
    private $textToType;

    public function __construct(TextDocument $document, $textToType) {
        $this->document = $document;
        $this->textToType = $textToType;
    }

    // စာရိုက်မယ်
    public function execute() {
        $this->document->append($this->textToType);
    }

    // ရိုက်ခဲ့တဲ့စာကို ပြန်ဖျက်ပြီး မူလအခြေအနေ ပြန်လုပ်မယ်
    public function undo() {
        $length = strlen($this->textToType);
        $this->document->erase($length);
    }
}
