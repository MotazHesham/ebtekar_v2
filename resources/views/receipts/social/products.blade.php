<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    {{ __('cruds.receipt_social.products.product_name') }}
                </th>
                <th scope="col" class="px-6 py-3">
                    {{ __('cruds.receipt_social.products.description') }}
                </th>
                <th scope="col" class="px-6 py-3">
                    {{ __('cruds.receipt_social.products.commission') }}
                </th>
                <th scope="col" class="px-6 py-3">
                    {{ __('cruds.receipt_social.products.price') }}
                </th>
                <th scope="col" class="px-6 py-3">
                    {{ __('cruds.receipt_social.products.images') }}
                </th>
                <th scope="col" class="px-6 py-3">
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($getRecord()->receipt_social_products as $product)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="px-6 py-4">
                        {{ $product->title }}
                    </td>
                    <td class="px-6 py-4">
                        <?php echo $product->description; ?>
                    </td>
                    <td class="px-6 py-4 w-48">
                        <p class="mb-1">
                            <span
                                class="bg-gray-100 text-gray-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">
                                {{ currency_formatting($product->commission) }}
                            </span>
                        </p>
                        <p class="mb-1">
                            <span
                                class="bg-yellow-100 text-yellow-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">
                                {{ __('cruds.receipt_social.products.extra') }}
                                {{ currency_formatting($product->extra_commission) }}
                            </span>

                        </p>
                    </td>
                    <td class="px-6 py-4 w-48">
                        <p class="mb-1">
                            <span
                                class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">
                                {{ __('cruds.receipt_social.products.price') }}
                                {{ currency_formatting($product->cost) }}
                            </span>
                        </p>
                        <p class="mb-1">
                            <span
                                class="bg-indigo-100 text-indigo-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-indigo-900 dark:text-indigo-300">
                                {{ __('cruds.receipt_social.products.quantity') }}
                                {{ $product->quantity }}
                            </span>
                        </p>
                        <p class="mb-1">
                            <span
                                class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                                {{ __('cruds.receipt_social.products.total') }}
                                {{ currency_formatting($product->total()) }}
                            </span>
                        </p>
                    </td>
                    <td class="px-6 py-4">
                        @if ($product->photos)
                            @forelse (json_decode($product->photos) as $photo)
                                @if($photo->photo)
                                    <a href="{{ asset('storage/' . $photo->photo) }}" target="_blanc">
                                        <img src="{{ asset('storage/' . $photo->photo) }}" width="70" height="70"
                                            alt="">
                                        <span>{{ $photo->note }}</span>
                                    </a>
                                @endif
                            @empty
                                No Attaced Images...
                            @endforelse
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('admin.receipt_social.delete_product',$product->id) }}"
                            class="font-medium text-danger-600 hover:underline">{{ trans('global.delete') }}</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
