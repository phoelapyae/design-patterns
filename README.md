Strategy Design Pattern ဆိုတာ Gang of Four (GoF) ရဲ့ Behavioral Design Pattern တစ်ခု ဖြစ်ပါတယ်။

သူ့ရဲ့ အဓိက ရည်ရွယ်ချက်ကတော့ အလုပ်တစ်ခုကို လုပ်ဆောင်မယ့် Algorithm (နည်းလမ်း) တွေကို သီးသန့် Class တစ်ခုစီအဖြစ် ခွဲထုတ်လိုက်ပြီး၊ အခြေအနေပေါ် မူတည်ပြီး အဲဒီနည်းလမ်းတွေကို စိတ်ကြိုက် လဲလှယ်သုံးစွဲနိုင်အောင် (Interchangeable) လုပ်ပေးတာ ဖြစ်ပါတယ်။

ရိုးရိုးရှင်းရှင်း ဥပမာပေးရရင် - သင် ခရီးတစ်ခု သွားမယ်ဆိုပါစို့။ သွားနိုင်မယ့် နည်းလမ်း (Strategies) တွေက အများကြီးပါ။

1. ဘတ်စ်ကားနဲ့ သွားမယ် (BusStrategy)

2. ရထားနဲ့ သွားမယ် (TrainStrategy)

3. လေယာဉ်ပျံနဲ့ သွားမယ် (AirplaneStrategy)

သင် (Client) က ပိုက်ဆံချွေတာချင်ရင် ဘတ်စ်ကားနည်းလမ်းကို ရွေးမယ်၊ အချိန်အမြန်လိုရင် လေယာဉ်ပျံနည်းလမ်းကို ရွေးမယ်။ သွားမယ့် ခရီးစဉ် (Context) က အတူတူပဲဖြစ်ပြီး အခြေအနေပေါ် မူတည်ပြီး သွားမယ့် နည်းလမ်း (Strategy) ကိုပဲ လဲလှယ်သွားတာ ဖြစ်ပါတယ်။

## PHP နဲ့ ရိုးရှင်းတဲ့ ဥပမာတစ်ခု ကြည့်ရအောင်

E-commerce Website တစ်ခုမှာ ပစ္စည်းဖိုး ငွေပေးချေတဲ့စနစ် (Payment) ကို ရေးကြည့်ပါမယ်။ ဝယ်သူက PayPal နဲ့ ဖြစ်ဖြစ်၊ Credit Card နဲ့ဖြစ်ဖြစ် ပေးချေနိုင်ရပါမယ်။

## ၁။ Strategy Interface ဆောက်ခြင်း

နည်းလမ်းအားလုံးမှာ တူညီမယ့် Method ကို သတ်မှတ်ပေးရပါမယ်။

```
interface PaymentStrategy {
    public function pay($amount);
}
```

## ၂။ Concrete Strategies (နည်းလမ်းတစ်ခုချင်းစီအတွက် Class ခွဲထုတ်ခြင်း)

```
// နည်းလမ်း ၁ - PayPal ဖြင့် ပေးချေခြင်း
class PayPalPayment implements PaymentStrategy {
    private $email;

    public function __construct($email) {
        $this->email = $email;
    }

    public function pay($amount) {
        echo "Paid $amount using PayPal account: {$this->email}\n";
    }
}

// နည်းလမ်း ၂ - Credit Card ဖြင့် ပေးချေခြင်း
class CreditCardPayment implements PaymentStrategy {
    private $cardNumber;

    public function __construct($cardNumber) {
        $this->cardNumber = $cardNumber;
    }

    public function pay($amount) {
        echo "Paid $amount using Credit Card: {$this->cardNumber}\n";
    }
}
```

## ၃။ Context (Strategy ကို လက်ခံပြီး အသုံးပြုမည့်နေရာ)

```
class ShoppingCart {
    private $amount = 0;
    private $paymentMethod;

    public function __construct($amount) {
        $this->amount = $amount;
    }

    // ဝယ်သူရွေးချယ်လိုက်တဲ့ နည်းလမ်းကို ဒီကနေ သိမ်းထားမယ်
    public function setPaymentMethod(PaymentStrategy $method) {
        $this->paymentMethod = $method;
    }

    // ငွေချေတဲ့အလုပ်ကို လုပ်မယ်
    public function checkout() {
        $this->paymentMethod->pay($this->amount);
    }
}
```

