Adapter Design Pattern ဆိုတာ Gang of Four (GoF) ရဲ့ Structural Design Pattern တစ်ခု ဖြစ်ပါတယ်။

***သူ့ရဲ့ အဓိက ရည်ရွယ်ချက်ကတော့ အချင်းချင်း ချိတ်ဆက်လို့မရတဲ့ Interface နှစ်ခု (Incompatible Interfaces) ကို ကြားထဲကနေ ဒေါက်တာ (Adapter) တစ်ခုအနေနဲ့ ကြားခံပေါင်းကူးပေးပြီး အတူတူ အလုပ်လုပ်လို့ရအောင် ပြောင်းလဲပေးတာ ဖြစ်ပါတယ်။***

ရိုးရိုးရှင်းရှင်း ဥပမာပေးရရင် - သင် နိုင်ငံရပ်ခြား (ဥပမာ - စင်ကာပူ သို့မဟုတ် ထိုင်း) ကို ခရီးသွားတဲ့အခါ သင့်ဖုန်းအားသွင်းကြိုး ခေါင်းအဝိုင်း (Round Pin) က ဟိုတယ်က နံရံပလပ်ပေါက် အပြား (Flat Pin) နဲ့ စိုက်လို့မရပါဘူး။

အဲဒီအခါ သင်ဘာလုပ်လဲ? ကြားထဲကနေ Universal Adapter (ခေါင်းပြောင်း) တစ်ခု ခံပြီး စိုက်ရပါတယ်။ အဲဒီ Universal Adapter က သင့်ဖုန်းကြိုး (Client) ရော ဟိုတယ်ပလပ်ပေါက် (Service) ရောကို ဘာမှလိုက်ပြင်စရာမလိုဘဲ အဆင်ပြေပြေ ချိတ်ဆက်ပေးသွားတာ ဖြစ်ပါတယ်။

# PHP နဲ့ ရိုးရှင်းတဲ့ ဥပမာတစ်ခု ကြည့်ရအောင်

ကျွန်တော်တို့ Website မှာ SMS ပို့တဲ့စနစ် (SmsNotifier) တစ်ခု ရှိပါတယ်။ အစတုန်းက MtechSMS ဆိုတဲ့ Service ကို သုံးနေရာကနေ နောက်ပိုင်းမှာ TwilioSMS ဆိုတဲ့ နာမည်ကြီး Service တစ်ခုကို ပြောင်းသုံးချင်လာပါတယ်။ ဒါပေမဲ့ ပြဿနာက သူတို့နှစ်ခုရဲ့ Method နာမည်တွေက မတူကြပါဘူး။

## ၁။ တစ်ပြေးညီ အလုပ်လုပ်မည့် Interface များ ဆောက်ခြင်း

```
// third party service အားလုံးကို ပုံစံတစ်မျိုးတည်း ဖြစ်အောင် အရင်ညှိမည့် Interface
interface ThirdPartySmsWrapper {
    public function send($to, $text);
}

// Client (ကျွန်တော်တို့ App) ဘက်က လှမ်းခေါ်မည့် ပင်မ Adapter Interface
interface SmsAdapterInterface {
    public function sendSms($provider, $to, $message);
}
```

## ၂။ ဝန်ဆောင်မှုတစ်ခုချင်းစီအတွက် Wrapper Classes များ ထုပ်ပိုးခြင်း

ဒီ Class တွေက third party services မတူညီတဲ့ Method နာမည်တွေကို ကြားကခံပြီး send() ဆိုတဲ့ နာမည်တစ်ခုတည်း ဖြစ်သွားအောင် သိမ်းပေးမယ့် ကောင်တွေ ဖြစ်ပါတယ်။

