<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['tags'] = explode(',',$data['tags']);
        $data['colors'] = json_decode($data['colors']);
        $data['attributes'] = json_decode($data['attributes']);
        $data['photos'] = json_decode($data['photos']);
        $array = array();
        if(json_decode($data['choice_options'])){
            foreach(json_decode($data['choice_options']) as $raw){
                $item['name'] = $raw->attribute;
                $item['tag'] = explode(',',implode(',',$raw->values));
                array_push($array,$item);
            }
        }
        $data['choice_options'] = $array;
        return $data;
    }


    protected function mutateFormDataBeforeSave(array $data): array
    {

        $data['tags'] = implode(',',$data['tags']);
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
        $data['photos'] = json_encode($data['photos']);
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
