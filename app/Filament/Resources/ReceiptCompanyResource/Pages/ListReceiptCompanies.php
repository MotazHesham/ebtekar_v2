<?php

namespace App\Filament\Resources\ReceiptCompanyResource\Pages;

use App\Filament\Resources\ReceiptCompanyResource;
use App\Models\Country;
use App\Models\ReceiptCompany;
use App\Models\User;
use Closure;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Session;

class ListReceiptCompanies extends ListRecords
{
    protected static string $resource = ReceiptCompanyResource::class;

    protected function getActions(): array
    {
        return [
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
                            ->route('filament.resources.receipt-companies.create',['phone_number' => $data['phone_number']]);
                }),
        ];
    }

    public function mount(): void
    {
        $countries = Country::all();
        Session::put('countries',$countries);
        $receipt_company = ReceiptCompany::select('id','order_num')->get();
        Session::put('receipt_company',$receipt_company);
        $playlist_users = User::where('user_type','staff')->select('id','name')->get();
        Session::put('playlist_users',$playlist_users);
    }

    protected function getTableFiltersFormColumns(): int
    {
        return 3;
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
