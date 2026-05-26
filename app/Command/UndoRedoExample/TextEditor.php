<?php

namespace App\Command\UndoRedoExample;

// Receiver နဲ့ Command Interface/Classes များက အရင်အတိုင်း ဖြစ်ပါတယ်...

class TextEditor {
    private $undoHistory = []; // Undo လုပ်ဖို့ သိမ်းတဲ့ Stack
    private $redoHistory = []; // Redo လုပ်ဖို့ သိမ်းတဲ့ Stack

    // ၁။ စာရိုက်ခြင်း (အမိန့်အသစ် ပေးခြင်း)
    public function executeCommand(Command $command) {
        $command->execute();
        $this->undoHistory[] = $command; // History ထဲ ထည့်မယ်

        // စာအသစ်ရိုက်လိုက်ရင် အဟောင်းတွေအတွက် Redo လုပ်လို့မရတော့လို့ Redo Stack ကို ဖျက်ပစ်မယ်
        $this->redoHistory = [];
    }

    // ၂။ နောက်ပြန်ဆုတ်ခြင်း (Undo / Ctrl + Z)
    public function ctrlZ() {
        if (!empty($this->undoHistory)) {
            $command = array_pop($this->undoHistory); // နောက်ဆုံးလုပ်ခဲ့တဲ့ အလုပ်ကို ယူမယ်
            $command->undo();                         // အလုပ်ကို နောက်ပြန်ဆုတ်မယ်

            $this->redoHistory[] = $command;          // ဆုတ်လိုက်တဲ့ အလုပ်ကို Redo Stack ထဲ ရွှေ့ထားမယ်
        } else {
            echo "Nothing to undo!\n";
        }
    }

    // ၃။ ရှေ့ပြန်တက်ခြင်း (Redo / Ctrl + Y)
    public function ctrlY() {
        if (!empty($this->redoHistory)) {
            $command = array_pop($this->redoHistory); // Undo လုပ်ထားခဲ့တဲ့ အလုပ်ကို ပြန်ယူမယ်
            $command->execute();                      // အဲဒီအလုပ်ကို ပြန်လုပ်ခိုင်းမယ်

            $this->undoHistory[] = $command;          // ပြီးရင် သူ့ကို Undo Stack ထဲ ပြန်ထည့်မယ်
        } else {
            echo "Nothing to redo!\n";
        }
    }
}
