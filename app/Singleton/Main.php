<?php

namespace App\Singleton;

class Main {
    public function run() {
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
    }
}
