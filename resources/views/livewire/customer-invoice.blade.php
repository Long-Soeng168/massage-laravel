<div class="bg-white dark:bg-gray-700 dark:text-gray-50">
    @if (session('success'))
        <div class="fixed top-[5rem] right-4 z-[999999] " wire:key="{{ rand() }}" x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 7000)">
            <div x-show="show" id="alert-2"
                class="flex items-center p-4 mb-4 text-green-800 border border-green-500 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
                role="alert">
                <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <div class="ml-2">
                    {{ session('success') }}
                </div>
                <button type="button" @click="show = false"
                    class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700"
                    data-dismiss-target="#alert-2" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
        </div>
    @endif
    <!-- Profile Details Section -->
    <div class="w-full mx-auto mt-4 rounded-lg ">
        <div class="flex">


            <div class="px-4 mb-4 text-gray-600 dark:text-gray-50">
                <div class="flex flex-col items-start justify-start ">
                    <div class="flex items-start justify-start gap-2 ">
                        <strong>{{ __('Name : ') }}</strong>
                        <p class="text-start ">
                            {{ $order->name ?? 'N/A' }}
                        </p>
                    </div>
                    <div class="flex items-start justify-start gap-2 ">
                        <strong>{{ __('Credit : ') }}</strong>
                        <p class="text-red-500 text-start">
                            $ {{ $order->credit ?? '0' }}
                        </p>
                    </div>
                    <div class="flex items-start justify-start gap-2 ">
                        <strong>{{ __('Phone : ') }}</strong>
                        <p class="text-start ">
                            {{ $order->phone ?? 'N/A' }}
                        </p>
                    </div>
                    <div class="flex items-start justify-start gap-2 ">
                        <strong>{{ __('Address : ') }}</strong>
                        <p class="text-start ">
                            {{ $order->address ?? 'N/A' }}
                        </p>
                    </div>
                    <div class="flex items-start justify-start gap-2 capitalize">
                        <strong>{{ __('Gender : ') }}</strong>
                        <p class="text-start ">
                            {{ $order->gender ?? 'N/A' }}
                        </p>
                    </div>
                    {{-- <div class="flex items-start justify-start gap-2 ">
                        <strong>{{ __('Created By : ') }}</strong>
                        <p class="text-start ">
                            {{ $order->created_by?->name ?? 'N/A' }}
                        </p>
                    </div> --}}
                    <div class="flex items-start justify-start gap-2 ">
                        <strong>{{ __('Updated By : ') }}</strong>
                        <p class="text-start ">
                            {{ $order->updated_by?->name ?? 'N/A' }}
                        </p>
                    </div>

                    {{-- <div wire:key='{{ $update_status }}' class="flex items-center gap-2">
                        <strong>{{ __('Status : ') }}</strong>

                        <button :key={{ rand() }} id="dropdownDefaultButton"
                            data-dropdown-toggle="dropdown-{{ $order->id }}"
                            class="{{ $order->status == 1 ? 'text-green-500' : ($order->status == 0 ? 'text-yellow-700' : 'text-red-500') }} py-2.5 px-5 me-2 text-sm flex gap-1 items-center font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                            {{ $order->status == 1 ? 'Recieved' : 'Not-Recieved' }}
                            <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                        <div id="dropdown-{{ $order->id }}"
                            class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                aria-labelledby="dropdownDefaultButton-{{ $order->id }}">
                                <li>
                                    <button wire:click="updateStatus({{ $order->id }}, 1)"
                                        class="block w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                        Recieved
                                    </button>
                                </li>
                                <li>
                                    <button wire:click="updateStatus({{ $order->id }}, 0)"
                                        class="block w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                        Not-Recieved
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div> --}}

                </div>
            </div>

        </div>
        {{-- Start ISBN --}}
        <div
            class="flex flex-col items-stretch justify-end flex-shrink-0 w-full mb-2 space-y-2 md:w-auto md:flex-row md:space-y-0 md:items-center md:space-x-3">

            <div class="flex items-center w-full space-x-3 md:w-auto">
                <button id="filterDropdownButton" wire:click="export"
                    class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg md:w-auto focus:outline-none hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                    type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-file-up">
                        <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z" />
                        <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                        <path d="M12 12v6" />
                        <path d="m15 15-3-3-3 3" />
                    </svg>
                    Export
                </button>
            </div>
        </div>
        <div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-4 py-3">#Invoice</th>
                            <th scope="col" class="px-4 py-3 text-center">Date</th>
                            <th scope="col" class="px-4 py-3 text-center">Customer</th>
                            <th scope="col" class="px-4 py-3 text-center">Pay by</th>
                            <th scope="col" class="px-4 py-3 whitespace-nowrap">SubTotal ($)</th>
                            <th scope="col" class="px-4 py-3 text-center whitespace-nowrap">Total ($)</th>
                            <th scope="col" class="px-4 py-3 text-center">Discount</th>
                            <th scope="col" class="px-4 py-3 text-center">Sale By</th>
                            <th scope="col" class="px-4 py-3 text-center">Updated By</th>
                            <th scope="col" class="py-3 text-center">Status</th>
                            <th scope="col" class="py-3 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($items as $item)
                            <tr wire:key='{{ $item->id }}'
                                class="border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <td class="w-4 px-4 py-3">
                                    #{{ $item->id }}
                                </td>
                                <x-table-data class="text-center capitalize"
                                    value="{{ $item->created_at?->format('d-M-Y  H:i A') ?? 'N/A' }}" />

                                <x-table-data class="text-center" value="{{ $item->customer?->name ?? 'N/A' }}" />
                                <x-table-data class="text-center"
                                    value="{{ $item->paymentTypeId == 0 ? 'Credit' : ($item->payment ? $item->payment->name : 'N/A') }}" />

                                <x-table-data value="{{ $item->subtotal ?? 'N/A' }}" />
                                <x-table-data value="{{ $item->total ?? 'N/A' }}" class="text-red-400" />
                                @if ($item->discountType == 'percentage')
                                    <x-table-data class="text-center" value="{{ $item->discount . ' %' ?? 'N/A' }}" />
                                @else
                                    <x-table-data class="text-center"
                                        value="{{ $item->discount . ' $' ?? 'N/A' }}" />
                                @endif

                                <x-table-data class="text-center" value="{{ $item->user?->name ?? 'N/A' }}" />
                                <x-table-data class="text-center" value="{{ $item->updated_by?->name ?? 'N/A' }}" />

                                <td class="text-center">
                                    <button data-modal-target="popup-modal-user-{{ $item->id }}"
                                        data-modal-toggle="popup-modal-user-{{ $item->id }}">
                                        @if ($item->status == 1)
                                            <span class="w-4 px-4 py-3 font-semibold text-green-700">
                                                Paid
                                            </span>
                                        @else
                                            <span
                                                class="w-4 px-4 py-3 font-semibold text-yellow-600 whitespace-nowrap">
                                                Hold
                                            </span>
                                        @endif
                                    </button>

                                    @can('update saleeeee')
                                        <div id="popup-modal-user-{{ $item->id }}" tabindex="-1"
                                            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                            <div class="relative w-full max-w-md max-h-full p-4">
                                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                                    <button type="button"
                                                        class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                        data-modal-hide="popup-modal-user-{{ $item->id }}">
                                                        <svg class="w-3 h-3" aria-hidden="true"
                                                            xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 14 14">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"
                                                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                        </svg>
                                                    </button>
                                                    <div class="p-4 text-center md:p-5">
                                                        <svg class="w-12 h-12 mx-auto mb-4 text-gray-400 dark:text-gray-200"
                                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                            fill="none" viewBox="0 0 20 20">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"
                                                                d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                        </svg>
                                                        <h3
                                                            class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                                                            Update Status
                                                        </h3>
                                                        <button data-modal-hide="popup-modal-user-{{ $item->id }}"
                                                            type="button"
                                                            wire:click='updateStatus({{ $item->id }}, 0)'
                                                            class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                                            Hold
                                                        </button>
                                                        <button data-modal-hide="popup-modal-user-{{ $item->id }}"
                                                            type="button"
                                                            wire:click='updateStatus({{ $item->id }}, 1)'
                                                            class="text-white bg-green-600 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                                            Paid
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endcan
                                </td>


                                <td class="px-6 py-4">
                                    <div class="flex items-start justify-center gap-3">

                                        <div class="pb-1" x-data="{ tooltip: false }">
                                            <!-- Modal toggle -->
                                            <a href="{{ url('/admin/sales/' . $item->id) }}"
                                                @mouseenter="tooltip = true" @mouseleave="tooltip = false">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="lucide lucide-eye">
                                                    <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z" />
                                                    <circle cx="12" cy="12" r="3" />
                                                </svg>
                                            </a>

                                            <!-- View tooltip -->
                                            <div x-show="tooltip"
                                                x-transition:enter="transition ease-out duration-200"
                                                class="absolute z-10 inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm dark:bg-gray-700"
                                                style="display: none;">
                                                View
                                            </div>
                                        </div>

                                        @can('delete sale')
                                            <div class="pb-1" x-data="{ tooltip: false }">
                                                <!-- Modal toggle -->
                                                <a wire:click="delete({{ $item->id }})"
                                                    wire:confirm="Are you sure? you want to delete : {{ $item->title }}"
                                                    @mouseenter="tooltip = true" @mouseleave="tooltip = false"
                                                    class="text-red-600">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="lucide lucide-trash">
                                                        <path d="M3 6h18" />
                                                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                                                    </svg>
                                                </a>

                                                <!-- View tooltip -->
                                                <div x-show="tooltip"
                                                    x-transition:enter="transition ease-out duration-200"
                                                    class="absolute z-[9999] inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm dark:bg-gray-700 whitespace-nowrap"
                                                    style="display: none;">
                                                    Delete
                                                </div>
                                            </div>
                                        @endcan

                                        {{--
                                        <div class="pb-1" x-data="{ tooltip: false }">
                                            <!-- Modal toggle -->
                                            <a href="{{ url('admin/sales/' . $item->id . '/edit') }}"
                                                @mouseenter="tooltip = true" @mouseleave="tooltip = false">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="lucide lucide-file-pen-line">
                                                    <path d="m18 5-3-3H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2" />
                                                    <path d="M8 18h1" />
                                                    <path d="M18.4 9.6a2 2 0 1 1 3 3L17 17l-4 1 1-4Z" />
                                                </svg>
                                            </a>
                                            <!-- View tooltip -->
                                            <div x-show="tooltip" x-transition:enter="transition ease-out duration-200"
                                                class="absolute z-[9999] inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm dark:bg-gray-700 whitespace-nowrap"
                                                style="display: none;">
                                                Edit
                                            </div>
                                        </div> --}}

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="px-4 py-4">No Data...</td>
                            </tr>
                        @endforelse


                    </tbody>
                </table>

                <div class="p-4">

                    <div>{{ $items->links() }}</div>
                </div>
            </div>
        </div>
    </div>



</div>
