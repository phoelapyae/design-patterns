Chain of Responsibility Design Pattern ဆိုတာ Gang of Four (GoF) ရဲ့ Behavioral Design Pattern တစ်ခု ဖြစ်ပါတယ်။

***သူ့ရဲ့ အဓိက ရည်ရွယ်ချက်ကတော့ Client ဆီကလာတဲ့ Request တစ်ခုကို အလုပ်လုပ်မယ့် Handler Classes တွေကို Chain တစ်ခုလို တစ်ခုနဲ့တစ်ခု ဆက်တိုက်ချိတ်ဆက်ထားပြီး၊ အဲဒီ Request ကို ၎င်း Chain အတိုင်း အဆင့်ဆင့် ဖြတ်သန်း မောင်းနှင်စေတာ ဖြစ်ပါတယ်။***

Chain ထဲမှာရှိတဲ့ Handler တစ်ခုချင်းစီက -

1. ဒီ Request ကို သူကိုယ်တိုင်ပဲ ကိုင်တွယ်ဖြေရှင်းမလား။

2. ဒါမှမဟုတ် သူ့အဆင့်ပြီးရင် နောက်ထပ် Handler တစ်ခုဆီကိုပဲ ဆက်လက် လွှဲပြောင်း (Pass) ပေးလိုက်မလား။
ဆိုတာကို ကိုယ်တိုင် ဆုံးဖြတ်သွားကြတာ ဖြစ်ပါတယ်။

ရိုးရိုးရှင်းရှင်း ဥပမာပေးရရင် - သင်က ကုမ္ပဏီတစ်ခုရဲ့ Customer Support (ဖုန်းဝန်ဆောင်မှု) ဆီကို ဖုန်းဆက်တယ်ဆိုပါစို့။

- စက်ကနေ အလိုအလျောက် ပထမဆုံးအဆင့် ကိုင်တွယ်ပါတယ် (Level 1 Handler)။ သင့်ပြဿနာက ရိုးရှင်းရင် သူကပဲ ဖြေရှင်းပေးပြီး ဖုန်းချသွားပါလိမ့်မယ်။

- အကယ်၍ စက်နဲ့ ဖြေရှင်းလို့မရတဲ့ နည်းပညာပိုင်းဆိုင်ရာ ပြဿနာဆိုရင် စက်ကနေ နည်းပညာဝန်ထမ်း (Level 2 Handler) ဆီ ဖုန်းလွှဲပေးပါလိမ့်မယ်။

- သူနဲ့မှ မရရင် မန်နေဂျာ (Level 3 Handler) ဆီ ဖုန်းထပ်လွှဲပါလိမ့်မယ်။

ဒီနေရာမှာ သင့်ရဲ့ ဖုန်းခေါ်ဆိုမှု (Request) ဟာ ဝန်ထမ်းအဆင့်ဆင့် (Chain of Handlers) ဆီကို တစ်ယောက်ပြီးတစ်ယောက် ရောက်ရှိသွားတာ ဖြစ်ပါတယ်။

# PHP နဲ့ ရိုးရှင်းတဲ့ ဥပမာတစ်ခု ကြည့်ရအောင်

Website တစ်ခုထဲကို User တစ်ယောက် Login ဝင်ဖို့ ကြိုးစားတဲ့အခါ (၁) User ဟုတ်/မဟုတ် စစ်မယ် (AuthHandler)၊ (၂) သူက Admin ဟုတ်/မဟုတ် စစ်မယ် (RoleHandler)၊ (၃) ခဏခဏ လာနှိပ်နေတာလား (RateLimitHandler) စတဲ့ အဆင့်ဆင့် စစ်ဆေးမှုကို ရေးကြည့်ပါမယ်။

## ၁။ Base Handler (Interface သို့မဟုတ် Abstract Class)

နောက်က အဆင့်ကို ဘယ်လို ချိတ်ဆက်မလဲဆိုတာကို သတ်မှတ်ပေးရပါမယ်။

```
abstract class HttpHandler {
    private $nextHandler;

    // နောက်ထပ် ဘယ် Handler လာမလဲဆိုတာ ချိတ်ဆက်ပေးမည့် Method
    public function setNext(HttpHandler $handler): HttpHandler {
        $this->nextHandler = $handler;
        return $handler; // Method Chaining လုပ်လို့ရအောင် ပြန်ပေးခြင်း
    }

    // Request ကို နောက်ကောင်ဆီ လွှဲပေးမည့် Method
    protected function passToNext($request) {
        if ($this->nextHandler) {
            return $this->nextHandler->handle($request);
        }
        return true; // အားလုံး အောင်မြင်စွာ ဖြတ်သန်းသွားနိုင်လျှင် True ပြန်မည်
    }

    abstract public function handle($request);
}
```

## ၂။ Concrete Handlers (သီးသန့် စစ်ဆေးမည့် အဆင့်တစ်ခုချင်းစီ)

```
// အဆင့် ၁ - စက်ထဲ သတ်မှတ်ထားသည့် အကြိမ်ရေထက် ပိုနှိပ်/မနှိပ် စစ်ခြင်း
class RateLimitHandler extends HttpHandler {
    public function handle($request) {
        if ($request['clicks_per_minute'] > 60) {
            echo "Error 429: Too many requests!\n";
            return false; // ဒီအဆင့်မှာတင် ကုဒ်ကို ရပ်ပစ်လိုက်ခြင်း (Breaking the chain)
        }
        return $this->passToNext($request); // အဆင်ပြေရင် နောက်တစ်ဆင့်ကို လွှဲမယ်
    }
}

// အဆင့် ၂ - အကောင့် ဝင်ထား/မထား စစ်ခြင်း
class AuthHandler extends HttpHandler {
    public function handle($request) {
        if (!$request['is_logged_in']) {
            echo "Error 401: Unauthorized! Please login.\n";
            return false;
        }
        return $this->passToNext($request);
    }
}
```

