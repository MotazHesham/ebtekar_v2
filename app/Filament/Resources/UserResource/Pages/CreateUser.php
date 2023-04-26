<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_type'] = 'staff';
        $data['password'] = bcrypt($data['password']);
        return $data;
    }

    protected function afterCreate():void
    {
        $this->record->roles()->syncWithPivotValues($this->data['roles'], ['model_type' => 'App\Models\User']);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
