<?php

namespace App\Filament\Resources\ReceiptSocialResource\Pages;

use App\Filament\Resources\ReceiptSocialResource;
use App\Models\Country;
use App\Models\ReceiptSocial;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateReceiptSocial extends CreateRecord
{
    protected static string $resource = ReceiptSocialResource::class;

    public function mount(): void
    {
        $data = searchByPhone(request('phone_number'));

        $this->form->fill([
            'client_name' => $data['client_name'],
            'type' => $data['type'],
            'phone_number' => $data['phone_number'] ?? request('phone_number'),
            'phone_number2' => $data['phone_number2'],
            'shipping_address' => $data['shipping_address'],
            'country_id' => $data['shipping_country_id'],
        ]);

    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $country = Country::findOrFail($data['country_id']);

        $last_receipt_social = ReceiptSocial::where('receipt_type','social')->withTrashed()->latest()->first();
        if($last_receipt_social){
            $order_num = $last_receipt_social->order_num ? intval(str_replace('#','',strrchr($last_receipt_social->order_num,"#"))) : 0;
        }else{
            $order_num = 0;
        }

        $data['staff_id'] = auth()->user()->id;
        $data['receipt_type'] = 'social';
        $data['shipping_country_id'] = $country->id;
        $data['shipping_country_name'] = $country->name;
        $data['shipping_country_cost'] = $country->cost;
        $data['order_num'] =  'receipt-social#' . ($order_num + 1);
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