```
// ၁။ Twilio အတွက် Wrapper
class TwilioWrapper implements ThirdPartySmsWrapper {
    public function send($to, $text) {
        // နောက်ကွယ်က Twilio ရဲ့ သီးသန့် Method ကို လှမ်းခေါ်ခြင်း
        echo "Sending via Twilio to $to: '$text'\n";
    }
}

// ၂။ Nexmo အတွက် Wrapper
class NexmoWrapper implements ThirdPartySmsWrapper {
    public function send($to, $text) {
        // နောက်ကွယ်က Nexmo ရဲ့ သီးသန့် Method ကို လှမ်းခေါ်ခြင်း
        echo "Sending via Nexmo to $to: '$text'\n";
    }
}

// ၃။ Firebase အတွက် Wrapper
class FirebaseWrapper implements ThirdPartySmsWrapper {
    public function send($to, $text) {
        // နောက်ကွယ်က Firebase ရဲ့ သီးသန့် Method ကို လှမ်းခေါ်ခြင်း
        echo "Sending via Firebase Notification to $to: '$text'\n";
    }
}
```

## ၃။ ပင်မ Adapter Class တည်ဆောက်ခြင်း (if-else လုံးဝမပါဝင်ပါ)

ဒီနေရာမှာ ကျွန်တော်တို့ဟာ if ($provider == 'twilio') လို့ ရေးမယ့်အစား Array Map (Key-Value Registry) ကို သုံးပြီး ဝန်ဆောင်မှုတွေကို လှမ်းခေါ်မှာ ဖြစ်ပါတယ်။

```
class UniversalSmsAdapter implements SmsAdapterInterface {
    // ဝန်ဆောင်မှုစာရင်းကို Array ဖြင့် သိမ်းဆည်းထားမည်
    private array $providers = [];

    public function __construct() {
        // ဝန်ဆောင်မှု နာမည် (Key) နှင့် သက်ဆိုင်ရာ Class (Value) ကို စက်ထဲ ကြိုတင်မှတ်ပုံတင်ခြင်း
        $this->providers = [
            'twilio'   => new TwilioWrapper(),
            'nexmo'    => new NexmoWrapper(),
            'firebase' => new FirebaseWrapper(),
        ];
    }

    public function sendSms($providerName, $to, $message) {
        // if-else သုံးမည့်အစား Array Key ပေါ်မူတည်ပြီး သက်ဆိုင်ရာ Wrapper Class ကို Dynamic ဆွဲထုတ်သည်
        // အကယ်၍ ရှာမတွေ့ပါက Null Coalescing Object သို့မဟုတ် Exception ထုတ်ပေးနိုင်သည်
        $provider = $this->providers[$providerName] ?? null;

        if (!$provider) {
            throw new Exception("Provider '$providerName' not supported.");
        }

        // ဘာ Provider ပဲဖြစ်ဖြစ် Interface တူသွားပြီမို့ send() ကို တန်းခေါ်ရုံပါပဲ (Polymorphism)
        $provider->send($to, $message);
    }
}
```

# 🎯 လက်တွေ့ အသုံးပြုပုံ (Client Code)

Client က ကုဒ်ထဲမှာ ဘာ if-else မှ လိုက်စစ်စရာမလိုဘဲ စာသား (String) ပေးလိုက်ရုံနဲ့ နောက်ကွယ်က သက်ဆိုင်ရာ စနစ်တွေဆီ အလိုအလျောက် ရောက်သွားမှာ ဖြစ်ပါတယ်။

```
$adapter = new UniversalSmsAdapter();

// ၁။ Twilio ဖြင့် ပို့ခြင်း
$adapter->sendSms('twilio', '+959111111', "Hello Twilio"); 
// Output: Sending via Twilio to +959111111: 'Hello Twilio'

// ၂။ Firebase ဖြင့် ပို့ခြင်း
$adapter->sendSms('firebase', '+959222222', "Hello Firebase");
// Output: Sending via Firebase Notification to +959222222: 'Hello Firebase'
```

# Laravel Framework မှာ Adapter Pattern ကို ဘယ်လိုသုံးလဲ?

Laravel ဟာ သူ့ရဲ့ Backend စနစ်တွေ ဖြစ်တဲ့ Cache drivers, Session drivers နဲ့ Filesystem (Storage) တွေမှာ Adapter Pattern ကို အကြီးအကျယ် သုံးထားပါတယ်။

