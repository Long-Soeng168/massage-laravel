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
                        <strong>{{ __('Package Name : ') }}</strong>
                        <p class="text-start ">
                            {{ $order->name ?? 'N/A' }}
                        </p>
                    </div>
                    <div class="flex items-start justify-start gap-2 ">
                        <strong>{{ __('Package Price : ') }}</strong>
                        <p class="text-red-500 text-start">
                            $ {{ $order->price ?? 'N/A' }}
                        </p>
                    </div>
                    <div class="flex items-start justify-start gap-2 ">
                        <strong>{{ __('Real Cost : ') }}</strong>
                        <p class="text-start ">
                            $ {{ $order->total_amount ?? 'N/A' }}
                        </p>
                    </div>
                    <div class="flex items-start justify-start gap-2 ">
                        <strong>{{ __('Created By : ') }}</strong>
                        <p class="text-start ">
                            {{ $order->created_by?->name ?? 'N/A' }}
                        </p>
                    </div>
                    <div class="flex items-start justify-start gap-2 ">
                        <strong>{{ __('Updated By : ') }}</strong>
                        <p class="text-start ">
                            {{ $order->updated_by?->name ?? 'N/A' }}
                        </p>
                    </div>


                </div>
            </div>

        </div>
        {{-- Start ISBN --}}
        <div>
            <div class="overflow-x-auto">
                <table class="w-full px-2 text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-4 py-3">No</th>
                            <th scope="col" class="px-4 py-3">Image</th>
                            <th scope="col" class="px-4 py-3">Service Name</th>
                            <th scope="col" class="px-4 py-3">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($items as $item)
                            <tr wire:key='{{ $item->id }}'
                                class="border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <td class="w-4 px-4 py-3">
                                    {{ $loop->iteration }}
                                </td>
                                <th scope="row"
                                    class="flex items-center px-4 py-2 font-medium text-gray-900 dark:text-white">
                                    <a href="{{ asset('assets/images/isbn/' . $item->service?->image) }}"
                                        class="glightbox">
                                        <img src="{{ asset('assets/images/isbn/' . $item->service?->image) }}"
                                            alt="iMac Front Image" class="object-contain h-10 mr-3 aspect-[16/9]">
                                    </a>
                                </th>
                                <x-table-data value="{{ $item->service?->title }}" />
                                <x-table-data>
                                    @if ($item->discount > 0)
                                        <span class="line-through">{{ $item->price }}</span>
                                        <span class="text-red-400">$
                                            {{ $item->price - ($item->discount / 100) * $item->price }}</span>
                                    @else
                                        <span class="text-red-400">$ {{ $item->price }}</span>
                                    @endif
                                </x-table-data>

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
