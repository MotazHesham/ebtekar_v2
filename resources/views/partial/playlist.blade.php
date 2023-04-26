<div class="grid gap-4 lg:grid-cols-3 md:grid-cols-2">
    @php

        $title = '';
        $title_send = '';
        $back_type = '';
        $next_type = '';
        if ($type == 'design') {
            $title = 'الديزانر';
            $title_send = 'أرسال لقائمة التصنيع';
            $next_type = 'manufacturing';
            $title_back = 'أرجاع للشركة';
            $back_type = 'pending';
        } elseif ($type == 'manufacturing') {
            $title = 'التصنيع';
            $title_send = 'أرسال لقائمة التجهيز';
            $next_type = 'prepare';
            $title_back = 'أرجاع لقائمة الديزانر';
            $back_type = 'design';
        } elseif ($type == 'prepare') {
            $title = 'التجهيز';
            $title_send = 'أرسال للتجهيز للشحن';
            $next_type = 'send_to_delivery';
            $title_back = 'أرجاع لقائمة التصنيع';
            $back_type = 'manufacturing';
        } elseif ($type == 'send_to_delivery') {
            $title = 'التجهيز';
            $title_send = 'أرسال للشحن';
            $next_type = 'finish';
            $title_back = 'أرجاع لقائمة التجهيز';
            $back_type = 'prepare';
        }
    @endphp
    @foreach ($items as $key => $item)
        @php
            if ($type == 'design') {
                $authenticated = $item['designer_id'];
            } elseif ($type == 'manufacturing') {
                $authenticated = $item['manifacturer_id'];
            } elseif ($type == 'prepare') {
                $authenticated = $item['preparer_id'];
            } elseif ($type == 'send_to_delivery') {
                $authenticated = $item['send_to_delivery_id'];
            }
        @endphp

        <div class="relative w-full bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">


            <ul class="flex flex-wrap text-sm font-medium text-center text-gray-500 border-b border-gray-200 rounded-t-lg bg-gray-50 dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800"
                id="defaultTab" data-tabs-toggle="#defaultTabContent" role="tablist">
                <li class="mr-2">
                    <button id="about-tab-{{ $item['id'] }}" data-tabs-target="#about-{{ $item['id'] }}" type="button"
                        role="tab" aria-controls="about-{{ $item['id'] }}" aria-selected="true"
                        class="inline-block p-4 text-blue-600 rounded-tl-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-blue-500">
                        {{ __('cruds.playlist.info')}}
                    </button>
                </li>
                <li class="mr-2">
                    <button id="description-tab-{{ $item['id'] }}" data-tabs-target="#description-{{ $item['id'] }}"
                        type="button" role="tab" aria-controls="description-{{ $item['id'] }}"
                        aria-selected="false"
                        class="inline-block p-4 hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-gray-300">
                        {{ __('cruds.playlist.description')}}
                    </button>
                </li>
                <li class="mr-2">
                    <button id="note-tab-{{ $item['id'] }}" data-tabs-target="#note-{{ $item['id'] }}"
                        type="button" role="tab" aria-controls="note-{{ $item['id'] }}" aria-selected="false"
                        class="inline-block p-4 hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-gray-300">
                        {{ __('cruds.playlist.note')}}
                    </button>
                </li>
            </ul>
            <div id="defaultTabContent">
                <div class="text-center hidden p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800"
                    id="about-{{ $item['id'] }}" role="tabpanel" aria-labelledby="about-tab-{{ $item['id'] }}">
                    <h2 class="mb-3 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                        @if($item['quickly'] == 1)
                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">
                                {{__('cruds.playlist.quickly')}}
                            </span>
                        @endif
                        @if($item['shipping_country_id'] == 20)
                            <span class="bg-purple-100 text-purple-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-purple-900 dark:text-purple-300">
                                في الشركة
                            </span>
                        @endif
                        @if($item['printing_times'] == 0)
                            <span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                                new
                            </span>
                        @endif
                        <br>
                        {{ $item['order_num'] }}
                    </h2>
                    <p class="mb-3 text-gray-500">
                    <div class="flex justify-between  mb-6">
                        <div>
                            <span class="badge badge-default">{{ __('cruds.playlist.created_at') }}</span><br>

                            <span class="bg-gray-100 text-gray-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">
                                {{ $item['created_at'] }}
                            </span>

                        </div>
                        <div>
                            <span class="badge badge-default"> {{ __('cruds.playlist.send_to_playlist_date') }}</span><br>
                            <span class="bg-gray-100 text-gray-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">
                                {{ $item['send_to_playlist_date'] }}
                            </span>
                        </div>
                    </div>
                    </p>
                    <div class="flex justify-between ">
                        @if (auth()->user()->is_admin() || $authenticated == auth()->user()->id)
                            @if ($type == 'design')
                                {{-- <button type="button"
                                    class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                                    {{ __('global.print') }}
                                </button> --}}
                            @endif
                            <a href="{{route('admin.playlist.update_playlist_status',['order_num' => $item['order_num'], 'status' => $next_type, 'condition' => 'send'])}}"
                                class="text-purple-700 hover:text-white border border-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                                {{ $title_send }}
                            </a>
                            <a href="{{route('admin.playlist.update_playlist_status',['order_num' => $item['order_num'], 'status' => $back_type, 'condition' => 'back'])}}"
                                class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                                {{ $title_back }}
                            </a>
                        @endif
                    </div>
                </div>
                <div class="hidden p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800"
                    id="description-{{ $item['id'] }}" role="tabpanel"
                    aria-labelledby="description-tab-{{ $item['id'] }}">
                    <?php echo $item['description']; ?>

                    @if ($item['model_type'] == 'order')
                        @php
                            $order = \App\Models\Order::with('orderDetails')
                                ->where('order_num', $item['order_num'])
                                ->first();
                        @endphp
                        @foreach ($order->orderDetails as $orderDetail)
                            @if ($orderDetail->product != null)
                                @php
                                    if (json_decode($orderDetail->product->photos) != null && json_decode($orderDetail->product->photos)[0]) {
                                        $product_photo = json_decode($orderDetail->product->photos)[0] ?? '';
                                    } else {
                                        $product_photo = '';
                                    }
                                @endphp
                                <div>
                                    <a href="{{ asset($product_photo) }}" target="_blank"><img width="150"
                                            height="150" src={{ asset($product_photo) }} /></a>
                                    @if (is_array(json_decode($orderDetail->photos)) && count(json_decode($orderDetail->photos)) > 0)
                                        <div>
                                            @foreach (json_decode($orderDetail->photos) as $key => $photo)
                                                <div style="display: inline;position: relative;">
                                                    <a href="{{ asset($photo) }}" target="_blanc">
                                                        <img style="padding:3px" src="{{ asset($photo) }}"
                                                            alt="" height="140" width="140"
                                                            title="{{ json_decode($orderDetail->photos_note)[$key] ?? '' }}">
                                                    </a>
                                                    <div
                                                        style=" display: inline; position: absolute; left: 11px; top: -22px;">
                                                        <div
                                                            style=" background-color: #00000069; text-align: center; color: white; width: 120px;">
                                                            {{ json_decode($orderDetail->photos_note)[$key] ?? '' }}
                                                        </div>
                                                    </div>
                                                    <div class="text-center"
                                                        style="display: inline;position: absolute; left: 3px; top: -58px;">
                                                        <a href="{{ asset($photo) }}"
                                                            download="{{ $order->code }}_{{ $key }}_{{ json_decode($orderDetail->photos_note)[$key] ?? '' }}"
                                                            class="btn btn-success btn-sm"><i
                                                                class="fa fa-download"></i></a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @else
                                <strong>{{ __('N/A') }}</strong>
                            @endif
                            <hr>
                        @endforeach
                    @elseif($item['model_type'] == 'social')
                        @php
                            $receipt = \App\Models\ReceiptSocial::with('receipt_social_products')
                                ->where('order_num', $item['order_num'])
                                ->first();
                        @endphp
                        @foreach ($receipt->receipt_social_products as $receipt_product)
                            @if ($receipt_product->product != null)
                                <h3>{{ $receipt_product->product->name }}</h3>
                                <div><?php echo $receipt_product->description; ?></div>
                                <div>
                                    @if (is_array(json_decode($receipt_product->product->photos)) &&
                                            count(json_decode($receipt_product->product->photos)) > 0)
                                        @foreach (json_decode($receipt_product->product->photos) as $key => $photo0)
                                            <a href="{{ asset($photo0) }}" target="_blank"><img width="150"
                                                    height="150" src={{ asset($photo0) }} /></a>
                                        @endforeach
                                    @endif
                                    @if (is_array(json_decode($receipt_product->photos)) && count(json_decode($receipt_product->photos)) > 0)
                                        <div>
                                            @foreach (json_decode($receipt_product->photos) as $key => $photo)
                                                <div style="display: inline;position: relative;">
                                                    <a href="{{ asset($photo) }}" target="_blanc">
                                                        <img style="padding:3px" src="{{ asset($photo) }}"
                                                            alt="" height="140" width="140"
                                                            title="{{ json_decode($receipt_product->photos_note)[$key] ?? '' }}">
                                                    </a>
                                                    <div
                                                        style=" display: inline; position: absolute; left: 11px; top: -22px;">
                                                        <div
                                                            style=" background-color: #00000069; text-align: center; color: white; width: 120px;">
                                                            {{ json_decode($receipt_product->photos_note)[$key] ?? '' }}
                                                        </div>
                                                    </div>
                                                    <div class="text-center"
                                                        style="display: inline;position: absolute; left: 3px; top: -58px;">
                                                        <a href="{{ asset($photo) }}"
                                                            download="{{ $receipt->order_num }}_{{ $key }}_{{ json_decode($receipt_product->photos_note)[$key] ?? '' }}"
                                                            class="btn btn-success btn-sm"><i
                                                                class="fa fa-download"></i></a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                    <br>
                                    @if ($receipt_product->pdf)
                                        <a href="{{ asset($receipt_product->pdf) }}" target="_blanc"
                                            class="btn btn-info">show pdf</a>
                                    @endif
                                </div>
                            @else
                                <strong>{{ __('N/A') }}</strong>
                            @endif
                            <hr>
                        @endforeach
                    @else
                        @if (is_array(json_decode($item['photos'])) && count(json_decode($item['photos'])) > 0)
                            @foreach (json_decode($item['photos']) as $key => $photo)
                                <a href="{{ asset($photo) }}">
                                    <img src="{{ asset($photo) }}" alt="" class="img-responsive"
                                        width="200" height="200">
                                </a> <br>
                            @endforeach
                        @endif
                    @endif
                </div>
                <div class="hidden p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="note-{{ $item['id'] }}"
                    role="tabpanel" aria-labelledby="note-tab-{{ $item['id'] }}">
                    <?php echo $item['note']; ?>
                </div>
            </div>
        </div>
    @endforeach
</div>
