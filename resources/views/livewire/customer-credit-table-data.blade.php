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
    <div class="grid grid-cols-2 gap-2 p-4 lg:grid-cols-4">
        {{-- Start Customer --}}
        <div class="relative z-0 w-full group">
            <x-input-label for="customerId" :value="__('Customer')" />
            <div class="flex flex-1 gap-1 mt-1 min-h-[2.5rem]">
                <div class="flex justify-start flex-1">
                    <x-select-option wire:model.live='customerId' id="customerId" name="customerId"
                        class="customerId-select">
                        <option wire:key='customerId-select' value="">All Customer</option>
                        {{-- <option wire:key='customerId-' value="0">General</option> --}}

                        @forelse ($customers as $item)
                            <option wire:key='{{ $item->id }}' value="{{ $item->id }}">
                                {{ $item->name }} <span>{{ $item->phone ? '('.$item->phone.')' : '' }}</span></option>
                        @empty
                            <option wire:key='{{ $year }}' value="{{ $year }}">
                                No Data...</option>
                        @endforelse
                    </x-select-option>
                </div>
            </div>
        </div>

        {{-- Start Payment Method --}}
        {{-- <div class="relative z-0 w-full group">
            <x-input-label for="paymentId" :value="__('Pay By')" />
            <div class="flex flex-1 gap-1 mt-1 min-h-[2.5rem]">
                <div class="flex justify-start flex-1">
                    <x-select-option wire:model.live='paymentId' id="paymentId" name="paymentId"
                        class="paymentId-select">
                        <option wire:key='paymentId-select' value="">All Payment</option>
                        <option wire:key='paymentId-' value="0">Credit</option>

                        @forelse ($payments as $item)
                            <option wire:key='{{ $item->id }}' value="{{ $item->id }}">
                                {{ $item->name }}</option>
                        @empty
                            <option wire:key='paymentId-select' value="">No Data..</option>
                        @endforelse

                    </x-select-option>
                </div>
            </div>
        </div> --}}

        {{-- Select Item Type --}}
        
        <div class="relative z-0 w-full group">
            <x-input-label for="adjustmentAction" :value="__('Action')" />
            <div class="flex flex-1 gap-1 mt-1 min-h-[2.5rem]">
                <div class="flex justify-start flex-1">
                    <x-select-option wire:model.live='adjustmentAction' id="adjustmentAction" name="adjustmentAction"
                        class="adjustmentAction-select">
                        <option wire:key='adjustmentAction-select' value="">All Action</option>
                        <option wire:key='adjustmentAction-1' value="add">Add</option>
                        <option wire:key='adjustmentAction-2' value="minus">Minus</option>
                    </x-select-option>
                </div>
            </div>
        </div>

        <div class="relative z-0 w-full group">
            <x-input-label for="createdBy" :value="__('Created By')" />
            <div class="flex flex-1 gap-1 mt-1 min-h-[2.5rem]">
                <div class="flex justify-start flex-1">
                    <x-select-option wire:model.live='createdBy' id="createdBy" name="createdBy"
                        class="createdBy-select">
                        <option wire:key='createdBy-select' value="">All User</option>

                        @forelse ($users as $item)
                            <option wire:key='{{ $item->id }}' value="{{ $item->id }}">
                                {{ $item->name }}</option>
                        @empty
                            <option wire:key='{{ $year }}' value="{{ $year }}">
                                No Data...</option>
                        @endforelse
                    </x-select-option>
                </div>
            </div>
        </div>
        {{-- End Release From Year --}}
    </div>
    <div
        class="flex flex-col px-4 py-3 space-y-3 lg:flex-row lg:items-center lg:justify-between lg:space-y-0 lg:space-x-4">
        <div class="w-full md:w-1/2">
            <form class="flex items-center gap-4">
                <div class="relative w-full">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor"
                            viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="text" id="simple-search" wire:model.live.debounce.300ms='search'
                        class="block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Search Name, Code...">
                </div>

            </form>
        </div>

        <div>
            <div class="flex flex-wrap gap-2">
                <div class="flex items-center gap-2">
                    <label for="start_date" class="text-sm font-semibold text-gray-700 whitespace-nowrap">Start</label>
                    <div>
                        <x-text-input wire:model.live='start_date' id="start_date"
                            class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            type="date" name="start_date" :value="old('start_date')" autocomplete="start_date" />
                        <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <label for="start_date" class="text-sm font-semibold text-gray-700 whitespace-nowrap">End</label>
                    <div>
                        <x-text-input wire:model.live='end_date' id="end_date"
                            class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            type="date" name="end_date" :value="old('end_date')" autocomplete="end_date" />
                        <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                    </div>
                </div>
                <div class="flex items-center w-full space-x-3 md:w-auto">
                    <button id="filterDropdownButton" wire:click='export'
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
        </div>

    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-4 py-3">No</th>
                    <th scope="col" class="px-4 py-3 text-center">Customer</th>
                    <th scope="col" class="px-4 py-3 whitespace-nowrap">Amount ($)</th>
                    <th scope="col" class="px-4 py-3 whitespace-nowrap">Credit ($)</th>
                    <th scope="col" class="px-4 py-3">Action</th>
                    <th scope="col" class="px-4 py-3 text-center">Date</th>
                    {{-- <th scope="col" class="px-4 py-3 text-center">Pay by</th> --}}
                    <th scope="col" class="px-4 py-3 text-center">Created By</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($items as $item)
                    <tr wire:key='{{ $item->id }}'
                        class="border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <x-table-data class="w-4 px-4 py-3">
                            {{ $loop->index + 1 }}
                        </x-table-data>
                        <x-table-data class="text-center" value="{{ $item->customer?->name ?? 'N/A' }}" />
                        <x-table-data class="w-4 px-4 py-3 text-blue-600 whitespace-nowrap">
                            $ {{ $item->amount }}
                        </x-table-data>
                        <x-table-data class="w-4 px-4 py-3 text-red-600 whitespace-nowrap">
                            $ {{ $item->credit }}
                        </x-table-data>
                        <x-table-data class="w-4 px-4 py-3 whitespace-nowrap {{ $item->action == 'add' ? 'text-green-600' : 'text-red-500' }}">
                            {{ $item->action == 'add' ? 'Add (+)' : 'Minus (-)' }}
                        </x-table-data>
                        <x-table-data class="text-center capitalize whitespace-nowrap"
                            value="{{ $item->created_at?->format('d-M-Y') ?? 'N/A' }}" />

                       

                        <x-table-data class="text-center" value="{{ $item->user?->name ?? 'N/A' }}" />
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
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white whitespace-nowrap">Record per
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
</div>


