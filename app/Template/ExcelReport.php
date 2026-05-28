<?php

namespace App\Template;

class ExcelReport extends ReportGenerator {
    protected function formatData() {
        echo "Formatting data into rows and columns for Excel.\n";
    }

    protected function export() {
        echo "Exporting into a .xlsx file.\n";
    }
}
