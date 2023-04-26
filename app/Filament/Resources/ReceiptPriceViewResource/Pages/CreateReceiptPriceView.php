<?php

namespace App\Filament\Resources\ReceiptPriceViewResource\Pages;

use App\Filament\Resources\ReceiptPriceViewResource;
use App\Models\ReceiptPriceView;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateReceiptPriceView extends CreateRecord
{
    protected static string $resource = ReceiptPriceViewResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {

        $last_receipt_price_view = ReceiptPriceView::withTrashed()->latest()->first();
        if($last_receipt_price_view){
            $order_num = $last_receipt_price_view->order_num ? intval(str_replace('#','',strrchr($last_receipt_price_view->order_num,"#"))) : 0;
        }else{
            $order_num = 0;
        }

        $data['staff_id'] = auth()->user()->id;
        $data['order_num'] =  'receipt-price-view#' . ($order_num + 1);
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
