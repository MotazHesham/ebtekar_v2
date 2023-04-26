@php

    global $phone;
    $phone = $getState();
    if ($phone != null) {
        $receipt_social = \App\Models\ReceiptSocial::where(function ($query) {
            $query->where('phone_number', 'like', '%' . $GLOBALS['phone'] . '%')->orWhere('phone_number2', 'like', '%' . $GLOBALS['phone'] . '%');
        })->count();
        $receipt_company = \App\Models\ReceiptCompany::where(function ($query) {
            $query->where('phone_number', 'like', '%' . $GLOBALS['phone'] . '%')->orWhere('phone_number2', 'like', '%' . $GLOBALS['phone'] . '%');
        })
            ->orderBy('created_at', 'desc')
            ->count();

        $receipt_client = \App\Models\ReceiptClient::where('phone_number', 'like', '%' . $phone . '%')->count();
        $customers_orders = \App\Models\Order::where('order_type', 'customer')
            ->where(function ($query) {
                $query->where('phone_number', 'like', '%' . $GLOBALS['phone'] . '%')->orWhere('phone_number2', 'like', '%' . $GLOBALS['phone'] . '%');
            })
            ->orderBy('created_at', 'desc')
            ->count();
        $sellers_orders = \App\Models\Order::where('order_type', 'seller')
            ->where(function ($query) {
                $query->where('phone_number', 'like', '%' . $GLOBALS['phone'] . '%')->orWhere('phone_number2', 'like', '%' . $GLOBALS['phone'] . '%');
            })
            ->orderBy('created_at', 'desc')
            ->count();

        $banned_phones = \App\Models\BannedPhone::where('phone_number', $phone)->first();
    }
@endphp

<div class="relative overflow-x-auto">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    {{ __('cruds.receipt_social.navigation_label')}}
                </th>
                <th scope="col" class="px-6 py-3">
                    {{ __('cruds.receipt_company.navigation_label')}}
                </th>
                <th scope="col" class="px-6 py-3">
                    {{ __('cruds.receipt_client.navigation_label')}}
                </th>
                <th scope="col" class="px-6 py-3">
                    {{ __('cruds.customer.orders')}}
                </th>
                <th scope="col" class="px-6 py-3">
                    {{ __('cruds.seller.orders')}}
                </th>
                <th scope="col" class="px-6 py-3">
                    {{ __('cruds.banned_phone.banned')}}
                </th>
            </tr>
        </thead>
        <tbody>
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <td class="px-6 py-4">
                    {{ $receipt_social ?? 0 }}
                </td>
                <td class="px-6 py-4">
                    {{ $receipt_company ?? 0 }}
                </td>
                <td class="px-6 py-4">
                    {{ $receipt_client ?? 0 }}
                </td>
                <td class="px-6 py-4">
                    {{ $customers_orders ?? 0 }}
                </td>
                <td class="px-6 py-4">
                    {{ $sellers_orders ?? 0 }}
                </td>
                <td>
                    @isset($banned_phones)
                        @if ($banned_phones)
                            <div class="text-red-600">
                                <h5>السبب</h5>
                                <b> {{ $banned_phones->reason }} </b>
                            </div>
                        @endisset
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
</div>
