<x-dynamic-component
    :component="$getFieldWrapperView()"
    :id="$getId()"
    :label="$getLabel()"
    :label-sr-only="$isLabelHidden()"
    :helper-text="$getHelperText()"
    :hint="$getHint()"
    :hint-action="$getHintAction()"
    :hint-color="$getHintColor()"
    :hint-icon="$getHintIcon()"
    :required="$isRequired()"
    :state-path="$getStatePath()"
>
    <div x-data="{ state: $wire.entangle('{{ $getStatePath() }}').defer }">
        <select class="form-control demo-select2" name="shipping_country" id="shipping_country" >
            <optgroup label="{{__('Districts')}}">
                @foreach(\App\Models\Country::where('type','districts')->get() as $district)
                    <option value={{$district->id}} @isset($receipt) @if($receipt->shipping_country_id  == $district->id) selected @endif @endisset>{{$district->name}} -   EGP{{($district->cost)}}</option>
                @endforeach
            </optgroup>
            <optgroup label="{{__('Countries')}}">
                @foreach(\App\Models\Country::where('type','countries')->get() as $country)
                    <option value={{$country->id}} @isset($receipt) @if($receipt->shipping_country_id == $country->id) selected @endif @endisset>{{$country->name}} -   EGP{{($country->cost)}}</option>
                @endforeach
            </optgroup>
            <optgroup label="{{__('Metro')}}">
                @foreach(\App\Models\Country::where('type','metro')->get() as $raw)
                    <option value={{$raw->id}} @isset($receipt) @if($receipt->shipping_country_id == $raw->id) selected @endif @endisset>{{$raw->name}} -   EGP{{($raw->cost)}}</option>
                @endforeach
            </optgroup>
        </select>
    </div>
</x-dynamic-component>
