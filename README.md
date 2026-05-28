***Template Method Design Pattern*** ဆိုတာ Gang of Four (GoF) ရဲ့ Behavioral Design Pattern တစ်ခု ဖြစ်ပါတယ်။

သူ့ရဲ့ အဓိက ရည်ရွယ်ချက်ကတော့ အလုပ်တစ်ခု လုပ်ဆောင်မယ့် လုပ်ငန်းစဉ်အဆင့်ဆင့် (Skeleton or Workflow) ကို Class တစ်ခုထဲမှာ ပုံသေ သတ်မှတ်ထားပြီး၊ အဲဒီအဆင့်တွေထဲက တချို့သော အလုပ်တွေကိုတော့ Subclasses (သူ့ကို ဆက်ခံမယ့် Class အလတ်စား/အငယ်စားတွေ) ကနေ စိတ်ကြိုက် ပြောင်းလဲပြင်ဆင်ခွင့် (Override) ပေးထားတာ ဖြစ်ပါတယ်။

ရိုးရိုးရှင်းရှင်း ဥပမာပေးရရင် - အိမ်ဆောက်တာကို မြင်ကြည့်ပါ။
အိမ်ဆောက်မယ့် ပုံသေ အဆင့်ဆင့် (Template) ကတော့ အတူတူပဲ ဖြစ်ပါတယ်။

1. ပန္နက်ရိုက်မယ် (buildFoundation)

2. တိုင်ထူမယ် (buildPillars)

3. အမိုးမိုးမယ် (buildRoof)

ဒီနေရာမှာ ကုမ္ပဏီကြီးကနေ အဆင့် (၁) နဲ့ (၂) ကို ပုံသေ သတ်မှတ်ထားပြီး၊ အဆင့် (၃) အမိုးမိုးတဲ့နေရာ ရောက်ရင်တော့ ဝယ်သူက သွပ်မိုးချင်လား၊ အုတ်ကြွပ်မိုးချင်လား စိတ်ကြိုက် ရွေးချယ်ခွင့် ပေးထားတာမျိုး ဖြစ်ပါတယ်။

PHP နဲ့ ရိုးရှင်းတဲ့ ဥပမာတစ်ခု ကြည့်ရအောင်
ကျွန်တော်တို့ Website တစ်ခုမှာ စာသားတွေ ထုတ်ပေးမယ့် (Report Generation) စနစ်တစ်ခု ရေးကြည့်ပါမယ်။ Report ထုတ်တဲ့ Process က တူတူပဲ ဖြစ်ရပါမယ်။ (Data ဖတ်မယ် -> Format ပြောင်းမယ် -> Export ထုတ်မယ်)

## ၁။ Abstract Class (Template ကြီးကို အဓိက သတ်မှတ်ပေးသည့်နေရာ)

```
abstract class ReportGenerator {
    
    // ဒါက Template Method ဖြစ်ပါတယ်။ လုပ်ငန်းစဉ် အဆင့်ဆင့်ကို ပုံသေချုပ်ထားတယ်။
    // Subclass တွေက ဒီ Method ကို လာပြင်လို့မရအောင် 'final' ပေးထားလေ့ရှိပါတယ်။
    final public function generateReport() {
        $this->fetchData();
        $this->formatData();
        $this->export();
    }

    // အဆင့် ၁ - ဘယ် Report မဆို Data ဖတ်ပုံခြင်း တူတူပဲမို့ တစ်ခါတည်း ရေးထားမယ်
    protected function fetchData() {
        echo "Fetching data from Database...\n";
    }

    // အဆင့် ၂ နဲ့ ၃ ကိုတော့ Subclass တွေက ကိုယ့်ဘာသာ စိတ်ကြိုက် ရေးခွင့်ပေးမယ်
    abstract protected function formatData();
    abstract protected function export();
}
```

## ၂။ Concrete Classes (မိမိနဲ့ ကိုက်ညီမည့် အဆင့်တွေကိုပဲ ဝင်ပြင်ကြခြင်း)

```
// PDF Format နဲ့ ထုတ်ပေးမယ့် Class
class PdfReport extends ReportGenerator {
    protected function formatData() {
        echo "Formatting data for PDF layout.\n";
    }

    protected function export() {
        echo "Exporting into a .pdf file.\n";
    }
}

// Excel Format နဲ့ ထုတ်ပေးမယ့် Class
class ExcelReport extends ReportGenerator {
    protected function formatData() {
        echo "Formatting data into rows and columns for Excel.\n";
    }

    protected function export() {
        echo "Exporting into a .xlsx file.\n";
    }
}
```

လက်တွေ့ အသုံးပြုပုံ (Client Code)

```
echo "--- Generating PDF ---\n";
$pdf = new PdfReport();
$pdf->generateReport(); 

echo "\n--- Generating Excel ---\n";
$excel = new ExcelReport();
$excel->generateReport();
```

## Laravel Framework မှာ Template Pattern ကို ဘယ်လိုသုံးလဲ?

