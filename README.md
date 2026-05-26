Command Design Pattern ဆိုတာ Gang of Four (GoF) ရဲ့ Behavioral Design Pattern တစ်ခု ဖြစ်ပါတယ်။

သူ့ရဲ့ အဓိက ရည်ရွယ်ချက်ကတော့ လုပ်ဆောင်ချက်တစ်ခု (An action or request) ကို သီးသန့် Object တစ်ခုအနေနဲ့ ပြောင်းလဲပစ်လိုက်တာ (Encapsulate) ဖြစ်ပါတယ်။

ရိုးရိုးရှင်းရှင်း ဥပမာပေးရရင် - စားသောက်ဆိုင်တစ်ဆိုင်ကို သွားတဲ့အခါ သင် (Client) က စားပွဲထိုး (Invoker) ဆီမှာ ဟင်းမှာပါတယ်။ စားပွဲထိုးက မှာတဲ့ဟင်းတွေကို "Order စာရွက်" (Command) ထဲမှာ ရေးမှတ်လိုက်ပြီး မီးဖိုချောင်က စားဖိုမှူး (Receiver) ဆီ သွားပေးပါတယ်။
ဒီနေရာမှာ "Order စာရွက်" က Command Object ပါပဲ။ အဲဒီစာရွက်ထဲမှာ ဘယ်သူက ဘာလုပ်ရမယ်ဆိုတဲ့ အချက်အလက်တွေ အကုန်ပါပြီးသားဖြစ်လို့ စားပွဲထိုးက စားဖိုမှူး ဘယ်လိုချက်လဲ သိစရာမလိုသလို၊ စားဖိုမှူးကလည်း ဘယ်စားပွဲက မှာလဲ တိုက်ရိုက်သိစရာမလိုဘဲ စာရွက်အတိုင်း ချက်ပေးရုံပါပဲ။

## Command Pattern ရဲ့ အဓိက အစိတ်အပိုင်း ၄ ခု

1. Command (Interface/Abstract): လုပ်မယ့် အလုပ်အတွက် execute() Method ကို သတ်မှတ်ပေးထားတဲ့နေရာ။

2. Concrete Command: Command Interface ကို လက်တွေ့ အကောင်အထည်ဖော်ပြီး Receiver နဲ့ ချိတ်ဆက်ပေးတဲ့ Class။

3. Receiver: လက်တွေ့အလုပ်လုပ်မယ့် Business Logic တွေရှိတဲ့ Class (ဥပမာ - စားဖိုမှူး)။

4. Invoker: Command ကို သိမ်းထားပြီး ဘယ်အချိန်မှာ execute() လုပ်ရမလဲဆိုတာကို နှိုးဆော်ပေးတဲ့ Class (ဥပမာ - စားပွဲထိုး)။

## PHP နဲ့ ရိုးရှင်းတဲ့ ဥပမာတစ်ခု ကြည့်ရအောင်

မီးခလုတ်တစ်ခုကို နှိပ်ရင် မီးလင်းမယ်၊ မီးပိတ်မယ်ဆိုတဲ့ စနစ်တစ်ခုကို ရေးကြည့်ပါမယ်။

```
// 1. Receiver (လက်တွေ့ အလုပ်လုပ်မည့်သူ)
class Light {
    public function turnOn() { echo "The light is ON\n"; }
    public function turnOff() { echo "The light is OFF\n"; }
}

// 2. Command Interface
interface Command {
    public function execute();
}

// 3. Concrete Commands (အလုပ်တစ်ခုချင်းစီအတွက် Class ခွဲထုတ်ခြင်း)
class TurnOnLightCommand implements Command {
    private $light;

    public function __construct(Light $light) {
        $this->light = $light;
    }

    public function execute() {
        $this->light->turnOn();
    }
}

class TurnOffLightCommand implements Command {
    private $light;

    public function __construct(Light $light) {
        $this->light = $light;
    }

    public function execute() {
        $this->light->turnOff();
    }
}

// 4. Invoker (ခလုတ် သို့မဟုတ် စေခိုင်းသူ)
class RemoteControl {
    private $command;

    public function setCommand(Command $command) {
        $this->command = $command;
    }

    public function pressButton() {
        $this->command->execute();
    }
}

// --- လက်တွေ့ အသုံးပြုပုံ (Client Code) ---
$light = new Light(); // Receiver

$turnOn = new TurnOnLightCommand($light);
$turnOff = new TurnOffLightCommand($light);

$remote = new RemoteControl(); // Invoker

// မီးဖွင့်မယ်
$remote->setCommand($turnOn);
$remote->pressButton(); // Output: The light is ON

// မီးပိတ်မယ်
$remote->setCommand($turnOff);
$remote->pressButton(); // Output: The light is OFF
```

