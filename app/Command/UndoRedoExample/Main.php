<?php

namespace App\Command\UndoRedoExample;

class Main {
    public function run() {
        $doc = new TextDocument();
        $editor = new TextEditor();

        $editor->executeCommand(new TypeCommand($doc, "Hello "));
        $editor->executeCommand(new TypeCommand($doc, "World!"));

        echo "လက်ရှိစာသား: " . $doc->text . "\n";

        echo "\n--- [Ctrl + Z] နှိပ်လိုက်ပြီ (Undo) ---\n";
        $editor->ctrlZ();
        echo "လက်ရှိစာသား: " . $doc->text . "\n";

        echo "\n--- [Ctrl + Z] ထပ်နှိပ်လိုက်ပြီ (Undo) ---\n";
        $editor->ctrlZ();
        echo "လက်ရှိစာသား: " . $doc->text . "\n";

        echo "\n--- [Ctrl + Y] နှိပ်လိုက်ပြီ (Redo) ---\n";
        $editor->ctrlY();
        echo "လက်ရှိစာသား: " . $doc->text . "\n";

        echo "\n--- [Ctrl + Y] ထပ်နှိပ်လိုက်ပြီ (Redo) ---\n";
        $editor->ctrlY();
        echo "လက်ရှိစာသား: " . $doc->text . "\n";
    }
}
