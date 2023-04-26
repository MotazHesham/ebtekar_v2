<div class="grid grid-cols-2 gap-4">
    <div
        class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow p-8
    dark:bg-gray-800 dark:border-gray-700">

        <div class="col-md-3" style="margin-bottom:15px ">
            <div class="filteration-box text-center">
                @if ($record->order_type == 'seller')
                    <h3>{{ __('Seller info') }}</h3>

                    <div class="my-3">
                        <span
                            class="bg-gray-100 text-gray-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">{{ trans('cruds.seller.fields.seller_code') }}</span>{{ $record->user->seller->seller_code ?? '' }}
                    </div>
                    <div class="my-3">
                        <span
                            class="bg-gray-100 text-gray-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">{{ trans('cruds.user.fields.email') }}</span>
                        {{ $record->user->email ?? '' }}
                    </div>
                    <div class="my-3">
                        <span
                            class="bg-gray-100 text-gray-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">{{ trans('cruds.seller.fields.social_name') }}</span>
                        {{ $record->user->seller->social_name ?? '' }}
                    </div>
                    <div class="my-3">
                        <span
                            class="bg-gray-100 text-gray-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">{{ trans('cruds.seller.fields.social_link') }}</span>
                        <a href="{{ $record->user->seller->social_link ?? '' }}"
                            target="_blanc">{{ $record->user->seller->social_link ?? '' }}</a>
                    </div>
                    <div class="my-3">
                        <span
                            class="bg-gray-100 text-gray-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">{{ trans('cruds.order.fields.commission') }}</span>
                        {{ currency_formatting($record->commission + $record->extra_commission) }}
                    </div>
                    <hr>
                @endif

                <h3>{{ __('Client info') }}</h3>
                <div class="my-3">
                    <span
                        class="bg-gray-100 text-gray-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">{{ trans('cruds.order.fields.client_name') }}</span>
                    {{ $record->client_name }}
                </div>
                <div class="my-3">
                    <span
                        class="bg-gray-100 text-gray-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">{{ trans('cruds.order.fields.phone_number') }}</span>
                    {{ $record->phone_number }} ,
                    {{ $record->phone_number2 }}
                </div>
                <div class="my-3">
                    <span
                        class="bg-gray-100 text-gray-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">{{ trans('cruds.order.fields.shipping_address') }}</span>{{ $record->shipping_country_name }}
                    ,
                    {{ $record->shipping_address }}
                </div>
                @if ($record->order_type == 'customer')
                    <div class="my-3">
                        <span
                            class="bg-gray-100 text-gray-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">{{ trans('cruds.user.fields.email') }}</span>
                        {{ $record->user->email ?? '' }}
                    </div>
                @endif
                <div class="my-3">
                    <span
                        class="bg-gray-100 text-gray-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">{{ trans('cruds.order.fields.order_num') }}</span>
                    {{ $record->order_num }}
                </div>
                <div class="my-3">
                    <span
                        class="bg-gray-100 text-gray-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">{{ trans('cruds.order.fields.delivery_status') }}</span>
                    {{ trans('global.delivery_status.' . $record->delivery_status) }}
                </div>
                <div class="my-3">
                    <span
                        class="bg-gray-100 text-gray-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">{{ trans('cruds.order.fields.created_at') }}</span>
                    {{ $record->created_at }}
                </div>
                <div class="my-3">
                    <span
                        class="bg-gray-100 text-gray-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">{{ trans('cruds.order.fields.payment_type') }}</span>
                    {{ trans('global.payment_type.' . $record->payment_type) }}
                </div>
                <div class="my-3">
                    <span
                        class="bg-gray-100 text-gray-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">{{ trans('cruds.order.fields.payment_status') }}
                    </span>
                    {{ trans('global.payment_status.' . $record->payment_status) }}
                </div>
                @if ($record->discount_code != null)
                    <div class="my-3">
                        <span
                            class="bg-gray-100 text-gray-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">
                            {{ trans('cruds.order.fields.discount_code') }} </span>
                        {{ $record->discount_code }}
                    </div>
                @endif

            </div>
        </div>
    </div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        {{ trans('cruds.order.fields.order_details.photo') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ trans('cruds.order.fields.order_details.product') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ trans('cruds.order.fields.order_details.quantity') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ trans('cruds.order.fields.order_details.price') }}
                    </th>
                    <th scope="col" class="px-6 py-3">

                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($record->orderDetails as $key => $orderDetail)
                    <x-filament::modal id="view-details-{{ $key }}">
                        <x-slot name="header">
                            Customer Choices
                        </x-slot>


                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <h4>Attached images</h4>
                                <hr>
                                @if (is_array(json_decode($orderDetail->photos)) && count(json_decode($orderDetail->photos)) > 0)
                                    <div>
                                        @foreach (json_decode($orderDetail->photos) as $key_2 => $photo)
                                            <div style="display: inline;position: relative;">
                                                <img style="padding:3px" src="{{ asset($photo) }}" alt=""
                                                    height="140" width="140"
                                                    title="{{ json_decode($orderDetail->photos_note)[$key_2] ?? '' }}">
                                                <div
                                                    style=" display: inline; position: absolute; left: 11px; top: -22px;">
                                                    <div
                                                        style=" background-color: #00000069; text-align: center; color: white; width: 120px;">
                                                        {{ json_decode($orderDetail->photos_note)[$key_2] ?? '' }}
                                                    </div>
                                                </div>
                                                <div class="text-center"
                                                    style="display: inline;position: absolute; left: 3px; top: -58px;">
                                                    <a href="{{ asset($photo) }}"
                                                        download="{{ $record->order_num }}_{{ $key_2 }}_{{ json_decode($orderDetail->photos_note)[$key_2] ?? '' }}"
                                                        class="btn btn-success btn-sm"><i
                                                            class="fa fa-download"></i></a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p style="color: brown">There is no attached images for this product ....</p>
                                @endif
                            </div>





                            <div>
                                <!-- Product description -->
                                <div class="product-description-wrapper">
                                    <!-- Product title -->
                                    <h3 class="product-title text-center">
                                        {{ __($orderDetail->product->name) }}
                                    </h3>

                                    @if ($orderDetail->variation != null)
                                        <div>
                                            <span
                                                class="bg-gray-100 text-gray-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">{{ __('Variation') }}</span>
                                            : <b style="color: #2980B9;font-size: 23px;"> (
                                                {{ $orderDetail->variation }} )</b>
                                        </div>
                                    @endif

                                    <div>
                                        <span
                                            class="bg-gray-100 text-gray-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">{{ __('Price') }}</span>
                                        : <b
                                            style="color: #2980B9;font-size: 23px;">{{ currency_formatting($orderDetail->price) }}</b>
                                    </div>



                                    <div>
                                        <span
                                            class="bg-gray-100 text-gray-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">{{ __('Quantity') }}</span>
                                        : <b style="color: #2980B9;font-size: 23px;">{{ $orderDetail->quantity }}</b>
                                    </div>
                                    <hr>

                                    <div>
                                        <span
                                            class="bg-gray-100 text-gray-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">{{ __('Description') }}</span>
                                        : <b style="color: #2980B9;font-size: 23px;"><?php echo $orderDetail->description; ?> </b>
                                    </div>

                                    @if ($orderDetail->link != null)
                                        <div>
                                            <span
                                                class="bg-gray-100 text-gray-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">{{ __('Link') }}</span>
                                            : <b style="color: #2980B9;font-size: 23px;"><a
                                                    href="{{ $orderDetail->link }}">{{ $orderDetail->link }}</a></b>
                                        </div>
                                    @endif

                                    <hr>

                                    @if ($orderDetail->pdf != null)
                                        <div>
                                            <span
                                                class="bg-gray-100 text-gray-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">{{ __('PDf') }}</span>
                                            : <b style="color: #2980B9;font-size: 23px;"><a
                                                    href="{{ asset($orderDetail->pdf) }}"
                                                    class="btn btn-outline-success"> {{ __('Download') }}</a></b>
                                        </div>
                                    @endif

                                    <div>
                                        <span
                                            class="bg-gray-100 text-gray-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">{{ __('File Sent To Email') }}</span>
                                        : <b style="color: #2980B9;font-size: 23px;">
                                            @if ($orderDetail->email_sent == 1)
                                                Yes
                                            @endif
                                            @if ($orderDetail->email_sent == 0)
                                                No
                                            @endif
                                        </b>
                                    </div>


                                </div>
                    </x-filament::modal>

                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4">

                            @if ($orderDetail->product != null)
                                @if (json_decode($orderDetail->product->photos) != null && json_decode($orderDetail->product->photos)[0])
                                    <a href="#" target="_blank">
                                        <img src="{{ asset('storage/' . json_decode($orderDetail->product->photos)[0]) }}"
                                            width="80" height="80" alt="">
                                    </a>
                                @endif
                            @else
                                <strong>{{ __('N/A') }}</strong>
                            @endif
                        </td>
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">

                            @if ($orderDetail->product != null)
                                <strong><a href="#"
                                        target="_blank">{{ $orderDetail->product->name }}</a></strong>
                                <small>
                                    @if ($orderDetail->variation != null)
                                        ({{ $orderDetail->variation }})
                                    @endif
                                </small>
                            @else
                                <strong>{{ __('Product Unavailable') }}</strong>
                            @endif
                        </th>
                        <td class="px-6 py-4">
                            {{ $orderDetail->quantity }}
                        </td>
                        <td class="px-6 py-4">
                            {{ currency_formatting($orderDetail->price) }}
                        </td>
                        <td class="px-6 py-4">
                            <button type="button"
                                x-on:click="$dispatch('open-modal',{id:'view-details-{{ $key }}'})"
                                class="font-medium text-blue-600 hover:underline">More</button>
                            <a href="#" class="font-medium text-danger-600 hover:underline">Delete</a>
                        </td>
                    </tr>
                @endforeach
            <tfoot>
                <tr class="font-semibold text-gray-900">
                    <td>
                        <div>
                            <span>Sub Total:</span>
                            <span>+{{ currency_formatting($record->total_cost) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <div class="">Extra_Comm:</div>
                            <div class="order-last">+{{ currency_formatting($record->extra_commission) }}</div>
                        </div>
                        <div class="flex justify-between">
                            <div class="">Deposit:</div>
                            <div class="order-last">-{{ currency_formatting($record->deposit_amount) }}</div>
                        </div>
                        <div class="flex justify-between">
                            <div class="">Shipping:</div>
                            <div class="order-last">+{{ currency_formatting($record->shipping_country_cost) }}
                            </div>
                        </div>
                        @if ($record->discount_code)
                            <div class="flex justify-between">
                                <div class="">Discount({{ $record->discount_code }}):</div>
                                <div class="order-last">-{{ currency_formatting($record->calc_discount()) }}</div>
                            </div>
                        @endif
                        <div class="flex justify-between">
                            <div class="">Total:</div>
                            <div class="order-last">={{ currency_formatting($record->calc_total()) }}</div>
                        </div>
                    </td>
                </tr>
            </tfoot>
            </tbody>
        </table>
    </div>
</div>