## Laravel Framework မှာ Command Pattern ကို ဘယ်လိုသုံးလဲ?

Laravel မှာ Command Pattern ကို အဓိကနေရာ နှစ်ခုမှာ အလွန်အင်မတန် အားကိုးပြီး သုံးထားတာ တွေ့ရပါလိမ့်မယ်။

၁။ Artisan Console Commands

ကျွန်တော်တို့ php artisan make:model တို့ php artisan migrate တို့ ရိုက်လိုက်တဲ့အခါ ၎င်း Command တစ်ခုချင်းစီဟာ သီးသန့် Class တစ်ခုစီ ဖြစ်သွားပါတယ်။

```
// app/Console/Commands/SendEmails.php
namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendEmails extends Command
{
    // ဒါက Command ရဲ့ နာမည် (Invoker က ဒါကိုကြည့်ပြီး ခေါ်မယ်)
    protected $signature = 'email:send {user}'; 

    // ဒါက GoF ရဲ့ execute() method နဲ့ အတူတူပဲ ဖြစ်ပါတယ်
    public function handle()
    {
        $userId = $this->argument('user');
        // အီးမေးလ်ပို့မည့် Business Logic (Receiver ဆီ လှမ်းခေါ်တာမျိုး လုပ်မယ်)
        $this->info("Emails sent to user: " . $userId);
    }
}
```

၂။ Jobs နှင့် Queues (အလုပ်များကို နောက်ကွယ်မှာ ခိုင်းခြင်း)

Laravel ရဲ့ Queue System က Command Pattern ရဲ့ အကောင်းဆုံး ပြယုဂ်တစ်ခုပါ။ လုပ်ဆောင်ရမယ့် အလုပ်တစ်ခုလုံး (ဥပမာ - PDF ထုတ်တာ၊ အီးမေးလ်အစောင် ၁၀၀၀ ပို့တာ) ကို Job ဆိုတဲ့ Object တစ်ခုထဲ ထုပ်ပိုး (Encapsulate) လိုက်ပါတယ်။ ပြီးရင် Queue (Invoker) ထဲ ပစ်ထည့်လိုက်ပြီး နောက်ကွယ်က Worker ကမှ တစ်ဆင့်ချင်းစီ handle() (Execute) လုပ်သွားတာ ဖြစ်ပါတယ်။

```
// Job တစ်ခု ဆောက်လိုက်ခြင်း (ဒါဟာ Concrete Command ပါပဲ)
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessPodcast implements ShouldQueue
{
    use Dispatchable, Queueable;

    protected $podcast;

    public function __construct($podcast) {
        $this->podcast = $podcast;
    }

    // GoF ရဲ့ execute() နေရာမှာ Laravel က handle() ကို သုံးပါတယ်
    public function handle() {
        // ပေါ့ဒ်ကတ်စ်ကို ဗီဒီယိုပြောင်းလဲမည့် လုပ်ဆောင်ချက်များ...
    }
}

// ကုတ်ထဲကနေ လှမ်းခေါ်သုံးစွဲပုံ (Client Code)
ProcessPodcast::dispatch($podcast);
```

## ဘာကြောင့် သုံးသင့်လဲ? (အကျိုးကျေးဇူးများ)

- Decoupling: အမိန့်ပေးတဲ့သူ (Invoker) နဲ့ အလုပ်လုပ်တဲ့သူ (Receiver) ကြားမှာ တိုက်ရိုက် မပတ်သက်တော့လို့ ကုဒ်တွေ ရှုပ်ထွေးမနေတော့ပါဘူး။

- Undo/Redo: Command တွေကို Object အနေနဲ့ သိမ်းထားတဲ့အတွက် သမိုင်းကြောင်း (History) အနေနဲ့ သိမ်းထားပြီး မူလအတိုင်း ပြန်ပြင်တာ (Undo) မျိုးတွေ အလွယ်တကူ လုပ်နိုင်ပါတယ်။

- Queueing: လုပ်ဆောင်ချက်တွေကို Array ထဲထည့်ပြီး တစ်ခုပြီးမှတစ်ခု (Queue ပုံစံ) အလှည့်ကျ ခိုင်းစေလို့ ရသွားပါတယ်။

Command Design Pattern ကို သုံးပြီး Undo (နောက်ပြန်ဆုတ်တာ) နဲ့ Redo (ရှေ့ပြန်တက်တာ) ကို ဘယ်လိုလုပ်လဲဆိုတာကို နားလည်ရလွယ်ဆုံး ဥပမာတစ်ခုနဲ့ ရှင်းပြပေးပါမယ်။

