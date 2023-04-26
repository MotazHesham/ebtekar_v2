<?php

namespace App\Filament\Resources\ReceiptOutgoingResource\Pages;

use App\Filament\Resources\ReceiptOutgoingResource;
use App\Models\ReceiptOutgoing;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateReceiptOutgoing extends CreateRecord
{
    protected static string $resource = ReceiptOutgoingResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {

        $last_receipt_outgoings = ReceiptOutgoing::latest()->first();
        if($last_receipt_outgoings){
            $order_num = $last_receipt_outgoings->order_num ? intval(str_replace('#','',strrchr($last_receipt_outgoings->order_num,"#"))) : 0;
        }else{
            $order_num = 0;
        }

        $data['staff_id'] = auth()->user()->id;
        $data['order_num'] =  'receipt-outgoings#' . ($order_num + 1);
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
