Singleton Design Pattern ဆိုတာ Gang of Four (GoF) ရဲ့ Creational Design Pattern (တည်ဆောက်ခြင်းဆိုင်ရာ ပုံစံခွက်) တစ်ခု ဖြစ်ပါတယ်။

***သူ့ရဲ့ အဓိက ရည်ရွယ်ချက်ကတော့ Class တစ်ခုအတွက် Object (Instance) ကို တစ်ခုတည်းသာ တည်ဆောက်ခွင့်ပြုပြီး၊ စနစ်တစ်ခုလုံး (တစ်ပရောဂျက်လုံး) ကနေ အဲဒီ Object တစ်ခုတည်းကိုပဲ နေရာတကာကနေ လှမ်းယူသုံးစွဲနိုင်မယ့် Global Access Point (အများသုံး ဝင်ပေါက်) တစ်ခု ဖန်တီးပေးဖို့ ဖြစ်ပါတယ်။***

ရိုးရိုးရှင်းရှင်း ဥပမာပေးရရင် - နိုင်ငံတစ်နိုင်ငံမှာ အစိုးရ (Government) ဆိုတာ တစ်ခုတည်းပဲ ရှိပါတယ်။ မန္တလေးကနေပဲ ဆက်သွယ်ဆက်သွယ်၊ ရန်ကုန်ကနေပဲ ဆက်သွယ်ဆက်သွယ် အစိုးရအသစ် ထပ်ဖွဲ့လို့ မရပါဘူး။ ရှိပြီးသား အစိုးရတစ်ခုတည်းကိုပဲ လှမ်းပြီး ချိတ်ဆက်ရပါတယ်။ ဒါဟာ Singleton ရဲ့ သဘောတရားပါပဲ။

Real-world App တွေမှာ အများဆုံး သုံးလေ့ရှိတာကတော့ Database Connection တွေ၊ Configuration Settings တွေနဲ့ Logging စနစ်တွေမှာ ဖြစ်ပါတယ်။ Database ကို နေရာတကာကနေ new Database() ဆိုပြီး အကြိမ်ကြိမ် ခေါ်နေရင် Memory တွေပြည့်ပြီး စနစ်ကြီး နှေးကျသွားပါလိမ့်မယ်။ ဒါကြောင့် တစ်ခါဆောက်ပြီးရင် အဲဒီတစ်ခုကိုပဲ လှည့်ပတ်သုံးဖို့ Singleton ကို သုံးကြပါတယ်။

# PHP ဖြင့် ရိုးရှင်းသော ဥပမာ

***PHP မှာ Singleton တစ်ခုတည်ဆောက်ဖို့ အောက်ပါ အချက် (၃) ချက်ကို မဖြစ်မနေ လုပ်ရပါတယ်။***

1. အပြင်ကနေ new သုံးပြီး Object အသစ်ဆောက်လို့မရအောင် __construct() ကို private ပိတ်ရပါမယ်။

2. Object ကို ထပ်ပွားလို့မရအောင် __clone() နဲ့ __wakeup() ကိုပါ private ပိတ်ရပါမယ်။

3. Object ကို ဆွဲယူသုံးဖို့အတွက် public static Method တစ်ခု (များသောအားဖြင့် getInstance() လို့ပေးလေ့ရှိသည်) ကို တည်ဆောက်ရပါမယ်။

```
class DatabaseConnection {
    // Instance ကို သိမ်းထားမည့် Private Static Variable
    private static $instance = null;
    
    // Database connection string ကို မှတ်ထားရန် ဥပမာ
    private $connectionString;

    // ၁။ အပြင်ကနေ new DatabaseConnection() ခေါ်လို့မရအောင် ပိတ်ထားခြင်း
    private function __construct() {
        $this->connectionString = "Connected to MySQL at " . date('Y-m-d H:i:s');
        echo "Database Object Created!\n";
    }

    // ၂။ Clone (ပွားခြင်း) ကို ပိတ်ထားခြင်း
    private function __clone() {}

    // ၃။ Unserialize လုပ်ခြင်းကို ပိတ်ထားခြင်း
    public function __wakeup() {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    // ၄။ Object ကို လှမ်းယူမည့် Global Access Point
    public static function getInstance() {
        // အကယ်၍ ဆောက်ပြီးသား မရှိသေးရင် အသစ်ဆောက်မယ်
        if (self::$instance === null) {
            self::$instance = new DatabaseConnection();
        }
        // ဆောက်ပြီးသားရှိရင် ရှိပြီးသားကိုပဲ ပြန်ပေးမယ်
        return self::$instance;
    }

    public function getQuery() {
        return "Executing query via: " . $this->connectionString . "\n";
    }
}
```

လက်တွေ့ အသုံးပြုပုံ (Client Code)

```
// $db1 = new DatabaseConnection(); // Error တက်ပါမည်။ private ဖြစ်နေ၍ပါ။

// ပထမတစ်ကြိမ် ခေါ်ခြင်း (Object အသစ် စတင်တည်ဆောက်သည်)
$db1 = DatabaseConnection::getInstance();
echo $db1->getQuery(); 
// Output: Database Object Created! 
// Output: Executing query via: Connected to MySQL...

// ဒုတိယတစ်ကြိမ် ထပ်ခေါ်ခြင်း (အသစ်မဆောက်တော့ဘဲ $db1 ကိုပဲ ပြန်ပေးလိုက်သည်)
$db2 = DatabaseConnection::getInstance();
echo $db2->getQuery();
// Output: Executing query via: Connected to MySQL... (Created ဆိုသောစာ ထပ်မပေါ်တော့ပါ)

// နှစ်ခုတူညီကြောင်း စစ်ဆေးကြည့်ခြင်း
var_dump($db1 === $db2); // Output: bool(true)
```

