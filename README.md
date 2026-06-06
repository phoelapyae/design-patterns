Proxy Design Pattern ဆိုတာ Gang of Four (GoF) ရဲ့ Structural Design Pattern တစ်ခု ဖြစ်ပါတယ်။

***သူ့ရဲ့ အဓိက ရည်ရွယ်ချက်ကတော့ Object အစစ် (Real Object) ဆီကို တိုက်ရိုက် ဝင်ရောက်ခွင့် မပေးဘဲ၊ ကြားခံ ကိုယ်စားလှယ် (Placeholder သို့မဟုတ် Surrogate) တစ်ခု ခံပြီးမှ အဲဒီ Object အစစ်ဆီကို သွားရောက်ခွင့် (Access) ကို ထိန်းချုပ်တာ ဖြစ်ပါတယ်။***

ရိုးရိုးရှင်းရှင်း ဥပမာပေးရရင် - ကုမ္ပဏီတစ်ခုရဲ့ CEO (Object အစစ်) နဲ့ သွားတွေ့တဲ့အခါ တိုက်ရိုက်တွေ့လို့ မရပါဘူး။ ကြားခံ အတွင်းရေးမှူး (Proxy) ကနေ တစ်ဆင့် သွားရပါတယ်။

ဧည့်သည်က လာမေးတဲ့ မေးခွန်းကို အတွင်းရေးမှူးက သိတယ်ဆိုရင် CEO ဆီ သွားမမေးတော့ဘဲ သူပဲ တိုက်ရိုက် ဖြေလိုက်ပါတယ် (Cache Proxy)။

ဧည့်သည်က တွေ့ခွင့်ရှိတဲ့သူ ဟုတ်/မဟုတ် ကိုလည်း အတွင်းရေးမှူးကပဲ အရင် စစ်ဆေးပေးပါတယ် (Protection Proxy)။

တကယ်လို့ မဖြစ်မနေ လိုအပ်မှသာ CEO ဆီကို အလုပ်လွှဲပေးလိုက်တာ ဖြစ်ပါတယ်။

Proxy အမျိုးအစားများ (လက်တွေ့ အသုံးများသော နေရာများ)
Cache Proxy: ခဏခဏ လှမ်းခေါ်နေရတဲ့ (ဥပမာ - API call, Database query) တွေကို ကြားခံ Proxy က မှတ်ထားပေးပြီး (Cache)၊ ဒုတိယအကြိမ် ခေါ်ရင် Object အစစ်ဆီ မလွှတ်တော့ဘဲ မှတ်ထားတာကို တန်းပြန်ပေးဖို့။

Virtual Proxy (Lazy Loading): အရမ်းလေးလံတဲ့ Object ကြီးတွေကို စစချင်းမှာ မတည်ဆောက်သေးဘဲ (Memory မစားအောင်)၊ တကယ် အသုံးပြုမည့် အချိန်ကျမှသာ နောက်ကွယ်ကနေ တည်ဆောက်ပေးဖို့။

Protection Proxy: အသုံးပြုသူက ဒီ Object ကို ဝင်သုံးခွင့် (Permission/Auth) ရှိ/မရှိ ကြားခံ စစ်ဆေးပေးဖို့။

# PHP နဲ့ ရိုးရှင်းတဲ့ Cache Proxy ဥပမာတစ်ခု ကြည့်ရအောင်

ဗီဒီယိုတွေကို အင်တာနက်ကနေ ဒေါင်းလုဒ်လုပ်ပေးမယ့် Class (Object အစစ်) တစ်ခု ရှိပါတယ်။ ဒါပေမဲ့ ဗီဒီယိုတစ်ခုတည်းကို ခဏခဏ လာဒေါင်းနေရင် အချိန်ကြန့်ကြာတဲ့အတွက်၊ ကြားခံ Proxy Class တစ်ခု ဖန်တီးပြီး Cache မှတ်တဲ့ပုံစံ ရေးကြည့်ပါမယ်။

## ၁။ Interface ဆောက်ခြင်း (ပုံစံတူစေရန်)
Object အစစ် ရော၊ Proxy ပါ သုံးရမယ့် Interface ဖြစ်ပါတယ်။ Client က ဒီ Interface ကိုပဲ မြင်ရမှာပါ။

```
interface VideoDownloaderInterface {
    public function downloadVideo($videoId);
}
```

## ၂။ Real Subject (Object အစစ် - အလုပ်တကယ်လုပ်မည့် Class)

```
class VideoDownloader implements VideoDownloaderInterface {
    public function downloadVideo($videoId) {
        // Network Call လုပ်ပြီး ဒေါင်းလုဒ်ဆွဲသည့် (အချိန်ယူရသော) လုပ်ငန်းစဉ်
        echo "🌐 Downloading video strictly from YouTube API: $videoId...\n";
        return "Video_File_Data_For_$videoId";
    }
}
```

## ၃။ Proxy Class (ကိုယ်စားလှယ်)

```
class CachedVideoDownloaderProxy implements VideoDownloaderInterface {
    private VideoDownloaderInterface $realDownloader;

    private $cache = [];

    public function __construct(VideoDownloaderInterface $downloader) {
        $this->realDownloader = $downloader;
    }

    public function downloadVideo(string $videoId) {
        if (!isset($this->cache[$videoId])) {
            echo "⚠️ Cache miss. Passing request to RealDownloader...\n";
            $this->cache[$videoId] = $this->realDownloader->downloadVideo($videoId);
        } else {
            echo "✅ Serving from cache directly (No API call made): $videoId\n";
        }

        return $this->cache[$videoId];
    }
}
```

## လက်တွေ့ အသုံးပြုပုံ (Client Code)

