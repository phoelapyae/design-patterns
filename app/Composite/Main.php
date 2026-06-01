<?php

namespace App\Composite;

class Main {
    public function main() {
        // File များ ဆောက်ခြင်း
        $file1 = new File("photo.jpg", 500); // 500 KB
        $file2 = new File("resume.pdf", 200); // 200 KB
        $file3 = new File("notes.txt", 100);  // 100 KB

        // Folder ဆောက်ပြီး File များ ထည့်ခြင်း
        $subFolder = new Folder("My Documents");
        $subFolder->add($file2);
        $subFolder->add($file3); // subFolder size = 200 + 100 = 300 KB

        $rootFolder = new Folder("C: Drive");
        $rootFolder->add($file1);
        $rootFolder->add($subFolder); // rootFolder size = 500 + 300 = 800 KB

        // Client က File ရော Folder ကိုပါ getSize() ဆိုပြီး တစ်ပြေးညီ လှမ်းခေါ်ရုံပါပဲ
        echo "File 1 Size: " . $file1->getSize() . " KB\n";       // Output: 500 KB
        echo "Root Folder Size: " . $rootFolder->getSize() . " KB\n"; // Output: 800 KB
    }
}
