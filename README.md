Builder Design Pattern ဆိုတာ Gang of Four (GoF) ရဲ့ Creational Design Pattern တစ်ခု ဖြစ်ပါတယ်။

***သူ့ရဲ့ အဓိက ရည်ရွယ်ချက်ကတော့ အဆင့်ဆင့် တည်ဆောက်ရပြီး ပါဝင်ပစ္စည်းတွေ ရှုပ်ထွေးလှတဲ့ Object ကြီးတစ်ခုရဲ့ တည်ဆောက်ပုံလုပ်ငန်းစဉ် (Complex Construction Process) ကို သီးသန့်ခွဲထုတ်လိုက်ပြီး၊ တူညီတဲ့ တည်ဆောက်ပုံ အဆင့်ဆင့်အတိုင်းနဲ့ပဲ မတူညီတဲ့ Object ပုံစံအမျိုးမျိုး (Different Representations) ကို စိတ်ကြိုက်ပြောင်းလဲ ထုတ်လုပ်နိုင်အောင် ဖန်တီးပေးတာ ဖြစ်ပါတယ်။***

# 💡 ဘာပြဿနာကို ရှင်းပေးတာလဲ? (Telescoping Constructor Anti-pattern)

ဥပမာ - သင့်မှာ Product Class တစ်ခုရှိပြီး သူ့မှာ Parameter ပေါင်း ၂၀ လောက် ရှိတယ်ဆိုပါစို့။ အချို့ Parameter တွေက မဖြစ်မနေလိုပြီး၊ အချို့က Optional (ထည့်ချင်မှထည့်) တဲ့အရာတွေ ဖြစ်ပါတယ်။ အဲဒါကို သာမန် __construct($p1, $p2, $p3, $p4, ...) နဲ့ ဆောက်ရင် ကုဒ်တွေက ဖတ်ရခက်ပြီး ရှုပ်ပွသွားပါလိမ့်မယ်။ သုံးချင်တဲ့ Parameter ပါဖို့အတွက် ကျန်တဲ့နေရာတွေမှာ null တွေ လိုက်ထည့်နေရတတ်ပါတယ်။ Builder Pattern က ဒီပြဿနာကို အပြတ်အသတ် ရှင်းပေးပါတယ်။

ရိုးရိုးရှင်းရှင်း ဥပမာပေးရရင် - ကွန်ပျူတာတစ်လုံး (Custom PC) ဆောက်တာကို မြင်ကြည့်ပါ။

- ကွန်ပျူတာတစ်လုံး ဖြစ်လာဖို့ CPU, RAM, Storage, GPU, Cooler စတာတွေကို အဆင့်ဆင့် တပ်ဆင်ရပါတယ်။

- သင်က ရုံးသုံး PC ဆောက်ချင်ရင် Graphic Card အနိမ့်စား ထည့်မယ်။ Gaming PC ဆောက်ချင်ရင် Graphic Card အမြင့်စား ထည့်မယ်။

- ဒါပေမဲ့ တပ်ဆင်တဲ့ အဆင့်ဆင့် လုပ်ငန်းစဉ်ကတော့ အတူတူပါပဲ။ Builder Pattern က ဒီလိုမျိုး အဆင့်ဆင့် တည်ဆောက်မှုကို တာဝန်ယူပေးတာ ဖြစ်ပါတယ်။

# PHP နဲ့ ရိုးရှင်းတဲ့ ဥပမာတစ်ခု ကြည့်ရအောင်
Custom SQL Query တစ်ခုကို အဆင့်ဆင့် တည်ဆောက်ပေးမယ့် QueryBuilder တစ်ခုကို ရေးကြည့်ပါမယ်။

## ၁။ Product Class (နောက်ဆုံး ထွက်လာမည့် ရှုပ်ထွေးသော Object)

```
class SQLQuery {
    public string $table;
    public array $fields = ['*'];
    public array $wheres = [];
    public string $limit = '';

    public function getSQL(): string {
        $sql = "SELECT " . implode(', ', $this->fields) . " FROM " . $this->table;
        if (!empty($this->wheres)) {
            $sql .= " WHERE " . implode(' AND ', $this->wheres);
        }
        if ($this->limit) {
            $sql .= " LIMIT " . $this->limit;
        }
        return $sql;
    }
}
```

## ၂။ Builder Interface (တည်ဆောက်မည့် အဆင့်ဆင့် ပုံစံခွက်)

```
interface QueryBuilderInterface {
    public function select(array $fields): self;
    public function where(string $column, string $value): self;
    public function limit(int $value): self;
    public function getQuery(): SQLQuery; // နောက်ဆုံး ထွက်ကုန်ကို ယူမည့် Method
}
```

## ၃။ Concrete Builder (အလုပ်တကယ်လုပ်မည့် Builder Class)
Method တိုင်းမှာ $this ကို ပြန်ပေးခြင်းဖြင့် Fluent Interface (Method Chaining) ပုံစံ ရေးနိုင်ပါတယ်။

```
class MysqlQueryBuilder implements QueryBuilderInterface {
    private SQLQuery $query;

    public function __construct(string $table) {
        $this->query = new SQLQuery();
        $this->query->table = $table;
    }

    public function select(array $fields): self {
        $this->query->fields = $fields;
        return $this;
    }

    public function where(string $column, string $value): self {
        $this->query->wheres[] = "$column = '$value'";
        return $this;
    }

    public function limit(int $value): self {
        $this->query->limit = (string) $value;
        return $this;
    }

    public function getQuery(): SQLQuery {
        return $this->query;
    }
}
```

