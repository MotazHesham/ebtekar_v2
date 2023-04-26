<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    {{ __('cruds.receipt_price_view.products.product_name') }}
                </th>
                <th scope="col" class="px-6 py-3">
                    {{ __('cruds.receipt_price_view.products.cost') }}
                </th>
                <th scope="col" class="px-6 py-3">
                    {{ __('cruds.receipt_price_view.products.quantity') }}
                </th>
                <th scope="col" class="px-6 py-3">
                    {{ __('cruds.receipt_price_view.products.total') }}
                </th>
                <th scope="col" class="px-6 py-3">
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($getRecord()->receipt_price_view_products as $key => $raw)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="px-6 py-4">
                        {{ $raw->description }}
                    </td>
                    <td class="px-6 py-4">
                        {{ currency_formatting($raw->price) }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $raw->quantity }}
                    </td>
                    <td class="px-6 py-4">
                        {{ currency_formatting($raw->total_cost) }}
                    </td>
                    <td class="px-6 py-4">
                        <a href="#"
                            class="font-medium text-primary-600 hover:underline">Edit</a>
                        <a href="#"
                            class="font-medium text-danger-600 hover:underline">Delete</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
