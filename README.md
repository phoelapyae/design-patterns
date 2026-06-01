Composite Design Pattern ဆိုတာ Gang of Four (GoF) ရဲ့ Structural Design Pattern တစ်ခု ဖြစ်ပါတယ်။

***သူ့ရဲ့ အဓိက ရည်ရွယ်ချက်ကတော့ အရာဝတ္ထုတစ်ခုချင်းစီ (Individual Objects) နဲ့ ၎င်းတို့ကို စုစည်းထားတဲ့ အစုအဖွဲ့ (Collection of Objects) တွေကို ပုံစံတူ တစ်ပြေးညီ (Uniformly) ခေါ်သုံးလို့ရအောင် သစ်ပင်ကဲ့သို့ အဆင့်ဆင့်တည်ဆောက်ပုံ (Tree Structure) ဖြင့် ဖွဲ့စည်းတည်ဆောက်တာ ဖြစ်ပါတယ်။***

ရိုးရိုးရှင်းရှင်း ဥပမာပေးရရင် - ကွန်ပျူတာထဲက File System (ဖိုင်စနစ်) ကို မြင်ကြည့်ပါ။

ကွန်ပျူတာထဲမှာ File (ဖိုင်) တွေ ရှိသလို၊ Folder (ဖိုင်တွဲ) တွေလည်း ရှိပါတယ်။

File တစ်ခုချင်းစီက သီးသန့် Object (Leaf/အဖျားအမြှောက်) ဖြစ်ပြီး၊ Folder ကတော့ ထဲမှာ File တွေကော တခြား Folder တွေကော ထပ်ထည့်နိုင်တဲ့ အစုအဖွဲ့ (Composite) ဖြစ်ပါတယ်။

သင်က File တစ်ခုရဲ့ Size ကို ကြည့်ချင်ရင်လည်း getSize() လို့ပဲ ခေါ်မှာဖြစ်သလို၊ Folder တစ်ခုလုံးရဲ့ Size ကို ကြည့်ချင်ရင်လည်း getSize() လို့ပဲ ခေါ်မှာပါ။ Folder ရဲ့ getSize() က သူ့အထဲမှာ ရှိသမျှ File တွေရဲ့ Size ကို အလိုအလျောက် ပေါင်းတွက်ပေးသွားမှာ ဖြစ်ပါတယ်။ Client (အသုံးပြုသူ) ဘက်ကကြည့်ရင် File ကော Folder ကောကို တစ်ပြေးညီ ခေါ်သုံးသွားတာ ဖြစ်ပါတယ်။

# PHP နဲ့ ရိုးရှင်းတဲ့ ဥပမာတစ်ခု ကြည့်ရအောင်

အပေါ်ကပြောခဲ့တဲ့ File နဲ့ Folder စနစ်ကို PHP ကုဒ်နဲ့ တည်ဆောက်ကြည့်ပါမယ်။

## ၁။ Component Interface ဆောက်ခြင်း (ပုံစံတူ သတ်မှတ်ချက်)

```
interface FileSystemComponent {
    public function getName();
    public function getSize(); // ဤ Method ကို နှစ်ခုစလုံးက တစ်ပြေးညီ သုံးမည်
}
```

## ၂။ Leaf Object (တစ်ခုချင်းစီ သီးသန့်ရှိသော File Class)

```
class File implements FileSystemComponent {
    private $name;
    private $size;

    public function __construct($name, $size) {
        $this->name = $name;
        $this->size = $size;
    }

    public function getName() { return $this->name; }
    public function getSize() { return $this->size; }
}
```

## ၃။ Composite Object (အစုအဖွဲ့ဖြစ်သော Folder Class)

```
class Folder implements FileSystemComponent {
    private $name;
    private $components = []; // File ကော Folder ကော ထည့်သိမ်းမည့် Array

    public function __construct($name) {
        $this->name = $name;
    }

    public function add(FileSystemComponent $component) {
        $this->components[] = $component;
    }

    public function getName() { return $this->name; }

    // အထဲက ကောင်တွေအားလုံးရဲ့ Size ကို လှည့်ပတ်ပြီး ပေါင်းတွက်ပေးမည်
    public function getSize() {
        $totalSize = 0;
        foreach ($this->components as $component) {
            $totalSize += $component->getSize(); // Recursion သဘောမျိုး အလုပ်လုပ်သွားသည်
        }
        return $totalSize;
    }
}
```

လက်တွေ့ အသုံးပြုပုံ (Client Code)