လက်တွေ့ အသုံးပြုပုံ (Client Code)

```
$cart = new ShoppingCart(250); // ဝယ်ထားတာ ၂၅၀ ဖိုးရှိတယ်

// ဝယ်သူက PayPal ကို ရွေးချယ်လိုက်တဲ့အခါ
$cart->setPaymentMethod(new PayPalPayment("user@example.com"));
$cart->checkout(); // Output: Paid 250 using PayPal account: user@example.com

// ဝယ်သူက Credit Card ပြောင်းရွေးလိုက်တဲ့အခါ
$cart->setPaymentMethod(new CreditCardPayment("1234-5678-9012"));
$cart->checkout(); // Output: Paid 250 using Credit Card: 1234-5678-9012
```

## Laravel Framework မှာ Strategy Pattern ကို ဘယ်လိုသုံးလဲ?

Laravel ဟာ သူ့ရဲ့ Driver-based Components (ဥပမာ - Mail, Cache, Session, Storage) တွေမှာ Strategy Pattern ကို အလွန်ကျယ်ပြန့်စွာ သုံးထားပါတယ်။

## ဥပမာ - Storage File Uploads (Flysystem)

Laravel ရဲ့ Storage Facade ကို ကြည့်ပါ။ ကျွန်တော်တို့က ဖိုင်တစ်ခုကို Local Storage (ကိုယ့်စက်ထဲ) မှာ သိမ်းချင်တာ ဖြစ်နိုင်သလို၊ AWS S3 Cloud ပေါ်မှာလည်း သိမ်းချင်တာ ဖြစ်နိုင်ပါတယ်။

Laravel က ဒီနည်းလမ်း (Strategies) တွေကို နောက်ကွယ်မှာ Drivers တွေအနေနဲ့ ခွဲထုတ်ပေးထားပါတယ်။

```
use Illuminate\Support\Facades\Storage;

// 1. Local Driver (Strategy) ကို သုံးပြီး သိမ်းမယ်
Storage::disk('local')->put('file.txt', 'Contents');

// 2. AWS S3 Driver (Strategy) ကို ပြောင်းပြီး သိမ်းမယ်
Storage::disk('s3')->put('file.txt', 'Contents');
```

ကုဒ်ထဲမှာ put() ဆိုတဲ့ Method ကိုပဲ ခေါ်နေတာခြင်း တူတူပါပဲ။ ဒါပေမဲ့ disk() ထဲမှာ ဘယ် Driver ရွေးလဲပေါ် မူတည်ပြီး နောက်ကွယ်က လုပ်ဆောင်မယ့် အလုပ် (Strategy) က ပြောင်းလဲသွားတာ ဖြစ်ပါတယ်။

ကိုယ်တိုင် Laravel မှာ အသုံးချချင်ရင် (Custom Strategy with Service Container)
Laravel ရဲ့ Service Container ကို သုံးပြီး Controller ထဲမှာ အခြေအနေပေါ် မူတည်ပြီး Strategy ကို Dynamic အနေနဲ့ Bind လုပ်ပြီး သုံးနိုင်ပါတယ်။

```
// Controller ထဲမှာ သုံးပုံဥပမာ
public function processPayment(Request $request) 
{
    // Request ကလာတဲ့ ပုံစံပေါ် မူတည်ပြီး class ကို dynamic ဆောက်မယ်
    $strategy = $request->type === 'paypal' 
        ? new PayPalPayment($request->email) 
        : new CreditCardPayment($request->card);

    // Laravel Container ကနေ ဆွဲထုတ်ပြီး သုံးစွဲခြင်း
    app()->instance(PaymentStrategy::class, $strategy);
    
    // ကျန်တဲ့ Business Logic ကို ဆက်လုပ်...
}
```

## ဘာကြောင့် သုံးသင့်လဲ? (အကျိုးကျေးဇူးများ)

- Open/Closed Principle: အနာဂတ်မှာ နည်းလမ်းအသစ် (ဥပမာ - WaveMoney, KPay) ထပ်တိုးချင်ရင် ရှိပြီးသား ကုဒ်တွေကို လိုက်ပြင်စရာမလိုဘဲ Class အသစ်တစ်ခု ထပ်ဆောက်လိုက်ရုံပါပဲ။

- Avoid if-else blocks: ကုဒ်တွေထဲမှာ if ($type == 'paypal') { ... } else if ($type == 'card') { ... } ဆိုပြီး အရှည်ကြီး ရေးရမယ့် အရှုပ်အထွေးတွေကို ဖယ်ရှားပေးနိုင်ပါတယ်။