# Laravel Framework မှာ Singleton Pattern ကို ဘယ်လိုသုံးလဲ?

Laravel ဟာ သူ့ရဲ့ အောက်ခြေမှာ (Service Container ထဲမှာ) Singleton Pattern ကို အပြည့်အဝ အသုံးပြုထားပါတယ်။ ကျွန်တော်တို့ PHP မှာ ကိုယ်တိုင်ရေးခဲ့ရသလို private __construct() တွေ လိုက်ရေးစရာမလိုဘဲ၊ Laravel ရဲ့ app()->singleton() ဆိုတဲ့ Method လေး သုံးလိုက်ရုံနဲ့ အလွယ်တကူ Singleton ဖြစ်သွားပါတယ်။

# Laravel ဥပမာ - Service Provider တွင် Singleton သတ်မှတ်ခြင်း

သင့်ဆီမှာ Third-party API တစ်ခုခုကို လှမ်းခေါ်တဲ့ PaymentGateway Class တစ်ခု ရှိတယ်ဆိုပါစို့။ အဲဒီ Class ကို Request တစ်ခုဝင်လာတိုင်း တစ်ခါပဲ ဆောက်စေချင်တယ်ဆိုရင် AppServiceProvider ထဲမှာ အခုလို သွားရေးရပါတယ်။

```
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\PaymentGateway;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        // ဤနေရာတွင် bind() အစား singleton() ကို သုံးလိုက်ခြင်းဖြင့် Singleton ဖြစ်သွားသည်
        $this->app->singleton(PaymentGateway::class, function ($app) {
            return new PaymentGateway(config('services.payment.secret'));
        });
    }
}
```

ဒီလိုရေးလိုက်ခြင်းအားဖြင့် သင့်ရဲ့ Controller တွေထဲမှာ PaymentGateway ကို ဘယ်နှစ်ခါပဲ Dependency Injection (DI) နဲ့ ခေါ်ခေါ်၊ သို့မဟုတ် app(PaymentGateway::class) နဲ့ပဲ ခေါ်ခေါ်၊ Laravel က Memory ထဲမှာ အသင့်ရှိနေတဲ့ Object တစ်ခုတည်းကိုသာ အမြဲတမ်း ပြန်လည် ထုတ်ပေးသွားမှာ ဖြစ်ပါတယ်။ Laravel ရဲ့ DB, Cache, Log, Session Facade တွေ အားလုံးဟာလည်း နောက်ကွယ်မှာ ဒီ Singleton သဘောတရားအတိုင်း အလုပ်လုပ်နေကြတာ ဖြစ်ပါတယ်။

## အားသာချက်များနှင့် အားနည်းချက်များ (Pros & Cons)

### ကောင်းကွက်များ (Pros)

- Instance တစ်ခုတည်းသာ ရှိကြောင်း သေချာစေခြင်း (Strict Control): Object အသစ်တွေ အများကြီး မပွားလာနိုင်တဲ့အတွက် Database connection limit ကျော်သွားတာမျိုးတွေကို တားဆီးနိုင်ပါတယ်။

- Memory သက်သာခြင်း: Object တစ်ခုတည်းကိုသာ မျှဝေသုံးစွဲတဲ့အတွက် RAM (Memory) အသုံးပြုမှုကို သိသိသာသာ လျော့ကျစေပါတယ်။

- Lazy Initialization: getInstance() ကို စတင်မခေါ်မချင်း Object ကို ကြိုတင် တည်ဆောက်မထားတဲ့အတွက် Application တက်တဲ့အချိန် (Boot time) ကို မနှေးစေပါဘူး။

- Global Access: ပရောဂျက်ရဲ့ ဘယ်နေရာ၊ ဘယ် Class ထဲကနေမဆို လွယ်လွယ်ကူကူ လှမ်းခေါ်သုံးလို့ ရပါတယ်။

### ဆိုးကွက်များ (Cons)

- Single Responsibility Principle ကို ဖောက်ဖျက်ခြင်း: Class တစ်ခုတည်းကနေ "သူ့ရဲ့ ပင်မအလုပ် (ဥပမာ- Database Query လုပ်ခြင်း)" ကိုရော "Object တစ်ခုတည်း ထွက်ဖို့ ထိန်းချုပ်တဲ့အလုပ်" ကိုပါ နှစ်ခုပေါင်း လုပ်နေတဲ့အတွက် SOLID principle နဲ့ မကိုက်ညီပါဘူး။

- Unit Testing လုပ်ရန် အလွန်ခက်ခဲခြင်း: Singleton တွေဟာ Global Variable တွေနဲ့ သဘောတရား တူသွားပါတယ်။ Test ရေးတဲ့အခါ Object တွေကို Mock (အတု) လုပ်ဖို့ အရမ်းခက်ခဲသွားစေပါတယ်။

- Hidden Dependencies (မှီခိုမှုများကို ဖုံးကွယ်ထားခြင်း): Class တစ်ခုက Singleton တစ်ခုကို အတွင်းထဲမှာ တိုက်ရိုက် ခေါ်သုံးလိုက်တဲ့အခါ၊ အပြင်ကနေကြည့်ရင် ဒီ Class က ဘာတွေကို မှီခိုနေလဲ (Dependency) ဆိုတာ မသိသာတော့ဘဲ ကုဒ်ဖတ်ရ၊ ပြင်ရ ခက်ခဲသွားစေပါတယ်။ ဒါကြောင့် ခေတ်သစ် Programming မှာ Singleton ကို တိုက်ရိုက်ရေးမယ့်အစား Laravel လိုမျိုး Dependency Injection Container (IoC) ကနေတစ်ဆင့် ထိန်းချုပ်ပြီး သုံးလာကြတာ ဖြစ်ပါတယ်။
