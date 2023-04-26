<x-filament::page>

    <button  data-modal-target="qrModal" data-modal-toggle="qrModal"
            class="text-gray-900 bg-gradient-to-r from-lime-200 via-lime-400 to-lime-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-lime-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
        Qr Scanner
    </button>

    <div id="qrModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
        <div class="relative w-full h-full max-w-2xl md:h-auto">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Qr Scanner
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-hide="qrModal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                @include('playlist.qr_code_scanner',['type' => $type])
                <!-- Modal footer -->
                <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b">
                    <button data-modal-hide="qrModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:hover:bg-gray-600 dark:hover:text-white">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="grid gap-4 lg:grid-cols-4  md:grid-cols-2">
        @if ($type != 'design')
            <a href="{{ url()->current() . '?type=design' }}"
                class=" text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 ">
                {{ __('cruds.playlist.design') }}
            </a>
        @else
            <a href="{{ url()->current() . '?type=design' }}"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 focus:outline-none">
                {{ __('cruds.playlist.design') }}
            </a>
        @endif

        @if ($type != 'manufacturing')
            <a href="{{ url()->current() . '?type=manufacturing' }}"
                class="text-yellow-400 hover:text-white border border-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                {{ __('cruds.playlist.manufacturing') }}
            </a>
        @else
            <a href="{{ url()->current() . '?type=manufacturing' }}"
                class="focus:outline-none text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2">
                {{ __('cruds.playlist.manufacturing') }}
            </a>
        @endif

        @if ($type != 'prepare')
            <a href="{{ url()->current() . '?type=prepare' }}"
                class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                {{ __('cruds.playlist.prepare') }}
            </a>
        @else
            <a href="{{ url()->current() . '?type=prepare' }}"
                class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2">
                {{ __('cruds.playlist.prepare') }}
            </a>
        @endif

        @if ($type != 'send_to_delivery')
            <a href="{{ url()->current() . '?type=send_to_delivery' }}"
                class="text-purple-700 hover:text-white border border-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                {{ __('cruds.playlist.send_to_delivery') }}
            </a>
        @else
            <a href="{{ url()->current() . '?type=send_to_delivery' }}"
                class="focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2">
                {{ __('cruds.playlist.send_to_delivery') }}
            </a>
        @endif
    </div>
    <div class="w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
        <form method="GET">
            <input type="hidden" name="type" value="{{ $type }}" id="">
            <div class="grid gap-4 lg:grid-cols-4  md:grid-cols-2 ">
                <div class="mb-6">
                    <select id="user_id" name="user_id"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                        dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="">Choose User</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}"
                                @isset($user_id) @if ($user_id == $user->id) selected @endif @endisset>
                                {{ $user->email }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-6">
                    <input type="text" id="order_num" name="order_num" value="{{ $order_num }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                        dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="{{ __('cruds.playlist.order_num') }}">
                </div>
                <div class="mb-6">
                    <input type="text" id="description" name="description" value="{{ $description }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                        dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="{{ __('cruds.playlist.description') }}">
                </div>
                <div class="mb-6">
                    <select id="view" name="view"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                        dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="by_date" @if ($view == 'by_date') selected @endif>By Date</option>
                        <option value="all" @if ($view == 'all') selected @endif>all</option>
                    </select>
                </div>
            </div>
            <button type="submit"
                class="w-full focus:outline-none text-white bg-success-600 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2">
                {{ __('cruds.playlist.search') }}
            </button>
        </form>
    </div>
    <div id="accordion-collapse" data-accordion="collapse">

        @if ($view == 'by_date')

            <div class="mb-2">
                {{ $dates->appends(request()->input())->links() }}
            </div>

            <div class="grid gap-4 lg:grid-cols-3  md:grid-cols-2 mb-4">
                @foreach ($dates as $key0 => $items)
                    <button type="button"
                        class="relative text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2"
                        data-toggle="collapse" data-accordion-target="#accordion-collapse-body-{{ $key0 }}"
                        aria-expanded="true" aria-controls="accordion-collapse-body-{{ $key0 }}"
                        style="color:white">
                        {{ date('F j,Y', strtotime($key0)) }}
                        <div
                            class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full -top-2 -right-2">
                            {{ count($items) }}</div>

                    </button>
                @endforeach
            </div>

        @endif

        @if ($view == 'by_date')
            @foreach ($dates as $key0 => $items)
                <div id="accordion-collapse-body-{{ $key0 }}" class="hidden"
                    aria-labelledby="accordion-collapse-heading-{{ $key0 }}">
                    @include('partial.playlist')
                </div>
            @endforeach
        @else
            @include('partial.playlist')
        @endif

        @if ($view != 'by_date')
            <div class="mt-3">
                {{ $items->appends(request()->input())->links() }}
            </div>
        @endif
    </div>

</x-filament::page>
