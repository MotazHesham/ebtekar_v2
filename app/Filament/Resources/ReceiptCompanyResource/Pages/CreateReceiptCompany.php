<?php

namespace App\Filament\Resources\ReceiptCompanyResource\Pages;

use App\Filament\Resources\ReceiptCompanyResource;
use App\Models\Country;
use App\Models\ReceiptCompany;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateReceiptCompany extends CreateRecord
{
    protected static string $resource = ReceiptCompanyResource::class;

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

        $last_receipt_company = ReceiptCompany::withTrashed()->latest()->first();
        if($last_receipt_company){
            $order_num = $last_receipt_company->order_num ? intval(str_replace('#','',strrchr($last_receipt_company->order_num,"#"))) : 0;
        }else{
            $order_num = 0;
        }

        $data['staff_id'] = auth()->user()->id;
        $data['shipping_country_id'] = $country->id;
        $data['shipping_country_name'] = $country->name;
        $data['shipping_country_cost'] = $country->cost;
        $data['order_num'] =  'receipt-company#' . ($order_num + 1);
        $data['photos'] = json_encode($data['photos']);
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