Laravel ကို သုံးဖူးသူတိုင်း Template Pattern နဲ့ မသိမသာ ထိတွေ့ဖူးကြပါတယ်။ အကောင်းဆုံး ဥပမာကတော့ Laravel Migrations ပါပဲ။

Laravel ရဲ့ Illuminate\Database\Migrations\Migration ဆိုတဲ့ အခြေခံ Class ကြီးထဲမှာ ဖွဲ့စည်းပုံတွေ လုပ်ငန်းစဉ်တွေကို သတ်မှတ်ပေးထားပြီး၊ ကျွန်တော်တို့ကို up() နဲ့ down() ဆိုတဲ့ အဆင့် နှစ်ခုကိုပဲ ဝင်ရောက် သတ်မှတ်ခိုင်းတာ ဖြစ်ပါတယ်။

```
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    // ပုံသေ Template စနစ်ကြီးထဲကနေ ကျွန်တော်တို့ စိတ်ကြိုက် ဝင်ပြင်ရမယ့် အဆင့် (Method)
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
    }

    // ကျွန်တော်တို့ စိတ်ကြိုက် ဝင်ပြင်ရမယ့် အဆင့် (Method)
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
```

နောက်ကွယ်မှာ Laravel ရဲ့ Migrator စနစ်ကြီး (Template Controller) ကနေပြီး Table တွေ ဆောက်တော့မယ်ဆိုရင် ဘယ်လို Transaction တွေ ဖွင့်ရမယ်၊ ဘယ်လို Log မှတ်ရမယ်ဆိုတဲ့ အဆင့်တွေကို ပုံသေ မောင်းနှင်ပေးသွားပြီး၊ Handlers တွေအနေနဲ့ ကျွန်တော်တို့ ရေးထားတဲ့ up() သို့မဟုတ် down() ကို လှမ်းခေါ်ပေးသွားတာ ဖြစ်ပါတယ်။

# Laravel ၏ Template Pattern: FormRequest (Validation)

Laravel ရဲ့ Custom Validation Class (php artisan make:request) တွေကို ကြည့်ပါ။ သူတို့ဟာ FormRequest ဆိုတဲ့ Parent Class ကြီးကို Extends (ဆက်ခံ) လုပ်ထားကြပါတယ်။

Laravel က နောက်ကွယ်မှာ Request တစ်ခု ဝင်လာရင် Authorization စစ်မယ် -> Validation စစ်မယ် ဆိုတဲ့ လုပ်ငန်းစဉ် (Template) ကို ချမှတ်ထားပြီးသားပါ။ ကျွန်တော်တို့ကိုတော့ authorize() နဲ့ rules() ဆိုတဲ့ နည်းလမ်းနှစ်ခုထဲမှာပဲ မိမိတို့ စိတ်ကြိုက် Logic တွေကို ဝင်ပြင်ခွင့် (Template ဖြည့်ခွင့်) ပေးထားတာ ဖြစ်ပါတယ်။

```
use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    // ပုံသေစနစ်ကြီးထဲကနေ ကိုယ်တိုင်ဝင်ပြင်ရမည့် အဆင့် (၁)
    public function authorize()
    {
        return true; 
    }

    // ပုံသေစနစ်ကြီးထဲကနေ ကိုယ်တိုင်ဝင်ပြင်ရမည့် အဆင့် (၂)
    public function rules()
    {
        return [
            'title' => 'required|max:255',
        ];
    }
}
```

# ***ဘာကြောင့် သုံးသင့်လဲ? (အကျိုးကျေးဇူးများ)***

- Code Reuse (ကုဒ်တွေ ထပ်မရေးရခြင်း): တူညီတဲ့ လုပ်ငန်းစဉ် အဆင့်ဆင့်တွေနဲ့ Logic တွေကို Parent Class ကြီးထဲမှာ တစ်ခါတည်း ရေးထားနိုင်လို့ ကုဒ်တွေ ထပ်ခါတလဲလဲ ရေးရခြင်းကို ကာကွယ်ပေးပါတယ်။

- Controlled Flexibility: Subclasses တွေကို စိတ်ကြိုက် ခြယ်လှယ်ခွင့် ပေးထားတယ် ဆိုသော်လည်း၊ ပင်မ စနစ်ကြီးရဲ့ Framework (လုပ်ငန်းစဉ်အဆင့်ဆင့်) ကိုတော့ ကျော်လွန် ဖျက်ဆီးလို့ မရအောင် ထိန်းချုပ်ပေးထားပါတယ်။

- သင့်မှာ လုပ်ငန်းစဉ် အဆင့်ဆင့် (Algorithm Skeleton) ရှိပြီး၊ ၎င်းအဆင့်တွေကို ပုံသေသတ်မှတ်လျက် အသေးစိတ် အလုပ်လုပ်ပုံကိုပဲ Subclasses တွေဆီ လွှဲပေးချင်ရင် ➡️ Template Method Pattern ကို သုံးပါ။
