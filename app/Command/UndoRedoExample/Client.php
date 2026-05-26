<?php

namespace App\Command\UndoRedoExample;

$doc = new TextDocument();
$editor = new TextEditor();

// အဆင့် ၁: "Hello " လို့ ရိုက်မယ်
$editor->executeCommand(new TypeCommand($doc, "Hello "));
// အဆင့် ၂: "World!" လို့ ထပ်ရိုက်မယ်
$editor->executeCommand(new TypeCommand($doc, "World!"));

echo "လက်ရှိစာသား: " . $doc->text . "\n";
// Output: Hello World!

echo "\n--- [Ctrl + Z] နှိပ်လိုက်ပြီ (Undo) ---\n";
$editor->ctrlZ();
echo "လက်ရှိစာသား: " . $doc->text . "\n";
// Output: Hello (World! ဆိုတာ ပျောက်သွားပြီ)

echo "\n--- [Ctrl + Z] ထပ်နှိပ်လိုက်ပြီ (Undo) ---\n";
$editor->ctrlZ();
echo "လက်ရှိစာသား: " . $doc->text . "\n";
// Output: (ဗလာဖြစ်သွားပြီ၊ Hello ပါ ပျောက်သွားပြီ)

echo "\n--- [Ctrl + Y] နှိပ်လိုက်ပြီ (Redo) ---\n";
$editor->ctrlY();
echo "လက်ရှိစာသား: " . $doc->text . "\n";
// Output: Hello (စောစောက ဖျက်လိုက်တဲ့ Hello ပြန်ပေါ်လာပြီ)

echo "\n--- [Ctrl + Y] ထပ်နှိပ်လိုက်ပြီ (Redo) ---\n";
$editor->ctrlY();
echo "လက်ရှိစာသား: " . $doc->text . "\n";
// Output: Hello World! (World! ပါ ပြန်ပေါ်လာပြီး မူလအတိုင်း ပြန်ဖြစ်သွားပြီ)
