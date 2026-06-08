Factory Design Pattern ဆိုတာ Gang of Four (GoF) ရဲ့ Creational Design Pattern (တည်ဆောက်ခြင်းဆိုင်ရာ ပုံစံခွက်) တစ်ခု ဖြစ်ပါတယ်။

***သူ့ရဲ့ အဓိက ရည်ရွယ်ချက်ကတော့ Object တွေကို တည်ဆောက်တဲ့အခါ new keyword ကိုသုံးပြီး Client (အသုံးပြုသူ) ဘက်ကနေ တိုက်ရိုက် မဆောက်ဘဲ၊ Object တွေထုတ်ပေးမယ့် စက်ရုံ (Factory Class) တစ်ခုကနေ တစ်ဆင့် ကြားခံပြီး ဖန်တီးတည်ဆောက်ပေးဖို့ ဖြစ်ပါတယ်။***

ရိုးရိုးရှင်းရှင်း ဥပမာပေးရရင် - သင်က ကားဝယ်ချင်တဲ့သူ (Client) တစ်ယောက်ဆိုပါစို့။

- သင့်အနေနဲ့ ကားတစ်စီးဖြစ်လာဖို့ ဘီးဘယ်လိုတပ်ရတယ်၊ အင်ဂျင်ဘယ်လိုဆင်ရတယ် ဆိုတဲ့ အသေးစိတ် တည်ဆောက်ပုံ (Instantiation Logic) တွေကို သိစရာ မလိုပါဘူး။

- သင်လုပ်ရမှာက ကားစက်ရုံ (Factory) ဆီကိုသွားပြီး "ကျွန်တော့်ကို Sport Car တစ်စီး ပေးပါ" ဒါမှမဟုတ် "Family Car တစ်စီး ပေးပါ" လို့ လှမ်းမှာလိုက်ရုံပါပဲ။

- စက်ရုံကနေ သင့်အတွက် အသင့်သုံးလို့ရတဲ့ ကား Object ကို ဖန်တီးပြီး ပြန်ပေးပါလိမ့်မယ်။

PHP နဲ့ ရိုးရှင်းတဲ့ ငွေချေစနစ် ဥပမာတစ်ခု ကြည့်ရအောင်
မြန်မာနိုင်ငံမှာ အသုံးများတဲ့ KPay, WaveMoney စတဲ့ ငွေချေစနစ်တွေကို Factory Pattern သုံးပြီး ရေးကြည့်ပါမယ်။

## ၁။ Interface (ပုံစံတူ သတ်မှတ်ချက်)
ငွေချေစနစ် အားလုံးက ဒီ Interface ကို မဖြစ်မနေ သုံးရပါမယ်။

```
interface PaymentMethod {
    public function pay($amount);
}
```

## ၂။ Concrete Classes (ငွေချေစနစ် အစစ်များ)

```
class KPay implements PaymentMethod {
    public function pay($amount) {
        echo "Paid $amount MMK using KBZ Pay.\n";
    }
}

class WaveMoney implements PaymentMethod {
    public function pay($amount) {
        echo "Paid $amount MMK using Wave Money.\n";
    }
}
```

## ၃။ Factory Class (စက်ရုံ)
ဒီ Class ရဲ့ တစ်ခုတည်းသော တာဝန်က လိုချင်တဲ့ Object ကို တည်ဆောက်ပေးဖို့ ဖြစ်ပါတယ်။

```
class PaymentFactory {
    // လိုချင်တဲ့ အမျိုးအစားကို ပြောလိုက်ရုံနဲ့ သက်ဆိုင်ရာ Object ကို ပြန်ပေးမည့် Method
    public static function createPayment($type): PaymentMethod {
        switch (strtolower($type)) {
            case 'kpay':
                return new KPay();
            case 'wave':
                return new WaveMoney();
            default:
                throw new Exception("Payment method '$type' is not supported.");
        }
    }
}
```

လက်တွေ့ အသုံးပြုပုံ (Client Code)

