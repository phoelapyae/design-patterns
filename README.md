Decorator Design Pattern ဆိုတာ Gang of Four (GoF) ရဲ့ Structural Design Pattern တစ်ခု ဖြစ်ပါတယ်။

***သူ့ရဲ့ အဓိက ရည်ရွယ်ချက်ကတော့ ရှိပြီးသား Object တစ်ခုကို မူလ Class ကုဒ်တွေ လိုက်မပြင်ဘဲ (သို့မဟုတ်) Subclass အသစ်တွေ ထပ်မဆောက်ဘဲ၊ Runtime (အလုပ်လုပ်နေချိန်) မှာ လုပ်ဆောင်ချက် (Behaviors) အသစ်တွေကို အပြင်ကနေ အထပ်ထပ် ထုပ်ပိုး (Wrap) ပြီး ပေါင်းထည့်ပေးဖို့ ဖြစ်ပါတယ်။***

ရိုးရိုးရှင်းရှင်း ဥပမာပေးရရင် - ကော်ဖီဆိုင် (Coffee Shop) ကို မြင်ကြည့်ပါ။

သင်က ရိုးရိုးကော်ဖီ (Basic Coffee) တစ်ခွက် မှာတယ်။

အဲဒီအပေါ်မှာ နွားနို့ (Milk) ထပ်ထည့်ချင်တယ်။ (ဒါဆို ရိုးရိုးကော်ဖီကို နွားနို့နဲ့ Wrap လုပ်လိုက်ပါတယ်)

သကြား (Sugar) ထပ်ထည့်ချင်တယ်။ (နွားနို့ကော်ဖီကို သကြားနဲ့ ထပ်ပြီး Wrap လုပ်လိုက်ပါတယ်)

ကော်ဖီကတော့ ကော်ဖီပါပဲ၊ ဒါပေမဲ့ အပြင်ကနေ ပါဝင်ပစ္စည်း (Decorator) တွေ တစ်ခုပြီးတစ်ခု ထပ်ပေါင်းထည့်လိုက်တဲ့အတွက် ကော်ဖီရဲ့ အရသာရော၊ ဈေးနှုန်းပါ အလိုအလျောက် ပြောင်းလဲသွားတာ ဖြစ်ပါတယ်။ ဒီလိုလုပ်ဖို့အတွက် MilkSugarCoffee, MilkCoffee, SugarCoffee ဆိုပြီး Class တွေ အများကြီး လိုက်ခွဲဆောက်နေစရာ မလိုတော့ပါဘူး။

# PHP နဲ့ ရိုးရှင်းတဲ့ ကော်ဖီဆိုင် ဥပမာတစ်ခု ကြည့်ရအောင်

## ၁။ Component Interface (အခြေခံ ပုံစံခွက်)

ကော်ဖီအစစ်ရော၊ ပါဝင်ပစ္စည်း (Decorator) တွေရော အားလုံးက ဒီ Interface ကို သုံးရပါမယ်။

```
interface Coffee {
    public function getCost();
    public function getDescription();
}
```

## ၂။ Concrete Component (အခြေခံ Object အစစ်)

```
class BasicCoffee implements Coffee {
    public function getCost() {
        return 1000; // ရိုးရိုးကော်ဖီ ဈေးနှုန်း ၁၀၀၀ ကျပ်
    }
    public function getDescription() {
        return "Basic Coffee";
    }
}
```

## ၃။ Base Decorator (အလှဆင်မည့် ကြားခံ Class)

ဒီ Class က Object အစစ်ကို အထဲမှာ သိမ်းထား (Wrap လုပ်) ပေးမယ့် ကောင်ဖြစ်ပါတယ်။

```
abstract class CoffeeDecorator implements Coffee {
    protected $coffee; // အထဲမှာ ထုပ်ပိုးထားမည့် ကော်ဖီ Object

    public function __construct(Coffee $coffee) {
        $this->coffee = $coffee;
    }

    public function getCost() {
        return $this->coffee->getCost();
    }

    public function getDescription() {
        return $this->coffee->getDescription();
    }
}
```

