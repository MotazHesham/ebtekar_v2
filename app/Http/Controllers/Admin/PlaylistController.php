<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ReceiptCompany;
use App\Models\ReceiptSocial;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;

class PlaylistController extends Controller
{


    public function update_playlist_status(Request $request)
    {
        $order = ReceiptCompany::where('order_num', $request->order_num)->first();

        if ($order) {
            $order_num = $order->order_num;
        } else {
            $order = Order::where('order_num', $request->order_num)->first();
            if ($order) {
                $order_num = $order->order_num;
            } else {
                $order = ReceiptSocial::where('order_num', $request->order_num)->first();
                if ($order) {
                    $order_num = $order->order_num;
                } else {
                    return 0;
                }
            }
        }

        $order->send_to_playlist_date = date('Y-m-d H:i:s');
        $order->playlist_status = $request->status;
        $order->save();

        $id = 0;
        $to = '';
        if ($order->playlist_status == 'design') {
            $id = $order->designer_id;
            $to = 'الي الديزاينر';
        } elseif ($order->playlist_status == 'manufacturing') {
            $id = $order->manufacturer_id;
            $to = 'الي التصنيع';
        } elseif ($order->playlist_status == 'prepare') {
            $id = $order->preparer_id;
            $to = 'الي التجهيز';
        } elseif ($order->playlist_status == 'send_to_delivery') {
            $id = $order->send_to_delivery_id;
            $to = 'الي الأرسال للشحن';
        } elseif ($order->playlist_status == 'finish') {
            $to = 'الي الشحن';
        } elseif ($order->playlist_status == 'pending') {
            $to = 'الي الشركة';
        }

        if ($id != 0) {
            $title = $order_num;
            if ($request->condition == 'send') {
                $body = 'فاتورة جديدة';
            } else {
                $body = 'تم أرجاع الفاتورة';
            }
            $user = User::find($id);
            Notification::make()
                ->title($title . ' ' . $body)
                ->send()
                ->warning()
                ->sendToDatabase($user);
        }


        $title_2 = $order_num;
        if ($request->condition == 'send') {
            $body_2 = 'تم تحويل الفاتورة ' . $to;
        } else {
            $body_2 = 'تم أرجاع الفاتورة ' . $to;
        }


        Notification::make()
            ->title($title_2 . ' ' . $body_2)
            ->send()
            ->success()
            ->sendToDatabase(auth()->user());
        return redirect()->back();
    }


    public function qr_output(Request $request)
    {

        $order = ReceiptCompany::where('order_num', $request->code)->first();

        if (!$order) {
            $order = Order::where('order_num', $request->code)->first();
            if (!$order) {
                $order = ReceiptSocial::where('order_num', $request->code)->first();
                if (!$order) {
                    return [
                        'status' => 0,
                        'message' => "<div class='alert alert-danger'>" . $request->code . " Order Not Found</div>"
                    ];
                }
            }
        }


        if ($request->type == 'design') {
            $authenticated = $order->designer_id;
        } elseif ($request->type == 'manufacturing') {
            $authenticated = $order->manufacturer_id;
        } elseif ($request->type == 'prepare') {
            $authenticated = $order->preparer_id;
        } elseif ($request->type == 'send_to_delivery') {
            $authenticated = $order->send_to_delivery_id;
        }

        if ($order->playlist_status == $request->type) {
            if ($authenticated == auth()->user()->id || auth()->user()->user_type == 'admin') {
                if ($order->playlist_status == 'design') {
                    $next_type = 'manufacturing';
                } elseif ($order->playlist_status == 'manufacturing') {
                    $next_type = 'prepare';
                } elseif ($order->playlist_status == 'prepare') {
                    $next_type = 'send_to_delivery';
                } elseif ($order->playlist_status == 'send_to_delivery') {
                    $next_type = 'finish';

                    $order->delivery_man = $request->delivery_man_id;
                    $order->send_to_deliveryman_date = date('Y-m-d H:i:s');
                    $order->delivery_status = 'on_delivery';

                    $order->save();
                } else {
                    return [
                        'status' => 0,
                        'message' => "<div class='alert alert-danger'>" . $request->code . " SomeThing Went Wrong</div>"
                    ];
                }
            } else {
                return [
                    'status' => 0,
                    'message' => "<div class='alert alert-danger'>" . $request->code . " Not Authenticated</div>"
                ];
            }
        } else {
            return [
                'status' => 0,
                'message' => "<div class='alert alert-danger'>" . $request->code . " الطلب في مرحلة مختلفة</div>"
            ];
        }


        $playlistcontroller = new PlaylistController();
        $array = ['order_num' => $request->code, 'status' => $next_type, 'condition' => 'send'];
        $array0 = new \Illuminate\Http\Request($array);
        return [
            'status' => $playlistcontroller->update_playlist_status($array0),
            'message' => "<div class='alert alert-success'>" . $request->code . " تم الأرسال</div>"
        ];
    }
}
