<?php

namespace App\Filament\Resources\ReceiptClientResource\Pages;

use App\Filament\Resources\ReceiptClientResource;
use App\Models\Country;
use App\Models\ReceiptCompany;
use App\Models\ReceiptProduct;
use Closure;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Session;

class ListReceiptClients extends ListRecords
{
    protected static string $resource = ReceiptClientResource::class;

    protected function getActions(): array
    {
        return [
            Actions\Action::make('receipt_product_client')->label(__('cruds.receipt_product.receipt_product_client'))
                    ->url(fn (): string => route('filament.resources.receipt-product-clients.index'))
                    ->color('warning'),
            Actions\Action::make(__('global.add_receipt'))
                ->form([
                    TextInput::make('phone_number')
                                ->label(__('global.phone_number'))
                                ->reactive()
                                ->afterStateUpdated(function (callable $set,callable $get) {
                                    $set('search_by_phone', $get('phone_number'));
                                }),
                    ViewField::make('search_by_phone')
                                ->view('filament.forms.components.search_by_phone')

                ])
                ->action(function (array $data) {
                    return redirect()
                            ->route('filament.resources.receipt-clients.create',['phone_number' => $data['phone_number']]);
                }),
        ];
    }

    public function mount(): void
    {
        $countries = Country::all();
        Session::put('countries',$countries);
        $receipt_client_products = ReceiptProduct::where('type', 'client')->select('id','name')->get();
        Session::put('receipt_client_products',$receipt_client_products);
        $receipt_company = ReceiptCompany::select('id','order_num')->get();
        Session::put('receipt_company',$receipt_company);
    }

    protected function getTableRecordUrlUsing(): Closure
    {
        return fn (): string => '';
    }

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [9, 18, 40, 90];
    }
}
