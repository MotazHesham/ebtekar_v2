<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReceiptCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReceiptCompanyExport;

class ReceiptCompanyController extends Controller
{
    public function actions($ids,$action){
        $receipts = ReceiptCompany::whereIn('id',explode(',',substr($ids, 1, -1)))->get();
        if($action == 'print'){
            return view('receipts.prints.new_receipt_company_print_more', compact('receipts'));
        }elseif($action == 'download'){
            return Excel::download(new ReceiptCompanyExport($receipts), 'company_receipts.xlsx');
        }elseif($action == 'stats'){
            Session::put('unique','50%');
            return redirect()->back()->with(['stats' => true]);
        }
        return $action . $ids;
    }
}