- Tighter Testing: နည်းလမ်းတစ်ခုချင်းစီကို သီးသန့် Class ခွဲထုတ်ထားလို့ Unit Test ရေးရတာ ပိုမိုလွယ်ကူသွားစေပါတယ်။

***Command Pattern*** နဲ့ ***Strategy Pattern*** ဟာ နှစ်ခုစလုံး Behavioral Design Pattern တွေ ဖြစ်ကြပြီး Class တွေထဲက logic တွေကို အပြင်ထုတ်ပြီး Object အဖြစ် ပြောင်းလဲပစ်တာခြင်း တူတာကြောင့် ရုတ်တရက်ဆို လွဲမှားတတ်ကြပါတယ်။

ဒါပေမဲ့ သူတို့နှစ်ခုရဲ့ ရည်ရွယ်ချက် (Intent) က လုံးဝ ကွဲပြားပါတယ်။

## အဓိက ကွဲပြားချက် (The Core Difference)

- Command Pattern သည် "ဘာလုပ်မလဲ" (What to do) ကို အဓိကထားသည်။ လုပ်ဆောင်ချက်တစ်ခု (Request) ကို သီးသန့်စာအိတ် (Object) တစ်ခုထဲ ထည့်ပိတ်လိုက်တာပါ။ အဲဒီစာအိတ်ကို ဘယ်အချိန်မှာ ဖွင့်ဖတ်မလဲ (ဥပမာ - ချက်ချင်းလုပ်မလား၊ Queue ထဲထည့်ပြီး နောက်မှလုပ်မလား၊ Undo ပြန်လုပ်မလား) ဆိုတာကို စိတ်ကြိုက် စီမံဖို့ သုံးပါတယ်။

- Strategy Pattern သည် "ဘယ်လိုလုပ်မလဲ" (How to do) ကို အဓိကထားသည်။ အလုပ်တစ်ခုကို လုပ်ဖို့ နည်းလမ်းပေါင်းစုံ ရှိနေတဲ့အခါ အခြေအနေပေါ် မူတည်ပြီး နည်းလမ်း (Algorithm) ကို အလွယ်တကူ လဲလှယ် (Swap) သုံးစွဲနိုင်အောင် သုံးပါတယ်။

## နှိုင်းယှဉ်ချက် ဇယား (Comparison Table)

| အချာအလက် | Command Pattern | Strategy Pattern |
|---|---|---|
| အဓိက ရည်ရွယ်ချက် | အလုပ်တစ်ခု (Request) ကို Object အဖြစ် ပြောင်းလဲခြင်း။ | အလုပ်ဆောင်သည့် လုပ်ပုံကို ပြောင်းလဲနိုင်တဲ့ နည်းလမ်းများ (Algorithms) တွေကို ပြောင်းလဲသုံးနိုင်ခြင်း။ |
| ဥပမာ | "ဒီ အလုပ်ကို သိမ်းထားပြီး နောက်မှ လုပ်ချင်တယ်/ဖျက်ချင်တယ်" | "ဒီ အလုပ်ကို လုပ်မယ့် ဟန်တယ်၊ ချေမယ့် နည်းလမ်း၊ ဖိုင်တင်မယ့် နည်းလမ်း" |
| ပါဝင်သည့် အစိတ်အပိုင်းများ | Invoker, Receiver, Command ပါဝင်ပြီး လုပ်ဆောင်သည်။ | Context နှင့် Strategy ပိုင်း ပါဝင်ပြီး ရွေးချယ်သုံးသည်။ |
| အသုံးအများဆုံး နေရာ | Task Queue, Undo/Redo စနစ်များ။ | Payment Gateways, File Upload Systems မျိုး။ |

# PHP ဥပမာဖြင့် နှိုင်းယှဉ်ချက်

သင်က E-commerce Website တစ်ခု ရေးနေတယ်ဆိုပါစို့။

## ၁။ Strategy ဥပမာ (ဘယ်လို ငွေချေမလဲ?)

ဝယ်သူက Check out နှိပ်လိုက်ပြီ။ အလုပ်က "ငွေဖြတ်ဖို့" ပဲ။ ဒါပေမဲ့ နည်းလမ်းက ကွဲပြားနိုင်တယ်။ (Kpay နဲ့ ဖြတ်မလား၊ Wave နဲ့ ဖြတ်မလား)