## ၄။ Concrete Decorators (ထပ်ပေါင်းထည့်မည့် ပါဝင်ပစ္စည်းများ)

```
// နွားနို့ ထပ်ထည့်ခြင်း
class MilkDecorator extends CoffeeDecorator {
    public function getCost() {
        return $this->coffee->getCost() + 300; // နွားနို့ဖိုး ၃၀၀ တိုးမည်
    }
    public function getDescription() {
        return $this->coffee->getDescription() . ", Milk";
    }
}

// သကြား ထပ်ထည့်ခြင်း
class SugarDecorator extends CoffeeDecorator {
    public function getCost() {
        return $this->coffee->getCost() + 100; // သကြားဖိုး ၁၀၀ တိုးမည်
    }
    public function getDescription() {
        return $this->coffee->getDescription() . ", Sugar";
    }
}
```

လက်တွေ့ အသုံးပြုပုံ (Client Code)

```
// ၁။ ရိုးရိုးကော်ဖီ စဖျော်မယ်
$myCoffee = new BasicCoffee();
echo $myCoffee->getDescription() . " : " . $myCoffee->getCost() . " KS\n"; 
// Output: Basic Coffee : 1000 KS

// ၂။ နွားနို့ ထည့်မယ် (Basic Coffee ကို Milk နဲ့ Wrap လိုက်ပြီ)
$myCoffee = new MilkDecorator($myCoffee);
echo $myCoffee->getDescription() . " : " . $myCoffee->getCost() . " KS\n"; 
// Output: Basic Coffee, Milk : 1300 KS

// ၃။ သကြား ထပ်ထည့်မယ် (Milk Coffee ကို Sugar နဲ့ ထပ် Wrap လိုက်ပြီ)
$myCoffee = new SugarDecorator($myCoffee);
echo $myCoffee->getDescription() . " : " . $myCoffee->getCost() . " KS\n"; 
// Output: Basic Coffee, Milk, Sugar : 1400 KS
```

# Laravel Framework မှာ Decorator Pattern ကို ဘယ်လိုသုံးလဲ?

Laravel ရဲ့ Service Container (IoC Container) မှာ Decorator Pattern ကို အလွယ်တကူ အကောင်အထည်ဖော်ဖို့ extend() ဆိုတဲ့ method တစ်ခု အသင့်ပါဝင်ပါတယ်။

လက်တွေ့လုပ်ငန်းခွင်မှာ ရှိပြီးသား Service Class တစ်ခုကို လုံးဝ သွားမပြင်ဘဲ Logging (မှတ်တမ်းတင်ခြင်း) သို့မဟုတ် Caching အင်္ဂါရပ်တွေ အပြင်ကနေ ပေါင်းထည့်ချင်တဲ့အခါ အသုံးများပါတယ်။

ဥပမာ - Order Processing စနစ်ကို Logging ထပ်ပေါင်းထည့်ခြင်း
## ၁။ ရှိပြီးသား မူလ Service (Real Object)

```
interface OrderServiceInterface {
    public function process(array $orderData);
}

class BaseOrderService implements OrderServiceInterface {
    public function process(array $orderData) {
        // Database ထဲသိမ်းတာတို့၊ ငွေဖြတ်တာတို့ တကယ်လုပ်မည့် နေရာ
        echo "Processing order...\n";
    }
}
```

## ၂။ Logging ထပ်ထည့်မည့် Decorator Class

```
class LoggableOrderService implements OrderServiceInterface {
    protected $innerService;

    public function __construct(OrderServiceInterface $innerService) {
        $this->innerService = $innerService;
    }

    public function process(array $orderData) {
        // အလုပ်မလုပ်ခင် မှတ်တမ်းတင်မယ် (Adding Behavior)
        \Log::info('Order processing started.', $orderData);

        // မူလ Service ဆီ အလုပ်လွှဲပေးမယ်
        $result = $this->innerService->process($orderData);

        // အလုပ်လုပ်ပြီးကြောင်း မှတ်တမ်းထပ်တင်မယ်
        \Log::info('Order processing finished.');

        return $result;
    }
}
```

