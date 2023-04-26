<?php

namespace App\Filament\Resources\SocialResource\Pages;

use App\Filament\Resources\SocialResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageSocials extends ManageRecords
{
    protected static string $resource = SocialResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

}
