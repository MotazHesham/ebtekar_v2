<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ReceiptSocialDeliveryExport;
use App\Exports\ReceiptSocialExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReceiptSocialProduct;
use App\Models\ReceiptSocial;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class ReceiptSocialController extends Controller
{
    public function actions($ids,$action){
        $receipts = ReceiptSocial::whereIn('id',explode(',',substr($ids, 1, -1)))->get();
        if($action == 'print'){
            return view('receipts.social.print', compact('receipts'));
        }elseif($action == 'receive_money'){
            return view('receipts.social.receive_money', compact('receipts'));
        }elseif($action == 'download'){
            return Excel::download(new ReceiptSocialExport($receipts), 'social_receipts.xlsx');
        }elseif($action == 'download_for_delivery'){
            return Excel::download(new ReceiptSocialDeliveryExport($receipts), 'social_receipts_delivery.xlsx');
        }elseif($action == 'stats'){
            Session::put('receipts_count',$receipts->count());
            Session::put('commissions',$receipts->sum('commission'));
            Session::put('total_cost',$receipts->sum('total_cost') + $receipts->sum('extra_commission'));
            Session::put('stats',true);
            return redirect()->back();
        }
        return $action . $ids;
    }
    public function delete_product($id){
        $receipt = ReceiptSocialProduct::find($id);
        $receipt_social = ReceiptSocial::find($receipt->receipt_social_id);
        if (Auth::user()->user_type != 'admin') {
            if ($receipt_social->playlist_status != 'pending') {

                return back();
            }
        }

        $receipt->delete();

        $receipt_products = ReceiptSocialProduct::where('receipt_social_id', $receipt_social->id)->get();
        $sum = 0;
        $sum2 = 0;
        $sum3 = 0;
        foreach ($receipt_products as $row) {
            $sum += $row->total;
            $sum2 += $row->commission;
            $sum3 += ($row->extra_commission * $row->quantity);
        }
        $receipt_social->total_cost = $sum;
        $receipt_social->commission = $sum2;
        $receipt_social->extra_commission = $sum3;
        $receipt_social->save();

        return back();

    }
}