```
// Client က KPay Class ကိုဖြစ်စေ၊ Wave Class ကိုဖြစ်စေ new သုံးပြီး တိုက်ရိုက် မခေါ်တော့ပါ
// Factory ကိုပဲ လှမ်းမှာလိုက်ပါတယ်

$payment1 = PaymentFactory::createPayment('kpay');
$payment1->pay(50000); // Output: Paid 50000 MMK using KBZ Pay.

$payment2 = PaymentFactory::createPayment('wave');
$payment2->pay(15000); // Output: Paid 15000 MMK using Wave Money.
```

ကျွန်တော် အပေါ်မှာ ရှင်းပြခဲ့တဲ့ switch-case နဲ့ ရေးတဲ့ Factory ပုံစံကို Programming လောကမှာ Simple Factory (သို့မဟုတ် Parameterized Factory) လို့ ခေါ်ပါတယ်။ တကယ်တော့ အဲဒီ Simple Factory လေးဟာ စစ်မှန်တဲ့ Open/Closed Principle (OCP) ကို အပြည့်အဝ မလိုက်နာနိုင်ပါဘူး။

## ၁။ Client Code မှာ သွားပြင်ရတဲ့ ကိစ္စ
လက်တွေ့ Web Application တွေမှာ Client Code (ဥပမာ - Controller) ထဲမှာ 'kpay' တို့၊ 'aya' တို့ကို createPayment('aya') ဆိုပြီး Hardcode သွားရေးလေ့ မရှိပါဘူး။ အသုံးပြုသူ (User) ရွေးချယ်လိုက်တဲ့ Input ကနေ Dynamic လှမ်းယူတာ ဖြစ်ပါတယ်။

```
// Client Code (Controller ထဲမှာ)
$userSelectedMethod = $request->input('payment_type'); // ဥပမာ - 'aya' ဝင်လာမည်

// Client Code မှာ if-else တွေ case တွေ ထပ်စစ်စရာမလိုတော့ဘဲ Variable အနေနဲ့ပဲ တန်းထည့်လိုက်တာပါ
$payment = PaymentFactory::createPayment($userSelectedMethod); 
$payment->pay(15000);
```

ဒီလိုရေးတဲ့အတွက် အသစ်တစ်ခု (ဥပမာ aya) ထပ်တိုးလာလည်း Controller (Client Code) ဘက်မှာ တစ်လုံးမှ သွားပြင်ရေးစရာ မလိုတော့တဲ့အတွက် Client Code ဘက်က ကြည့်ရင်တော့ တကယ် Closed (ပြင်စရာမလိုအောင် ပိတ်ထားသည်) ဖြစ်သွားပါတယ်။

## ၂။ PaymentFactory ထဲမှာ case 'aya': သွားတိုးရတဲ့ ကိစ္စ (The Real OCP Violation)

OCP ရဲ့ သဘောတရားက "အသစ်တိုးချင်ရင် ရှိပြီးသား Class ကို သွားမပြင်ဘဲ အပြင်ကနေ လှမ်းချိတ်ရမယ် (Open for extension, Closed for modification)" ဆိုတာပါ။

အခုက AYAPay အသစ်တိုးတိုင်း PaymentFactory ရဲ့ ကုဒ်ဖိုင်ကို ဖွင့်ပြီး switch ထဲမှာ case တွေ သွားသွား တိုးရေးနေရတာဟာ OCP ကို ပြောင်ပြောင်တင်းတင်း ချိုးဖောက်နေတာ ဖြစ်ပါတယ်။

💡 စစ်မှန်တဲ့ OCP ဖြစ်အောင် ဘယ်လို ပြင်ရေးမလဲ? (The True OCP Factory)
switch-case သို့မဟုတ် if-else တွေကို လုံးဝ ဖျောက်ပစ်ပြီး Registry Pattern သို့မဟုတ် Reflection ကို သုံးမှသာ စစ်မှန်တဲ့ OCP ကို ရမှာဖြစ်ပါတယ်။ စောစောက Adapter Pattern မှာ ရှင်းပြခဲ့သလို Mapping (Array) ပုံစံ ပြောင်းရေးရပါမယ်။

