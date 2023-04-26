<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Models\ProductStock;
use Filament\Pages\Actions;
use Illuminate\Support\Str;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['added_by'] = 'admin';
        $data['user_id'] = auth()->user()->id;
        $data['tags'] = implode(',',$data['tags']);
        $data['slug'] = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $data['name'])).'-'.Str::random(5);
        $options = array();
        foreach($data['choice_options'] as $raw){
            $item['attribute'] = $raw['name'];
            $item['values'] = explode(',', implode(',', $raw['tag']));

            array_push($options, $item);
        }
        $data['choice_options'] = !empty($options) ? json_encode($options) : null;
        $data['colors'] = $data['colors'] ? json_encode($data['colors']) : null;
        $data['attributes'] = $data['attributes'] ? json_encode($data['attributes']) : null;
        if($data['colors'] || $data['attributes']){
            $data['variant_product'] = 1;
        }
        $data['photos'] = $data['photos'] ? json_encode($data['photos']) : null;
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
