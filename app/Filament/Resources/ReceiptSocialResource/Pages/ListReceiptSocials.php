<?php

namespace App\Filament\Resources\ReceiptSocialResource\Pages;

use App\Filament\Resources\ReceiptSocialResource;
use App\Filament\Widgets\ReceiptSocialOverview;
use App\Models\Country;
use App\Models\ReceiptProduct;
use App\Models\ReceiptSocial;
use App\Models\User;
use Awcodes\FilamentTableRepeater\Components\TableRepeater;
use Closure;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Filters\Layout;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class ListReceiptSocials extends ListRecords
{
    protected static string $resource = ReceiptSocialResource::class;

    protected function getHeaderWidgets(): array
    {
        if(Session::get('stats')){
            return [
                ReceiptSocialOverview::class,
            ];
        }else{
            return [];
        }
    }
    protected function getActions(): array
    {
        return [
            Actions\Action::make('receipt_product_social')->label(__('cruds.receipt_product.receipt_product_social'))
                    ->url(fn (): string => route('filament.resources.receipt-product-socials.index'))
                    ->color('warning'),
            Actions\Action::make('add_receipt')->label(__('global.add_receipt'))
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
                            ->route('filament.resources.receipt-socials.create',['phone_number' => $data['phone_number']]);
                }),
        ];
    }

    protected function getTableRecordUrlUsing(): Closure
    {
        return fn (): string => '';
    }

    public function mount(): void
    {
        $countries = Country::all();
        Session::put('countries',$countries);
        $receipt_social_products = ReceiptProduct::where('type', 'social')->select('id','name')->get();
        Session::put('receipt_social_products',$receipt_social_products);
        $receipt_socials = ReceiptSocial::select('id','order_num')->get();
        Session::put('receipt_socials',$receipt_socials);
        $playlist_users = User::where('user_type','staff')->select('id','name')->get();
        Session::put('playlist_users',$playlist_users);
        $delivery_users = User::where('user_type','delivery_man')->select('id','name')->get();
        Session::put('delivery_users',$delivery_users);
    }

    protected function getTableFiltersFormColumns(): int
    {
        return 3;
    }

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [9, 18, 40, 90];
    }
}
