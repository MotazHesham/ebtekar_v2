<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ReceiptOutgoingExport;
use App\Http\Controllers\Controller;
use App\Models\ReceiptOutgoing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class ReceiptOutgoingsController extends Controller
{
    public function actions($ids,$action){
        $receipts = ReceiptOutgoing::whereIn('id',explode(',',substr($ids, 1, -1)))->get();
        if($action == 'print'){
            return view('receipts.prints.new_receipt_outgoings_print_more', compact('receipts'));
        }elseif($action == 'download'){
            return Excel::download(new ReceiptOutgoingExport($receipts), 'outgoings_receipts.xlsx');
        }elseif($action == 'stats'){
            Session::put('unique','50%');
            return redirect()->back()->with(['stats' => true]);
        }
        return $action . $ids;
    }
}
