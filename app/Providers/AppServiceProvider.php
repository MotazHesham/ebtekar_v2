<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Filament\Navigation\UserMenuItem;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Debugbar::disable();
        // \Debugbar::enable();


        Paginator::defaultView('vendor.pagination.tailwind');

        Filament::serving(function () {
            Filament::registerTheme(
                asset('css/filament.css'),
            );
            Filament::registerScripts([
                'https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js',
            ]);
            Filament::registerStyles([
                'https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.css',
            ]);
        });
        Filament::serving(function(){

            if (request('change_language')) {
                $lang = request('change_language') == 'ar' ? 'en' : 'ar';
            }elseif(session('language')){
                $lang = session('language') == 'ar' ? 'en' : 'ar';
            }else{
                $lang = 'en';
            }
            Filament::registerUserMenuItems([
                UserMenuItem::make()
                    ->label(config('panel.available_languages')[$lang])
                    ->url(url()->current() . '?change_language=' . $lang)
                    ->icon('heroicon-s-cog'),
            ]);
            \Filament\Tables\Columns\IconColumn::macro('toggle', function() {
                $this->action(function($record, $column) {
                    $name = $column->getName();
                    $record->update([
                        $name => !$record->$name
                    ]);
                });
                return $this;
            });
        });
    }
}