ကျွန်တော်တို့ စာရိုက်တဲ့ Text Editor (ဥပမာ - Notepad သို့မဟုတ် MS Word) တစ်ခုကို စိတ်ကူးထဲ မြင်ကြည့်ပါ။ ကျွန်တော်တို့ စာရိုက်လိုက်၊ ဖျက်လိုက် လုပ်သမျှ အလုပ် (Action) တိုင်းကို Command Object တစ်ခုစီအဖြစ် ပြောင်းလဲပြီး စာရွက်စာတမ်းတွဲ (History Stack) တစ်ခုထဲကို အစဉ်လိုက် စီထည့်ထားလိုက်တာ ဖြစ်ပါတယ်။

## PHP နဲ့ ရိုးရှင်းတဲ့ ဥပမာတစ်ခု ကြည့်ရအောင်

ဒီဥပမာမှာ စာသားတွေ သိမ်းမယ့် နေရာရယ်၊ စာရိုက်တဲ့ Command ရယ်၊ ပြီးတော့ Undo/Redo လုပ်ပေးမယ့် Application (Invoker) ရယ်ကို တည်ဆောက်သွားပါမယ်။

၁။ Receiver (လက်တွေ့ Text တွေကို သိမ်းဆည်းပေးမည့်သူ)

```
class TextDocument {
    public $text = "";

    public function append($newText) {
        $this->text .= $newText;
    }

    public function erase($length) {
        $this->text = substr($this->text, 0, -$length);
    }
}
```

၂။ Command Interface (Undo ပါ ထည့်သွင်းစဉ်းစားထားသည်)

ပုံမှန် Command တွေမှာ execute() တစ်ခုပဲ ပါပေမယ့် အခု Undo လုပ်မှာဖြစ်လို့ undo() Method ပါ ထည့်ပေးရပါမယ်။

```
interface Command {
    public function execute();
    public function undo();
}
```

၃။ Concrete Command (စာရိုက်သည့် အလုပ်)

ဒီ Class ထဲမှာ execute() လုပ်ရင် စာရိုက်မယ်၊ undo() လုပ်ရင် အဲဒီရိုက်လိုက်တဲ့ စာကို ပြန်ဖျက်မယ်ဆိုပြီး ရေးထားပါတယ်။

```
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
```

၄။ Invoker (History ကို Stack နဲ့ သိမ်းဆည်းပေးမည့် Application)

ဒီကောင်က လုပ်သမျှ Command တွေကို Array (Stack) ထဲမှာ သမိုင်းကြောင်းအဖြစ် သိမ်းထားပေးမှာ ဖြစ်ပါတယ်။

```
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
```

## လက်တွေ့ စမ်းသပ်ကြည့်ခြင်း (Client Code)

အခုဆိုရင် စာရိုက်မယ်၊ Undo လုပ်မယ်၊ ပြီးရင် Redo ပြန်လုပ်ကြည့်ပါမယ်။

```
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
```

## ရှင်းလင်းချက် အနှစ်ချုပ်

ဒီဥပမာမှာ ဘာကြောင့် Undo လုပ်ရတာ လွယ်သွားလဲဆိုရင် -

- $editor->history ထဲမှာ ["Hello " ရိုက်ခဲ့တဲ့ Object], ["World!" ရိုက်ခဲ့တဲ့ Object] ဆိုပြီး သမိုင်းကြောင်း (History) ရှိနေလို့ပါ။

- Ctrl+Z နှိပ်လိုက်တဲ့အခါ နောက်ဆုံးဝင်နေတဲ့ ["World!" ရိုက်ခဲ့တဲ့ Object] ကို ဆွဲထုတ်ပြီး သူ့ထဲက undo() method ကို နှိုးလိုက်ရုံပါပဲ။

- undo() က သူ့ဘာသာသူ "ဪ... ငါ World! ဆိုတဲ့ စာလုံး ၆ လုံး ရိုက်ခဲ့တာပဲ၊ အဲဒါဆို ၆ လုံး ပြန်ဖျက်လိုက်မယ်" ဆိုပြီး နောက်ကွယ်မှာ တွက်ချက်သွားတာ ဖြစ်ပါတယ်။

- Redo (Ctrl+Y) လုပ်ရင်: Redo Stack ရဲ့ ထိပ်ဆုံးကအကောင်ကို နှိုက်ယူ၊ ပြန်လုပ် (Execute)၊ ပြီးရင် Undo Stack ထဲကို ပြန်ပစ်ထည့်မယ်။