## လက်တွေ့ အသုံးပြုပုံ (Client Code)

```
$authHandler = new AuthHandler();
$rateLimitHandler = new RateLimitHandler();
$dataHandler = new DataHandler();

// Handlers တွေကို ချိတ်ဆက်ခြင်း
$authHandler->setNext($rateLimitHandler)->setNext($dataHandler);

// Request တစ်ခုကို စမ်းသပ်ခြင်း
$request = [
    'is_logged_in' => true,
    'clicks_per_minute' => 30
];

$authHandler->handle($request);
```

# Laravel Framework မှာ Chain of Responsibility Pattern ကို ဘယ်လိုသုံးလဲ?

Laravel Developer တိုင်း နေ့တိုင်း သုံးနေတဲ့ Laravel Middleware စနစ်ကြီးတစ်ခုလုံးဟာ ဒီ GoF Chain of Responsibility Pattern ကို အခြေခံပြီး ၁၀၀ ရာခိုင်နှုန်း တည်ဆောက်ထားတာ ဖြစ်ပါတယ်။

ဥပမာ - Laravel HTTP Middleware
Laravel မှာ Request တစ်ခု ဝင်လာရင် Route/Controller ထံ မရောက်ခင် ကြားထဲကနေ Auth, TrimStrings, VerifyCsrfToken စတဲ့ မစ်ဒယ်ဝဲတွေ အဆင့်ဆင့် ဖြတ်သန်းသွားရပါတယ်။

Laravel ရဲ့ ပုံမှန် Middleware ကုဒ်တစ်ခုကို ကြည့်ပါ -

```
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Authenticate
{
    // $next ဆိုတာ GoF Pattern ထဲက Next Handler ကို ပြောတာ ဖြစ်ပါတယ်
    public function handle(Request $request, Closure $next)
    {
        if (! $request->user()) {
            return redirect('login'); // စစ်ဆေးချက် မအောင်မြင်ရင် ဒီမှာတင် ရပ်ပြီး Redirect လုပ်တယ်
        }

        // စစ်ဆေးချက် အောင်မြင်ရင် နောက်ကွင်းဆက် (Next Middleware/Controller) ဆီ လွှဲပေးလိုက်တယ်
        return $next($request); 
    }
}
```

နောက်ကွယ်မှာ Laravel က Kernel.php ထဲမှာ သတ်မှတ်ထားတဲ့ မစ်ဒယ်ဝဲတွေကို Array လိုက် ယူပြီး တစ်ခုပြီးတစ်ခု Pipeline သဘောတရားအတိုင်း Chain ချိတ်ပြီး မောင်းနှင်ပေးသွားတာ ဖြစ်ပါတယ်။

## အားသာချက်များနှင့် အားနည်းချက်များ (Pros & Cons)

### ကောင်းကွက်များ (Pros)

- Loose Coupling (ချိတ်ဆက်မှု လျော့ရဲခြင်း): Client ကနေ ဘယ်သူက အလုပ်လုပ်သွားလဲဆိုတာ အတိအကျ သိစရာမလိုပါဘူး။ Request ကို ကွင်းဆက်ရဲ့ ထိပ်ဝထဲ ပစ်ထည့်လိုက်ရုံပါပဲ။

- Single Responsibility Principle: စစ်ဆေးတဲ့ Logic တစ်ခုချင်းစီကို Class တစ်ခုစီအဖြစ် သန့်သန့်ရှင်းရှင်း ခွဲထုတ်ထားနိုင်ပါတယ်။ (ဥပမာ - Auth logic ပြင်ချင်ရင် AuthHandler ထဲပဲ သွားပြင်ရုံပါပဲ)။

- Open/Closed Principle: ရှိပြီးသားကုဒ်တွေကို လိုက်မဖျက်ဘဲ ကွင်းဆက်ထဲကို စစ်ဆေးမယ့် အဆင့်အသစ်တွေ (ဥပမာ - LogRequest သို့မဟုတ် Localization) ကို အလွယ်တကူ ကြားညှပ် တိုးချဲ့နိုင်ပါတယ်။

### ဆိုးကွက်များ (Cons)

- No Guarantee of Handling: အကယ်၍ ကွင်းဆက်ကို သေချာ မချိတ်ဆက်ထားမိရင် သို့မဟုတ် နောက်ဆုံးအဆင့်အထိ ဘယ် Handler ကမှ တာဝန်ယူ မဖြေရှင်းသွားရင် Request ဟာ ဘာမှမဖြစ်ဘဲ လေထဲမှာ ပျောက်ဆုံးသွားတတ်ပါတယ်။

- Hard to Debug: Request တစ်ခုက Handler တွေအများကြီးကို အဆင့်ဆင့် ဖြတ်သန်းသွားရတဲ့အတွက် ကုဒ်မှာ ပြဿနာ (Bug) တစ်ခုခုတက်လာရင် ဘယ်အဆင့်မှာ ပျက်သွားလဲဆိုတာ လိုက်ရှာရတာ လက်ဝင်တတ်ပါတယ်။