```
class TruePaymentFactory {
    // Factory ထဲမှာ ဘာ Payment တွေ ရလဲဆိုတာကို Array နဲ့ မှတ်ထားပါမည်
    private static array $registeredMethods = [];

    // ၁။ အသစ်ပေါ်လာတဲ့ Payment တွေကို Factory ထဲ လှမ်းထည့်ရန် (Extension အတွက် ဖွင့်ထားခြင်း - Open)
    public static function registerMethod(string $type, string $className) {
        self::$registeredMethods[$type] = $className;
    }

    // ၂။ Object ဖန်တီးပေးမည့် Method (Modification အတွက် ပိတ်ထားခြင်း - Closed)
    public static function createPayment(string $type): PaymentMethod {
        if (!array_key_exists($type, self::$registeredMethods)) {
            throw new \Exception("Payment method '$type' is not supported.");
        }

        // Array ထဲကနေ သက်ဆိုင်ရာ Class နာမည်ကို ယူပြီး Object တည်ဆောက်ပေးလိုက်ခြင်းပါ
        $className = self::$registeredMethods[$type];
        return new $className();
    }
}
```

# လက်တွေ့ အလုပ်လုပ်ပုံ (ဘယ်လို OCP ဖြစ်သွားလဲ?)

အခုဆိုရင် TruePaymentFactory ဆိုတဲ့ စက်ရုံကြီးရဲ့ ကုဒ်ကို လုံးဝ (လုံးဝ) ထပ်ပြင်စရာ မလိုတော့ပါဘူး။ စက်ရုံကို ပိတ်ချလိုက်လို့ ရပါပြီ (Closed for modification)။

အကယ်၍ AYAPay အသစ် တိုးလာပြီဆိုပါစို့။ AppServiceProvider လို နေရာမျိုး (Configurate လုပ်တဲ့နေရာ) ကနေ Factory ဆီကို အပြင်ကနေပဲ လှမ်းပြီး Register လုပ် (Extension လုပ်) ပေးလိုက်ရုံပါပဲ။

```
// Application စတက်တဲ့အချိန် (AppServiceProvider ထဲမှာ) ကြိုပြီး Register လုပ်ထားမည်
TruePaymentFactory::registerMethod('kpay', KPay::class);
TruePaymentFactory::registerMethod('wave', WaveMoney::class);

// 💥 AYAPay အသစ်တိုးလာလျှင် Factory ထဲသွားပြင်စရာမလိုဘဲ အပြင်ကနေပဲ ဒီလို လှမ်းပေါင်းထည့်လိုက်ရုံပါပဲ
TruePaymentFactory::registerMethod('aya', AYAPay::class);
```

***ရိုးရှင်းတဲ့ ဥပမာပြချင်လို့ သုံးလေ့ရှိတဲ့ switch-case Factory တွေဟာ OCP ကို ချိုးဖောက်ပါတယ်။ စစ်မှန်တဲ့ OCP ဖြစ်ဖို့ဆိုရင် Class တွေကို Dynamic Register လုပ်လို့ရတဲ့ စနစ် (Array Mapping / Service Container) ပြောင်းသုံးမှသာ အပြည့်အဝ မှန်ကန်မှာ ဖြစ်ပါတယ်။***

# Laravel Framework မှာ Factory Pattern ကို ဘယ်လိုသုံးလဲ?

Laravel ဟာ Developer တွေ အလုပ်လုပ်ရတာ လွယ်ကူချောမွေ့အောင် Factory Pattern ကို နေရာများစွာမှာ အသုံးပြုထားပါတယ်။ အထင်ရှားဆုံး ဥပမာ (၂) ခုကို ပြပါမယ်။

## ၁။ Database Model Factories (Testing & Seeding အတွက်)
Laravel သုံးဖူးသူတိုင်း Database ထဲကို Data အတု (Mock Data) တွေ ထည့်ဖို့ Factory ကို သုံးဖူးကြမှာပါ။