@script
    <script>
        $(document).ready(function() {
            document.addEventListener('livewire:updated', event => {
                console.log('updated'); // Logs 'Livewire component updated' to browser console
                initFlowbite();
                initSelect2();
            });
        });
        $(document).ready(function() {
            document.addEventListener('livewire:updatedStatus', event => {
                console.log('updated'); // Logs 'Livewire component updated' to browser console
                initFlowbite();
                initSelect2();
                location.reload();
            });
        });
        initFlowbite();

        function initSelect2() {
            $(document).ready(function() {

                $('.createdBy-select').select2();
                $('.createdBy-select').on('change', function(event) {
                    let data = $(this).val();
                    @this.set('createdBy', data);
                });

                $('.customerId-select').select2();
                $('.customerId-select').on('change', function(event) {
                    let data = $(this).val();
                    @this.set('customerId', data);
                });

                $('.paymentId-select').select2();
                $('.paymentId-select').on('change', function(event) {
                    let data = $(this).val();
                    @this.set('paymentId', data);
                });

                $('.itemType-select').select2();
                $('.itemType-select').on('change', function(event) {
                    let data = $(this).val();
                    @this.set('itemType', data);
                });
            });
        }
        initSelect2();
        // Function to check for URL changes
        function checkUrlChange() {
            let currentUrl = window.location.href;

            // Check for URL changes every 500ms
            setInterval(() => {
                if (window.location.href !== currentUrl) {
                    currentUrl = window.location.href;
                    console.log('URL changed:', currentUrl);

                    // Reinitialize your functions
                    initFlowbite();
                    initSelect2();
                }
            }, 500); // Adjust the interval as needed
        }

        // Start checking for URL changes
        checkUrlChange();
    </script>
@endscript
