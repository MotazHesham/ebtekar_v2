<?php

namespace App\Filament\Resources\ReceiptClientResource\Pages;

use App\Filament\Resources\ReceiptClientResource;
use App\Models\ReceiptClient;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateReceiptClient extends CreateRecord
{
    protected static string $resource = ReceiptClientResource::class;

    public function mount(): void
    {
        $data = searchByPhone(request('phone_number'));

        $this->form->fill([
            'client_name' => $data['client_name'],
            'phone_number' => $data['phone_number'] ?? request('phone_number'),
        ]);

    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {

        $last_receipt_client = ReceiptClient::withTrashed()->latest()->first();
        if($last_receipt_client){
            $order_num = $last_receipt_client->order_num ? intval(str_replace('#','',strrchr($last_receipt_client->order_num,"#"))) : 0;
        }else{
            $order_num = 0;
        }

        $data['staff_id'] = auth()->user()->id;
        $data['order_num'] =  'receipt-client#' . ($order_num + 1);
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
