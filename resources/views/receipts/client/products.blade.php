
<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    {{ __('cruds.receipt_client.products.product_name') }}
                </th>
                <th scope="col" class="px-6 py-3">
                    {{ __('cruds.receipt_client.products.cost') }}
                </th>
                <th scope="col" class="px-6 py-3">
                    {{ __('cruds.receipt_client.products.quantity') }}
                </th>
                <th scope="col" class="px-6 py-3">
                    {{ __('cruds.receipt_client.products.total') }}
                </th>
                <th scope="col" class="px-6 py-3">
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($getRecord()->receipt_client_products as $product)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="px-6 py-4">
                        {{ $product->description }}
                    </td>
                    <td class="px-6 py-4">
                        {{ currency_formatting($product ->cost) }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $product->quantity }}
                    </td>
                    <td class="px-6 py-4">
                        {{ currency_formatting($product ->total) }}
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{route('admin.receipt_client.delete_product',$product->id)}}"
                            class="font-medium text-danger-600 hover:underline">{{ trans('global.delete') }}</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
