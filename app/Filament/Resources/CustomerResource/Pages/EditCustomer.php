<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Resources\CustomerResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCustomer extends EditRecord
{
    protected static string $resource = CustomerResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function mutateFormDataBeforeSave(array $data): array
    {

        $user = $this->record->user;
        if($user){
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->address = $data['address'];
            $user->phone_number = $data['phone_number'];
            $user->password = $data['password'] ? bcrypt($data['password']) : $user->password;
            $user->save();
        }
        return $data;
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $user = $this->record->user;
        if($user){
            $data['name'] = $user->name;
            $data['email'] = $user->email;
            $data['address'] = $user->address;
            $data['phone_number'] = $user->phone_number;
        }
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
