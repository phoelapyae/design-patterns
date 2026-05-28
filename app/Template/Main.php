<?php

namespace App\Template;

class Main {
    public function main() {
        echo "Generating Excel Report:\n";
        $excelReport = new ExcelReport();
        $excelReport->generateReport();

        echo "\nGenerating PDF Report:\n";
        $pdfReport = new PdfReport();
        $pdfReport->generateReport();
    }
}