```
$realDownloader = new VideoDownloader();
$cachedDownloader = new CachedVideoDownloaderProxy($realDownloader);

// First download (cache miss)
$cachedDownloader->downloadVideo("abc123");

// Second download (cache hit)
$cachedDownloader->downloadVideo("abc123");

// Downloading a different video (cache miss)
$cachedDownloader->downloadVideo("def456");
```

# Laravel Framework မှာ Proxy Pattern ကို ဘယ်လိုသုံးလဲ?

Web Application Architecture တွေ တည်ဆောက်တဲ့အခါ Proxy Pattern ကို အောက်ပါ နေရာတွေမှာ အထင်အရှား တွေ့မြင်နိုင်ပါတယ်။

## ၁။ Laravel Facades (Static Proxies)
Laravel မှာ ကျွန်တော်တို့ နေ့စဉ်သုံးနေတဲ့ Cache::get(), Route::get(), Log::info() ဆိုတဲ့ Facades တွေဟာ တကယ်တော့ Proxy Pattern အစစ်တွေ ဖြစ်ပါတယ်။

Client (Developer) က သုံးတဲ့အခါ Static Method လိုမျိုး လွယ်လွယ်ကူကူ ခေါ်သုံးလိုက်ပါတယ်။ ဒါပေမဲ့ နောက်ကွယ်မှာ Facade (Proxy) ကနေတစ်ဆင့် Service Container ထဲမှာ Bind လုပ်ထားတဲ့ Underlying Object အစစ် (ဥပမာ - Illuminate\Cache\CacheManager) ဆီကို လှမ်းပြီး Delegate (အလုပ်လွှဲ) ပေးသွားတာ ဖြစ်ပါတယ်။

## ၂။ Repository Pattern တွင် Cache ခံခြင်း (Cache Proxy)
Laravel နဲ့ Enterprise App တွေ ရေးတဲ့အခါ Controller နဲ့ Database (Model) ကြားမှာ ခဏခဏ Query လုပ်တာကို သက်သာအောင် Repository Proxy တွေ သုံးလေ့ရှိပါတယ်။

```
// Interface
interface UserRepositoryInterface {
    public function getUser($id);
}

// Real Object (Database ကို တကယ်ခေါ်မည့်ကောင်)
class DatabaseUserRepository implements UserRepositoryInterface {
    public function getUser($id) {
        return User::find($id);
    }
}

// Proxy (Cache လုပ်ပေးမည့်ကောင်)
class CachedUserRepositoryProxy implements UserRepositoryInterface {
    private $repo;

    public function __construct(DatabaseUserRepository $repo) {
        $this->repo = $repo;
    }

    public function getUser($id) {
        // Cache မှာရှိရင် ယူ၊ မရှိရင် DatabaseUserRepository (Real Object) ဆီကနေ သွားယူ
        return Cache::remember("user.{$id}", 3600, function () use ($id) {
            return $this->repo->getUser($id);
        });
    }
}
```

ဒီလိုရေးထားတဲ့အတွက် Controller ထဲမှာ Cache Logic တွေ ရှုပ်ပွမနေတော့ဘဲ၊ Proxy Class ကသာ Cache လုပ်ငန်းစဉ်ကို သန့်သန့်ရှင်းရှင်း တာဝန်ယူသွားပါတယ်။

## အားသာချက်များနှင့် အားနည်းချက်များ (Pros & Cons)

### ကောင်းကွက်များ (Pros)

- Security & Access Control: Object အစစ်ဆီကို တိုက်ရိုက်မသွားနိုင်အောင် Proxy က တားဆီးပေးပြီး၊ လိုအပ်တဲ့ Permission စစ်ဆေးမှုတွေကို လုပ်ဆောင်ပေးနိုင်ပါတယ်။

- Performance (Performance Optimization): လေးလံတဲ့ လုပ်ဆောင်ချက်တွေကို Cache လုပ်ပေးခြင်း သို့မဟုတ် Lazy Loading သုံးပေးခြင်းဖြင့် စနစ်တစ်ခုလုံးကို မြန်ဆန်စေပါတယ်။

- Open/Closed Principle: ရှိပြီးသား Object အစစ်ရဲ့ ကုဒ်တွေကို လုံးဝ သွားပြင်စရာမလိုဘဲ (ဥပမာ - RealVideoDownloader ကို လိုက်မပြင်ဘဲ) Proxy ကနေတစ်ဆင့် အင်္ဂါရပ်အသစ် (ဥပမာ - Cache, Logging, Rate Limiting) တွေကို အလွယ်တကူ ထပ်တိုးနိုင်ပါတယ်။

- Separation of Concerns: Business Logic အစစ်နဲ့ (Caching/Auth ကဲ့သို့) Infrastructure Logic တွေကို Class တစ်ခုတည်းမှာ ရောထွေးမနေအောင် ခွဲထုတ်ပေးနိုင်ပါတယ်။

### ဆိုးကွက်များ (Cons)

- Code Complexity: Interface တွေရော၊ Proxy Class တွေရော အသစ်ထပ်ဆောက်ရတဲ့အတွက် ရိုးရှင်းတဲ့ Project တွေမှာဆိုရင် မလိုအပ်ဘဲ ကုဒ်တွေ ရှုပ်ထွေး (Over-engineered) သွားနိုင်ပါတယ်။

- Latency (နှောင့်နှေးမှု): Request တစ်ခုက Proxy တွေကို အဆင့်ဆင့် ဖြတ်သန်းသွားရတဲ့အတွက် (အထူးသဖြင့် Proxy ထဲမှာ စစ်ဆေးချက်တွေ အများကြီး ထည့်ထားရင်) Response Time အနည်းငယ် ကြန့်ကြာနိုင်ပါတယ်။