## ၃။ Laravel တွင် ချိတ်ဆက်ခြင်း (AppServiceProvider.php)

```
public function register()
{
    // ပုံမှန် Base Service ကို အရင် Bind လုပ်တယ်
    $this->app->bind(OrderServiceInterface::class, BaseOrderService::class);

    // ပြီးရင် extend() ကို သုံးပြီး အပြင်ကနေ LoggableOrderService နဲ့ Wrap (ထုပ်ပိုး) လိုက်တယ်
    $this->app->extend(OrderServiceInterface::class, function ($service, $app) {
        return new LoggableOrderService($service);
    });
}
```

ဒီလိုရေးလိုက်ခြင်းအားဖြင့် Controller ထဲမှာ $orderService->process() လို့ ခေါ်လိုက်တာနဲ့ Order အစစ်လည်း အလုပ်လုပ်သွားသလို၊ နောက်ကွယ်မှာ Log တွေလည်း အလိုအလျောက် ဝင်သွားမှာ ဖြစ်ပါတယ်။ မူလ BaseOrderService ကုဒ်ကို တစ်လုံးမှ လိုက်ပြင်စရာ မလိုတော့ပါဘူး။

# အားသာချက်များနှင့် အားနည်းချက်များ (Pros & Cons)

### ကောင်းကွက်များ (Pros)

- Subclassing ကို ရှောင်ရှားနိုင်ခြင်း: MilkCoffee, SugarCoffee, MilkSugarCoffee စသဖြင့် Subclass ပေါင်းများစွာ (Class Explosion) ထပ်ပွားနေရမယ့် ပြဿနာကို အပြတ်အသတ် ရှင်းလင်းပေးပါတယ်။

- Single Responsibility Principle: "ကော်ဖီဖျော်တဲ့ တာဝန်" ကို ကော်ဖီ Class မှာထားပြီး၊ "နွားနို့ထည့်တဲ့ တာဝန်" ကို နွားနို့ Class မှာ သီးသန့်ခွဲထားနိုင်ပါတယ်။

- Open/Closed Principle: ရှိပြီးသား ကုဒ်ကို လိုက်ပြင်စရာမလိုဘဲ Class အသစ်တစ်ခု ဆောက်ပြီး အင်္ဂါရပ်အသစ် (New Behaviors) တွေကို အကန့်အသတ်မရှိ ထပ်ပေါင်းထည့်နိုင်ပါတယ်။

- Runtime Dynamic: ကုဒ်ရေးနေချိန်မှာ မဟုတ်ဘဲ အစီအစဉ်လည်ပတ်နေချိန် (Runtime) မှာမှ လိုအပ်သလို အထပ်ထပ် ဖြုတ်/တပ် လုပ်နိုင်ပါတယ်။

### ဆိုးကွက်များ (Cons)

- ကုဒ် ဖတ်ရခက်ခဲခြင်း: Object တွေက တစ်ခုကို တစ်ခု အထပ်ထပ် Wrap လုပ်ထားတဲ့အတွက် Bug (အမှား) တစ်ခုခု တက်လာရင် ဘယ်အလွှာ (Layer) က Class မှာ မှားနေတာလဲဆိုတာကို Debug လိုက်ဖမ်းရတာ အရမ်း ခေါင်းစားတတ်ပါတယ်။

- အစီအစဉ် (Order) ပေါ် မူတည်နေတတ်ခြင်း: Decorator တွေကို ထုပ်ပိုးတဲ့ အစီအစဉ် မှားသွားရင် (ဥပမာ - Discount အရင်မချဘဲ Tax အရင်ပေါင်းမိရင်) Business Logic တွေ မှားယွင်းသွားတတ်ပါတယ်။

- Class အသေးစားလေးများ များပြားလာခြင်း: ပါဝင်ပစ္စည်း (Behavior) အသစ်တစ်ခု တိုးတိုင်း Class သစ်တစ်ခု ထပ်ဆောက်ရတဲ့အတွက် Project ထဲမှာ Class အရေအတွက် အလွန်များလာတတ်ပါတယ်။
