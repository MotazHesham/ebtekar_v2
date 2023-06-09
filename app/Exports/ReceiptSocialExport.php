<?php

namespace App\Exports;

use App\Models\ReceiptSocial;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ReceiptSocialExport implements FromView, ShouldAutoSize
{
    protected $receipts;

    function __construct($receipts) {
        $this->receipts = $receipts;
    }

    public function view(): View
    {
        return view('excel_exports.receipt_social', [
            'receipts' => $this->receipts
        ]);
    }
}
