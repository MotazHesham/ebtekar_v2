<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ReceiptClientExport;
use App\Http\Controllers\Controller;
use App\Models\ReceiptClient;
use App\Models\ReceiptClientProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class ReceiptClientController extends Controller
{
    public function actions($ids,$action){
        $receipts = ReceiptClient::whereIn('id',explode(',',substr($ids, 1, -1)))->get();
        if($action == 'print'){
            return view('receipts.prints.new_receipt_client_print_more', compact('receipts'));
        }elseif($action == 'download'){
            return Excel::download(new ReceiptClientExport($receipts), 'client_receipts.xlsx');
        }elseif($action == 'stats'){
            Session::put('unique','50%');
            return redirect()->back()->with(['stats' => true]);
        }
        return $action . $ids;
    }
    public function delete_product($id){
        $receipt = ReceiptClientProduct::find($id);
        $receipt_client = ReceiptClient::find($receipt->receipt_client_id);

        if ($receipt_client->playlist_status != 'pending')  {

            return back();
        }

        $receipt->delete();

        $receipt_products = ReceiptClientProduct::where('receipt_client_id', $receipt_client->id)->get();
        $sum = 0;
        foreach ($receipt_products as $row) {
            $sum += $row->total;
        }
        $receipt_client->total_cost = $sum;
        $receipt_client->save();

        return redirect()->back();

    }
}
