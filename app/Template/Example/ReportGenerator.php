<?php

namespace App\Template\Example;

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
