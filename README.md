Observer Design Pattern ဆိုတာ Gang of Four (GoF) ရဲ့ Behavioral Design Pattern တစ်ခု ဖြစ်ပါတယ်။

သူ့ရဲ့ အဓိက ရည်ရွယ်ချက်ကတော့ Object တစ်ခုခုရဲ့ အခြေအနေ ပြောင်းလဲသွားတဲ့အခါ (State Change)၊ သူနဲ့ ဆက်စပ်နေတဲ့ တခြား Object အားလုံးဆီကို အလိုအလျောက် သတင်းလှမ်းပို့ပြီး Update လုပ်ပေးမယ့် (One-to-Many dependency) စနစ်တစ်ခု ဖန်တီးဖို့ ဖြစ်ပါတယ်။

ရိုးရိုးရှင်းရှင်း ဥပမာပေးရရင် - သင်က YouTube Channel တစ်ခုကို Subscribe လုပ်ထားတယ်ဆိုပါစို့။

- အဲဒီ Channel က ဗီဒီယိုအသစ် တင်လိုက်တိုင်း (State Change ဖြစ်သွားတိုင်း)၊ Subscribe လုပ်ထားတဲ့ လူတွေအကုန်လုံး (Observers) ဆီကို Notification အလိုအလျောက် ရောက်လာပါလိမ့်မယ်။

- Subscribe မလုပ်ထားတဲ့သူတွေဆီတော့ ရောက်မှာမဟုတ်ပါဘူး။

ဒီနေရာမှာ YouTube Channel က Subject (သို့မဟုတ် Publisher) ဖြစ်ပြီး၊ Subscribe လုပ်ထားသူတွေက Observer (သို့မဟုတ် Subscriber) တွေ ဖြစ်ကြပါတယ်။

# PHP နဲ့ ရိုးရှင်းတဲ့ ဥပမာတစ်ခု ကြည့်ရအောင်

Website တစ်ခုမှာ User အသစ်တစ်ယောက် Register လုပ်လိုက်တဲ့အခါ နောက်ကွယ်ကနေ (၁) Welcome Email ပို့မယ်၊ (၂) SMS မက်ဆေ့ခ်ျ ပို့မယ်ဆိုတဲ့ စနစ်ကို ရေးကြည့်ပါမယ်။

## ၁။ Interfaces များ သတ်မှတ်ခြင်း

```
// စောင့်ကြည့်ခံရမည့် အရာ (YouTube Channel ကဲ့သို့)
interface Subject {
    public function attach(Observer $observer);
    public function detach(Observer $observer);
    public function notify();
}

// စောင့်ကြည့်မည့်သူ (Subscriber ကဲ့သို့)
interface Observer {
    public function update(Subject $subject);
}
```

## ၂။ Concrete Subject (လက်တွေ့ အခြေအနေပြောင်းလဲမည့် Class)

```
class UserRegistration implements Subject {
    private $observers = [];
    public $userData;

    // စောင့်ကြည့်မည့်သူကို စာရင်းသွင်းခြင်း (Subscribe)
    public function attach(Observer $observer) {
        $this->observers[] = $observer;
    }

    // စာရင်းမှ ပယ်ဖျက်ခြင်း (Unsubscribe)
    public function detach(Observer $observer) {
        $this->observers = array_filter($this->observers, function($o) use ($observer) {
            return $o !== $observer;
        });
    }

    // အခြေအနေ ပြောင်းလဲသွားရင် အားလုံးကို အကြောင်းကြားခြင်း
    public function notify() {
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }

    // User အသစ် Register လုပ်ခြင်း (State Change)
    public function registerUser($name, $email) {
        echo "User registered: $name ($email)\n";
        $this->userData = ['name' => $name, 'email' => $email];
        $this->notify(); // အားလုံးကို လှမ်းပြောပြီ!
    }
}
```

## ၃။ Concrete Observers (သတင်းရရင် အလုပ်လုပ်ကြမည့်သူများ)