```
interface PaymentStrategy { public function pay($amount); }

class KpayPayment implements PaymentStrategy { ... }
class WavePayment implements PaymentStrategy { ... }

// ဝယ်သူရွေးတဲ့ "နည်းလမ်း" (Strategy) ကို ထည့်ပေးပြီး ချက်ချင်း ငွေဖြတ်ခိုင်းလိုက်တယ်
$cart->setPaymentMethod(new KpayPayment());
$cart->checkout();
```

## ၂။ Command ဥပမာ (ဘယ်အလုပ်ကို သိမ်းဆည်းပြီး မောင်းနှင်မလဲ?)

ဝယ်သူက အော်ဒါတင်လိုက်လို့ နောက်ကွယ်မှာ အလုပ်တွေ အများကြီး လုပ်ရမယ်။ အဲဒီလုပ်စရာရှိတဲ့ "အလုပ် (Action)" ကြီးတစ်ခုလုံးကို Object အဖြစ် ထုပ်ပိုးလိုက်တာပါ။

```
interface Command { public function execute(); }

class ProcessOrderCommand implements Command {
    public function execute() {
        // ပစ္စည်းစစ်မယ် -> ငွေဖြတ်မယ် -> မေးလ်ပို့မယ် (အလုပ်တွေ စုလုပ်တာ)
    }
}

// အလုပ်ကို Object အဖြစ် သိမ်းဆည်းပြီး Queue (Invoker) ထဲ ပစ်ထည့်လိုက်တယ်
$queueManager->add(new ProcessOrderCommand());
```

## Laravel Framework ထဲက ဥပမာများဖြင့် နှိုင်းယှဉ်ချက်

Laravel ကို ကြည့်ရင်လည်း ဒီကွဲပြားချက်ကို အထင်အရှား မြင်နိုင်ပါတယ်။

***Laravel ၏ Strategy Pattern ပြယုဂ်: Storage***

ဖိုင်တစ်ခုကို သိမ်းချင်တာခြင်း (What to do) အတူတူပဲ။ ဒါပေမဲ့ ကိုယ့်စက်ထဲ သိမ်းမှာလား (Local Driver)၊ Amazon ပေါ် သိမ်းမှာလား (S3 Driver) ဆိုတဲ့ နည်းလမ်း (How to do) ကိုပဲ ရွေးချယ်ခိုင်းတာ ဖြစ်ပါတယ်။

// Strategy တစ်ခုချင်းစီကို driver အနေနဲ့ လဲသုံးသွားတာ

```
Storage::disk('local')->put('photo.jpg', $contents);
Storage::disk('s3')->put('photo.jpg', $contents);
```

## Laravel ၏ Command Pattern ပြယုဂ်: Jobs & Queues

အီးမေးလ် ပို့ရမယ့်အလုပ် (Job) ကို ချက်ချင်းမလုပ်သေးဘဲ ညသန်းခေါင်မှ လုပ်ချင်တယ်၊ ဒါမှမဟုတ် နောက်ကွယ်မှာ Worker တွေနဲ့ အလှည့်ကျ လုပ်ချင်တယ် (When to do)။ ဒါကြောင့် အလုပ်တစ်ခုလုံးကို Job ဆိုတဲ့ Command Object အဖြစ် ပြောင်းလဲလိုက်တာ ဖြစ်ပါတယ်။

// အလုပ်ကို Object အဖြစ် ပြောင်းပြီး Queue ထဲ သိမ်းခိုင်းလိုက်တာ (နောက်မှ execute လုပ်မယ်)

```
SendMarketingEmailJob::dispatch($user);
```

## အနှစ်ချုပ် လမ်းညွှန်

***သင့်မှာ အလုပ်တစ်ခုတည်းကို လုပ်ဖို့ နည်းလမ်းတွေ အများကြီး ရှိနေပြီး စိတ်ကြိုက် ရွေးခိုင်းချင်ရင် ➡️ Strategy Pattern ကို သုံးပါ။***

***သင့်မှာ လုပ်စရာ အလုပ်တွေ ရှိပြီး အဲဒီအလုပ်တွေကို Queue ထဲထည့်ချင်ရင်၊ အချိန်ဆိုင်းပြီးမှ လုပ်ချင်ရင်၊ ဒါမှမဟုတ် Undo/Redo လုပ်ချင်ရင် ➡️ Command Pattern ကို သုံးပါ။***
