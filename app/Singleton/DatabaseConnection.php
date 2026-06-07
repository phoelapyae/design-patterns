<?php

namespace App\Singleton;

class DatabaseConnection {
    // Instance ကို သိမ်းထားမည့် Private Static Variable
    private static object|null $instance = null;

    // Database connection string ကို မှတ်ထားရန် ဥပမာ
    private string $connectionString;

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
