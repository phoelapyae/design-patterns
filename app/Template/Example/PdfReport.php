<?php

namespace App\Template\Example;

class PdfReport extends ReportGenerator {
    protected function formatData() {
        echo "Formatting data for PDF layout.\n";
    }

    protected function export() {
        echo "Exporting into a .pdf file.\n";
    }
}