```
// User Object အသစ် ၁၀ ခုကို Factory ကနေတစ်ဆင့် လှမ်းဆောက်ခိုင်းလိုက်ခြင်းပါ
$users = User::factory()->count(10)->create();
```

နောက်ကွယ်မှာ UserFactory Class က User တစ်ယောက်ဖြစ်လာဖို့ လိုအပ်တဲ့ Name, Email, Password စတဲ့ အချက်အလက်တွေကို စနစ်တကျ တည်ဆောက်ပြီး Object အနေနဲ့ ပြန်ပေးလိုက်တာ ဖြစ်ပါတယ်။ Developer က new User() ဆိုပြီး Property တွေ တစ်ခုချင်းစီ လိုက်ထည့်နေစရာ မလိုတော့ပါဘူး။

## ၂။ Manager Classes (Driver များကို ရွေးချယ်ခြင်း)
Laravel ရဲ့ Log, Cache, Storage စနစ်တွေဟာ Factory Pattern ကို အခြေခံထားတာ ဖြစ်ပါတယ်။ ဥပမာ -

```
// Log ကို Slack ထဲ ပို့ချင်ရင် 
Log::channel('slack')->info('Hello Slack!');

// Log ကို file ထဲပဲ ရေးချင်ရင်
Log::channel('single')->info('Hello Local File!');
```

ဒီနေရာမှာ LogManager ဟာ Factory ကြီး တစ်ခုပါ။ သင့်အနေနဲ့ Slack Log ဘယ်လိုဆောက်ရလဲ သိစရာမလိုဘဲ channel('slack') လို့ လှမ်းတောင်းလိုက်တာနဲ့ လိုအပ်တဲ့ Object ကို Laravel က အလိုအလျောက် ဖန်တီးပေးသွားတာ ဖြစ်ပါတယ်။

# အားသာချက်များနှင့် အားနည်းချက်များ (Pros & Cons)

### ကောင်းကွက်များ (Pros)

- Loose Coupling (ချိတ်ဆက်မှု လျော့ရဲခြင်း): Client ကုဒ်ထဲမှာ new KPay(), new WaveMoney() ဆိုပြီး နေရာတကာ လိုက်ရေးထားစရာ မလိုတဲ့အတွက် ကုဒ်တစ်ခုနဲ့တစ်ခု တင်းကျပ်စွာ ချိတ်ဆက်နေတာမျိုးကို လျှော့ချနိုင်ပါတယ်။

- Single Responsibility Principle: Object တွေကို တည်ဆောက်တဲ့ တာဝန် (Creation Logic) ကို Factory Class ထဲမှာပဲ သီးသန့် စုစည်းထားနိုင်တဲ့အတွက် ကုဒ်တွေ ပိုမို သန့်ရှင်းသွားပါတယ်။

- Open/Closed Principle: အနာဂတ်မှာ AYAPay ဆိုတဲ့ စနစ်အသစ် ထပ်တိုးလာခဲ့ရင်၊ Client ကုဒ်တွေကို လိုက်ပြင်စရာမလိုဘဲ PaymentFactory ထဲမှာပဲ case 'aya': ဆိုပြီး သွားတိုးလိုက်ရုံနဲ့ အလွယ်တကူ တိုးချဲ့နိုင်ပါတယ်။

### ဆိုးကွက်များ (Cons)

- Code Complexity (ကုဒ် ပိုမို ရှုပ်ထွေးလာခြင်း): ရိုးရှင်းတဲ့ Object တစ်ခုလေး ဆောက်ဖို့အတွက်တောင် Interface တွေ၊ Factory Class တွေ အသစ်ထပ်ဆောက်နေရတဲ့အတွက်၊ သေးငယ်တဲ့ Project တွေမှာဆိုရင် မလိုအပ်ဘဲ ဖိုင်တွေများလာပြီး (Over-engineering) ပိုရှုပ်သွားစေနိုင်ပါတယ်။