### ဥပမာ - Laravel Cache Drivers (Repository & Store)

Laravel မှာ ကျွန်တော်တို့က Cache::get('key') ဆိုပြီး ဒေတာတွေကို လှမ်းယူလေ့ရှိပါတယ်။

- နောက်ကွယ်မှာ ဒေတာတွေကို သိမ်းတဲ့နေရာက Redis ဖြစ်နိုင်သလို၊ Memcached သို့မဟုတ် သာမန် Database/File လည်း ဖြစ်နိုင်ပါတယ်။

- Redis ရဲ့ သီးသန့် PHP library ခေါ်ပုံတွေနဲ့ Memcached ရဲ့ ခေါ်ပုံတွေက လုံးဝ မတူကြပါဘူး။

ဒါပေမဲ့ Laravel က ကြားထဲကနေ RedisStore Adapter Class နဲ့ MemcachedStore Adapter Class တွေကို ခံပေးထားပါတယ်။

```
// Laravel Core ရဲ့ အလုပ်လုပ်ပုံ အကျဉ်း
namespace Illuminate\Cache;

class RedisStore implements Store {
    protected $redis;

    // Laravel က သတ်မှတ်ထားတဲ့ တစ်ပြေးညီ get method 
    public function get($key) {
        // အထဲမှာတော့ Redis ရဲ့ သီးသန့် command ဖြစ်တဲ့ connection()->get() ကို ပြောင်းခေါ်ပေးထားပါတယ်
        return $this->redis->connection()->get($key);
    }
}
```

ဒီအတွက်ကြောင့် Developer က နောက်ကွယ်မှာ ဘယ် Cache စနစ်ပဲ သုံးသုံး၊ ကုဒ်ထဲမှာ Cache::get() ဆိုပြီး တစ်သမတ်တည်း သန့်သန့်ရှင်းရှင်း ရေးနိုင်တာ ဖြစ်ပါတယ်။

# အားသာချက်များနှင့် အားနည်းချက်များ (Pros & Cons)

### ကောင်းကွက်များ (Pros)

- Single Responsibility Principle: ဒေတာ ပုံစံပြောင်းလဲခြင်း (Data Conversion) Logic တွေကို ပင်မ Business Logic ကုဒ်တွေထဲမှာ ရှုပ်ပွမနေစေဘဲ Adapter Class သီးသန့်ထဲမှာပဲ စုစည်းထားနိုင်ပါတယ်။

- Open/Closed Principle: အနာဂတ်မှာ တခြား SMS Gateway အသစ်တစ်ခု (ဥပမာ - Firebase SMS) ထပ်ပြောင်းချင်ရင်လည်း ရှိပြီးသား ကုဒ်တွေကို လိုက်မဖျက်ဘဲ Adapter အသစ်တစ်ခု ထပ်ဆောက်လိုက်ရုံပါပဲ။

- Reusability: Third-party ဆီကလာတဲ့ ပြင်လို့မရတဲ့ Library တွေ၊ Legacy Code (ကုဒ်အဟောင်းကြီးတွေ) ကို ကိုယ့်စနစ်နဲ့ ကိုက်ညီအောင် အလွယ်တကူ ပေါင်းစပ် အသုံးပြုနိုင်စေပါတယ်။

### ဆိုးကွက်များ (Cons)

- Code Complexity: Interface အသစ်တွေ၊ Adapter Class အသစ်တွေ ခွဲထုတ်ရတဲ့အတွက် ကုဒ်တစ်ခုလုံးရဲ့ ဖွဲ့စည်းပုံဟာ မလိုအပ်ဘဲ ပိုမို ရှုပ်ထွေးသွားနိုင်ပါတယ်။ တစ်ခါတရံမှာ Adaptee Class ကို တိုက်ရိုက် လိုက်ပြင်လိုက်တာက ပိုပြီး မြန်ဆန်ရိုးရှင်းနေတတ်ပါတယ်။
