<div>
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

    @if (session()->has('error'))
        {{-- @dd(session()->has('error')) --}}
        <div class="fixed top-[5rem] right-4 z-[999999] " wire:key="{{ rand() }}" x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 7000)">
            <div x-show="show" id="alert-2"
                class="flex items-center p-4 mb-4 text-red-800 border border-red-500 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                role="alert">
                <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <div class="ml-2">
                    @foreach (session('error') as $error)
                        <div class="text-sm font-medium ms-3">
                            - {{ $error }}
                        </div>
                    @endforeach

                    {{ session()->forget('errors') }}



                </div>
                <button type="button" @click="show = false"
                    class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700"
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
    <form class="w-full" enctype="multipart/form-data">
        @csrf

        <div class="">
            <section class="mt-8">
                <div class="grid grid-cols-1 gap-4 mt-4 md:grid-cols-2 ">
                    {{-- Start Products Select --}}
                    <div class="relative w-full col-span-2 overflow-x-scroll group">
                        {{-- Start Select Products --}}
                        <div>
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                        fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="text" id="simple-search" wire:model.live.debounce.300ms='search'
                                    class="block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Search...">
                            </div>
                            <table class="w-full overflow-x-scroll text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-4 py-3">No</th>
                                        <th scope="col" class="px-4 py-3 text-center">Image</th>
                                        <th scope="col" class="px-4 py-3">Title</th>
                                        <th scope="col" class="px-4 py-3">Price</th>
                                        <th scope="col" class="py-3 text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($items as $item)
                                        @php
                                            $selectedIds = array_map(function ($value) {
                                                return $value['id'];
                                            }, $selectedProducts);
                                        @endphp
                                        {{-- @if (in_array($item->id, $selectedIds))
                                            <p>{{ $item->id }} exists</p>
                                        @else
                                            <p>{{ $item->id }} does not exist</p>
                                        @endif --}}
                                        <tr wire:key='{{ $item->id }}'
                                            class="border-b {{ in_array($item->id, $selectedIds) ? 'bg-gray-200 hover:bg-gray-300 dark:bg-gray-600' : '' }} dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700">
                                            <td class="w-4 px-4 py-3">
                                                {{ $loop->iteration }}

                                            </td>

                                            <th scope="row">
                                                @if ($item->image)
                                                    <span class="flex items-center justify-center ">
                                                        <a href="{{ asset('assets/images/isbn/' . $item->image) ?? 'N/A' }}"
                                                            class="text-center glightbox">
                                                            <img src="{{ asset('assets/images/isbn/thumb/' . $item->image) ?? 'N/A' }}"
                                                                alt="Image"
                                                                class="object-contain p-1 max-h-20 aspect-[1/1]">
                                                        </a>
                                                    </span>
                                                @else
                                                    <span class="flex items-center justify-center ">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            class="lucide lucide-image">
                                                            <rect width="18" height="18" x="3" y="3"
                                                                rx="2" ry="2" />
                                                            <circle cx="9" cy="9" r="2" />
                                                            <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21" />
                                                        </svg>
                                                    </span>
                                                @endif
                                            </th>
                                            <x-table-data value="{{ $item->title ?? 'N/A' }}" />
                                            <x-table-data value="$ {{ $item->price ?? 'N/A' }}"
                                                class="text-red-400 whitespace-nowrap" />
                                            <td class="relative px-6 py-4">
                                                <div x-data="{ tooltip: false }"
                                                    class="flex items-start justify-center gap-3 cursor-pointer ">
                                                    @can('update stock')
                                                        @if (in_array($item->id, $selectedIds))
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="lucide lucide-circle-check-big">
                                                                <path d="M21.801 10A10 10 0 1 1 17 3.335" />
                                                                <path d="m9 11 3 3L22 4" />
                                                            </svg>
                                                        @else
                                                            <a wire:click='handleSelectProduct({{ $item->id }})'
                                                                class="transition-all duration-300 hover:scale-110">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="28"
                                                                    height="28" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="lucide lucide-plus-circle">
                                                                    <circle cx="12" cy="12" r="10" />
                                                                    <path d="M8 12h8" />
                                                                    <path d="M12 8v8" />
                                                                </svg>
                                                            </a>
                                                        @endif

                                                        <span class="absolute top-0 z-50 flex -right-2"
                                                            wire:target="handleSelectProduct({{ $item->id }})"
                                                            wire:loading>
                                                            <img class="inline w-8 h-8 text-white me-2 animate-spin"
                                                                src="{{ asset('assets/images/reload.png') }}"
                                                                alt="reload-icon">
                                                        </span>
                                                    @endcan
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
                                <div class="max-w-[200px] my-2 flex gap-2 items-center">
                                    <label for="countries"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white whitespace-nowrap">Record
                                        per
                                        page : </label>
                                    <select id="countries" wire:model.live='perPage'
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option value="5">5</option>
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="50">50</option>
                                        <option value="70">70</option>
                                        <option value="100">100</option>
                                    </select>
                                </div>
                                <div>{{ $items->links() }}</div>
                            </div>
                        </div>
                        {{-- End Select Products --}}

                        <div class="mt-8">
                            <table
                                class="w-full overflow-auto border border-collapse border-gray-300 table-auto dark:border-gray-600">
                                <thead>
                                    <tr class="bg-gray-200 dark:bg-gray-700">
                                        <th
                                            class="px-4 py-2 text-left border border-gray-300 dark:border-gray-600 dark:text-gray-200">
                                            Title</th>

                                        <th
                                            class="px-4 py-2 text-left border border-gray-300 dark:border-gray-600 dark:text-gray-200">
                                            Price
                                        </th>
                                        <th
                                            class="px-4 py-2 text-left border border-gray-300 dark:border-gray-600 dark:text-gray-200">
                                            Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $total = 0;
                                    @endphp

                                    @foreach ($selectedProducts as $index => $item)
                                        @php
                                            $subtotal = $item['price'];
                                            $total += $subtotal;
                                        @endphp
                                        <tr wire:key="{{ $item['id'] }}"
                                            class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                            <td
                                                class="px-4 py-2 border border-gray-300 dark:border-gray-600 dark:text-gray-200">
                                                {{ $item['title'] }}
                                            </td>

                                            <td class="px-4 py-2 border border-gray-300 dark:border-gray-600">
                                                <input type="text" disabled
                                                    wire:change="updateProduct({{ $item['id'] }}, 'price', $event.target.value)"
                                                    value="{{ $item['price'] }}" placeholder="Unit Price"
                                                    class="w-full px-2 py-1 border rounded focus:ring focus:ring-blue-300 dark:bg-gray-800 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500">
                                            </td>

                                            <td
                                                class="px-4 py-2 font-semibold border border-gray-200 dark:border-gray-600">
                                                <button type="button" wire:key='removeProduct-{{ $index }}'
                                                    wire:click="removeProduct({{ $index }})"
                                                    class="text-red-500 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300">Remove</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr
                                        class="text-sm font-bold text-gray-800 bg-gray-100 dark:bg-gray-700 dark:text-gray-200">
                                        <td colspan="1"
                                            class="px-4 py-2 text-right border border-gray-200 dark:border-gray-600">
                                            Total:</td>
                                        <td colspan="2"
                                            class="px-4 py-2 border border-gray-200 dark:border-gray-600">
                                            ${{ number_format($total, 2) }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            <x-input-error :messages="$errors->get('selectedProducts')" class="mt-2" />

                        </div>
                    </div>

                    <!-- Status Selection -->


                    <div>
                        <x-input-label for="name" :value="__('Package Name')" /><span class="text-red-400">*</span>
                        <x-text-input wire:model.live='name' id="name" class="block w-full mt-1" type="text"
                            name="name" :value="old('name')" autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="usable_number" :value="__('Usable Number')" /><span class="text-red-400">*</span>
                        <x-text-input wire:model.live='usable_number' id="usable_number" class="block w-full mt-1"
                            type="number" name="usable_number" :value="old('usable_number')" autocomplete="usable_number" />
                        <x-input-error :messages="$errors->get('usable_number')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="services_real_cost" :value="__('All Services Real Cost ($)')" /><span
                            class="text-red-400">*</span>
                        <x-text-input id="services_real_cost" disabled class="block w-full mt-1" type="text"
                            name="services_real_cost" :value="number_format($total, 2) * (int) $usable_number" autocomplete="services_real_cost" />
                        <x-input-error :messages="$errors->get('services_real_cost')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="package_price" :value="__('Package Price ($)')" /><span class="text-red-400">*</span>
                        <x-text-input wire:model='package_price' id="package_price" class="block w-full mt-1"
                            type="text" name="package_price" :value="number_format($total, 2) * (int) $usable_number" autocomplete="package_price" />
                        <x-input-error :messages="$errors->get('package_price')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="code" :value="__('Code')" /><span class="text-red-400">*</span>
                        <x-text-input wire:model='code' id="code" class="block w-full mt-1" type="text"
                            name="code" :value="number_format($total, 2) * (int) $usable_number" autocomplete="code" />
                        <x-input-error :messages="$errors->get('code')" class="mt-2" />
                    </div>
                </div>


            </section>
            {{-- Start supplier Select --}}



        </div>
        <!-- End Name -->


        <div class="mt-5">
            <x-outline-button wire:ignore href="{{ URL::previous() }}">
                Go back
            </x-outline-button>
            <button wire:loading.class="cursor-not-allowed" wire:click.prevent="save"
                wire:target="save, image, file, handleSelectProduct, updateProduct, removeProduct"
                wire:loading.attr="disabled"
                class = 'text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800'>
                Save
            </button>
            <span wire:target="save" wire:loading>
                <img class="inline w-6 h-6 text-white me-2 animate-spin"
                    src="{{ asset('assets/images/reload.png') }}" alt="reload-icon">
                Saving
            </span>
            <span wire:target="handleSelectProduct, updateProduct, removeProduct" wire:loading>
                <img class="inline w-6 h-6 text-white me-2 animate-spin"
                    src="{{ asset('assets/images/reload.png') }}" alt="reload-icon">
                Loading
            </span>
            <span wire:target="file,image" wire:loading class="dark:text-white">
                <img class="inline w-6 h-6 text-white me-2 animate-spin"
                    src="{{ asset('assets/images/reload.png') }}" alt="reload-icon">
                On Uploading File...
            </span>
        </div>
    </form>

</div>

@script
    <script>
        $(document).ready(function() {
            document.addEventListener('livewire:updated', event => {
                console.log('updated'); // Logs 'Livewire component updated' to browser console
                initFlowbite();
            });
        });

        function initSelect2() {
            $(document).ready(function() {
                $('.product-select').select2();
                $('.product-select').on('change', function(event) {
                    let data = $(this).val();
                    @this.handleSelectProduct(data)
                    // @this.set('product_id', data);
                });
            });
        }
        initSelect2();

        $(document).ready(function() {
            document.addEventListener('livewire:updated', event => {
                console.log('updated'); // Logs 'Livewire component updated' to browser console
                initSelect2();
                initFlowbite();
            });
        });
    </script>
@endscript