```
class EmailNotifier implements Observer {
    public function update(Subject $subject) {
        echo "Email Sent to: " . $subject->userData['email'] . "\n";
    }
}

class SmsNotifier implements Observer {
    public function update(Subject $subject) {
        echo "SMS Sent to: " . $subject->userData['name'] . "\n";
    }
}
```

## လက်တွေ့ အသုံးပြုပုံ (Client Code)

```
$registration = new UserRegistration();

$emailListener = new EmailNotifier();
$smsListener = new SmsNotifier();

// ဘာတွေလုပ်ပေးရမလဲဆိုပြီး စာရင်းလာသွင်းထားကြတယ် (Attach)
$registration->attach($emailListener);
$registration->attach($smsListener);

// User တစ်ယောက် အကောင့်ဖွင့်လိုက်ပြီ
$registration->registerUser("Mg Mg", "mgmg@example.com");
```

# Laravel Framework မှာ Observer Pattern ကို ဘယ်လိုသုံးလဲ?

Laravel မှာတော့ ဒီ GoF Observer Pattern ကို ပိုမိုကောင်းမွန်အောင် ပြင်ဆင်ပြီး Events and Listeners နဲ့ Eloquent Observers ဆိုပြီး အသင့်သုံးစနစ်တွေ ထည့်ပေးထားပါတယ်။

ဥပမာ - Eloquent Observers (Database Model များကို စောင့်ကြည့်ခြင်း)

Laravel မှာ Model တစ်ခုခု (ဥပမာ - User Model) ထဲကို Data အသစ်ဝင်တာ၊ ပြင်တာ၊ ဖျက်တာတွေကို စောင့်ကြည့်ဖို့အတွက် သီးသန့် Observer Class တွေ ဆောက်နိုင်ပါတယ်။

## အဆင့် ၁: Command ရိုက်ပြီး Observer ဆောက်မယ်။

```
php artisan make:observer UserObserver --model=User
```

## အဆင့် ၂: ဆောက်လိုက်တဲ့ Class ထဲမှာ မိမိလုပ်ချင်တဲ့ Logic တွေ ရေးမယ်။ (ဒါဟာ GoF ရဲ့ update() method နေရာမှာ အစားထိုးတာပါ)

```
namespace App\Observers;

use App\Models\User;

class UserObserver
{
    // User အသစ် Insert ဖြစ်ပြီးသွားတိုင်း ဒီ Method က အလိုအလျောက် ပွင့်လာမယ်
    public function created(User $user)
    {
        // Welcome Email ပို့မည့် ကုဒ်များ...
        \Log::info("User created: " . $user->email);
    }
}
```

## အဆင့် ၃: ရေးထားတဲ့ Observer ကို AppServiceProvider မှာ သွားချိတ်ပေးရပါမယ် (ဒါက attach() လုပ်လိုက်တာနဲ့ အတူတူပါပဲ)။

```
namespace App\Providers;

use App\Models\User;
use App\Observers\UserObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // User Model ကို UserObserver နဲ့ စောင့်ကြည့်ခိုင်းလိုက်ခြင်း
        User::observe(UserObserver::class);
    }
}
```

## ဘာကြောင့် သုံးသင့်လဲ? (အကျိုးကျေးဇူးများ)

- Loose Coupling: Subject Class က သူ့ကို ဘယ်သူတွေ လာစောင့်ကြည့်နေလဲ (Email ပို့မယ့်သူလား၊ SMS ပို့မယ့်သူလား) အသေးစိတ် သိစရာမလိုပါဘူး။ ဒါကြောင့် တစ်ခုပြင်ရင် နောက်တစ်ခု လိုက်မပျက်တော့ပါဘူး။

- Open/Closed Principle: နောက်ပိုင်းမှာ User Register လုပ်ပြီးရင် Log ပါ မှတ်ချင်တယ်ဆိုပါစို့။ ရှိပြီးသား ကုဒ်တွေကို လိုက်ပြင်စရာမလိုဘဲ LogNotifier ဆိုတဲ့ Observer အသစ်တစ်ခု ဆောက်ပြီး attach() လုပ်ပေးလိုက်ရုံပါပဲ။