```
// File များ ဆောက်ခြင်း
$file1 = new File("photo.jpg", 500); // 500 KB
$file2 = new File("resume.pdf", 200); // 200 KB
$file3 = new File("notes.txt", 100);  // 100 KB

// Folder ဆောက်ပြီး File များ ထည့်ခြင်း
$subFolder = new Folder("My Documents");
$subFolder->add($file2);
$subFolder->add($file3); // subFolder size = 200 + 100 = 300 KB

$rootFolder = new Folder("C: Drive");
$rootFolder->add($file1);
$rootFolder->add($subFolder); // rootFolder size = 500 + 300 = 800 KB

// Client က File ရော Folder ကိုပါ getSize() ဆိုပြီး တစ်ပြေးညီ လှမ်းခေါ်ရုံပါပဲ
echo "File 1 Size: " . $file1->getSize() . " KB\n";       // Output: 500 KB
echo "Root Folder Size: " . $rootFolder->getSize() . " KB\n"; // Output: 800 KB
```

# Laravel Framework မှာ Composite Pattern ကို ဘယ်လိုသုံးလဲ?

Laravel ရဲ့ Architecture အောက်ခြေမှာ Composite Pattern ကို အဓိကနေရာ နှစ်ခုမှာ ထင်ထင်ရှားရှား မြင်တွေ့နိုင်ပါတယ်။

## ၁။ Blade Components (Nested Elements)

Laravel ရဲ့ Blade Template မှာ Component တွေကို တစ်ခုထဲမှာ တစ်ခု ထပ်ဆင့် (Nested) ပြီး ရေးတာဟာ Composite Pattern ပါပဲ။

```
<x-form action="/submit">
    <x-input name="username" label="Username" />
    <x-input name="password" type="password" label="Password" />
    <x-button>Login</x-button>
</x-form>
```

နောက်ကွယ်မှာ Laravel က x-form ကို Render လုပ်တဲ့အခါ သူ့အထဲမှာ ရှိသမျှ သီးသန့် Component အငယ်လေးတွေအားလုံးကိုပါ အလိုအလျောက် လှည့်ပတ်ပြီး Render လုပ်ပေးသွားတာ ဖြစ်ပါတယ်။

## ၂။ Validation Rules (Nested Array Validation)

Laravel မှာ Request တွေကို Validate လုပ်တဲ့အခါ Array logic တွေမှာ Composite သဘောတရား ပါဝင်ပါတယ်။

```
$request->validate([
    'person' => 'required|array',
    'person.name' => 'required|string',
    'person.email' => 'required|email',
]);
```

Laravel ရဲ့ Validator စနစ်က 'person' ဆိုတဲ့ အစုအဖွဲ့ကြီးကို စစ်ဆေးသလို၊ သူ့အထဲက sub-elements တွေကိုလည်း တစ်ပြေးညီ စစ်ဆေးသွားတာ ဖြစ်ပါတယ်။

# အားသာချက်များနှင့် အားနည်းချက်များ (Pros & Cons)

## ကောင်းကွက်များ (Pros)

- Uniformity (တစ်ပြေးညီဖြစ်ခြင်း): Client Code က ဒါဟာ Component အsingle လား ဒါမှမဟုတ် အစုအဖွဲ့ (Composite) လားဆိုတာ ခွဲခြားပြီး if-else ပတ်နေစရာ မလိုပါဘူး။ နှစ်ခုစလုံးကို Method တစ်ခုတည်းနဲ့ တန်းခေါ်သုံးနိုင်ပါတယ်။

- Open/Closed Principle: စနစ်ထဲကို Leaf အသစ်တွေ (ဥပမာ- VideoFile Class) သို့မဟုတ် Composite အသစ်တွေ ထပ်တိုးချင်ရင် ရှိပြီးသားကုဒ်တွေကို လိုက်ပြင်စရာမလိုဘဲ အလွယ်တကူ တိုးချဲ့နိုင်ပါတယ်။

- Tree Structures: အဆင့်ဆင့် အကိုင်းအခက် ဖြာထွက်နေတဲ့ ဒေတာဖွဲ့စည်းပုံတွေကို ကိုင်တွယ်ရတာ အရမ်းလွယ်ကူ သန့်ရှင်းသွားစေပါတယ်။

## ဆိုးကွက်များ (Cons)

- Over-generalization (ဒီဇိုင်း ပျော့ပျောင်းလွန်းခြင်း): Interface တစ်ခုတည်းအောက်မှာ အကုန်ပုံသွင်းထားလို့ တစ်ခါတရံမှာ Folder ထဲကို File ပဲ ထည့်ခွင့်ပြုချင်တယ်၊ တခြားဟာ မထည့်စေချင်ဘူး စသဖြင့် ကန့်သတ်ချက် (Specific Restrictions) လုပ်ရတာ လက်ဝင်တတ်ပါတယ်။ Type Checking တွေကို Run-time ကျမှ လိုက်စစ်ရတတ်ပါတယ်။

- Complexity: Class တွေ၊ Interface တွေ အများကြီး ခွဲထုတ်ရတဲ့အတွက် ဒေတာဖွဲ့စည်းပုံ မရှုပ်ထွေးတဲ့ ရိုးရိုးစနစ်မျိုးမှာ သွားသုံးရင် ကုဒ်တွေ မလိုအပ်ဘဲ ပိုရှည်ပြီး ရှုပ်သွားနိုင်ပါတယ်။