## လက်တွေ့ အသုံးပြုပုံ (Client Code)
Client က new SQLQuery() ဆိုပြီး လက်ဝင်စွာ ဆောက်စရာမလိုတော့ဘဲ Builder ကို သုံးပြီး လိုချင်တဲ့ အစိတ်အပိုင်းတွေကို အဆင့်ဆင့် ကွင်းဆက်ချိတ် (Method Chaining) ပြီး ဆောက်သွားနိုင်ပါတယ်။

```
$builder = new MysqlQueryBuilder('users');

// အဆင့်ဆင့် တည်ဆောက်ခြင်း
$myQuery = $builder->select(['id', 'name', 'email'])
                   ->where('status', 'active')
                   ->limit(10)
                   ->getQuery(); // နောက်ဆုံးမှ Object အစစ်ကို ထုတ်ယူသည်

echo $myQuery->getSQL();
// Output: SELECT id, name, email FROM users WHERE status = 'active' LIMIT 10
```

# Laravel Framework မှာ Builder Pattern ကို ဘယ်လိုသုံးလဲ?

Laravel ဟာ ခေတ်သစ် PHP Framework ဖြစ်တဲ့အတွက် GoF ရဲ့ မူရင်း Builder pattern ထက် ပိုမိုပြောင်းလွယ်ပြင်လွယ်ရှိတဲ့ Fluent Builder ပုံစံကို နေရာတိုင်းမှာ သုံးထားပါတယ်။

# ၁။ Laravel Database Query Builder
ဒါကတော့ အထင်ရှားဆုံး ပြယုဂ်ပါပဲ။ Developer တိုင်း နေ့တိုင်း သုံးနေကြတာ ဖြစ်ပါတယ်။

```
use Illuminate\Support\Facades\DB;

$users = DB::table('users')
            ->select('name', 'email')
            ->where('email_verified_at', '!=', null)
            ->orderBy('created_at', 'desc')
            ->get();
```

## ၂။ Laravel Mail / Notification Message Builder
Laravel မှာ အီးမေးလ် ပို့တဲ့အခါ MailMessage Object ကြီးကို တည်ဆောက်ဖို့အတွက်လည်း Builder Pattern ကို သုံးပါတယ်။

```
public function toMail($notifiable)
{
    return (new \Illuminate\Notifications\Messages\MailMessage)
                ->greeting('Hello!')
                ->line('Your invoice is ready for download.')
                ->action('View Invoice', url('/invoices'))
                ->line('Thank you for using MS-Remit!');
}
```

ဒီနေရာမှာ greeting(), line(), action() စတဲ့ မတူညီတဲ့ ရွေးချယ်စရာ Parameter တွေကို Constructor ထဲမှာ ရောပြွမ်းမနေစေဘဲ၊ Builder စနစ်နဲ့ သန့်သန့်ရှင်းရှင်း အဆင့်ဆင့် တည်ဆောက်သွားတာ ဖြစ်ပါတယ်။

# အားသာချက်များနှင့် အားနည်းချက်များ (Pros & Cons)

### ကောင်းကွက်များ (Pros)

- Avoid Telescoping Constructor: Parameter ပေါင်းများစွာ ပါဝင်တဲ့ Constructor အရှည်ကြီးတွေ ရေးရတဲ့ ဘေးဒုက္ခကနေ ကင်းဝေးစေပါတယ်။ ကုဒ်တွေ ဖတ်ရတာ အရမ်း သန့်ရှင်းသွားပါတယ်။

- Immutability & Step-by-Step Creation: Object တစ်ခုလုံးကို တစ်ပြိုင်နက် ဆောက်စရာမလိုဘဲ လုပ်ငန်းစဉ်အလိုက် ဖြည်းဖြည်းချင်း အဆင့်ဆင့် တည်ဆောက်နိုင်ပါတယ်။ လိုအပ်တဲ့ အစိတ်အပိုင်းတွေ အားလုံး ပြည့်စုံမှသာ နောက်ဆုံးထွက်ကုန် (Product) ကို ထုတ်ယူနိုင်ပါတယ်။

- Single Responsibility Principle: ရှုပ်ထွေးလှတဲ့ Object တည်ဆောက်ပုံ Logic တွေကို ပင်မ Business Logic ကုဒ်တွေထဲကနေ သီးသန့် ခွဲထုတ်ထားနိုင်ပါတယ်။

- Fluent Interface Support: ခေတ်သစ် Web Development မှာ Method Chaining (->where()->limit()) ပုံစံနဲ့ ကုဒ်ကို လှလှပပနဲ့ ဖတ်ရလွယ်အောင် ရေးသားနိုင်စေပါတယ်။

### ဆိုးကွက်များ (Cons)

- Class ပွားများခြင်း (Increased Complexity): မူရင်း Product Class အပြင်၊ နောက်ထပ် Builder Interface တွေ၊ Concrete Builder Class တွေ အသစ်ထပ်ဆောက်ရတဲ့အတွက် ကုဒ်ဖိုင် အရေအတွက် ပိုများလာပါတယ်။

- Code Duplication: Product Class ထဲက Property တွေ ပြောင်းလဲသွားရင် သက်ဆိုင်ရာ Builder Class တွေထဲမှာပါ လိုက်လံ ပြင်ဆင်ပေးရတတ်ပါတယ်။
