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
                <div class="grid grid-cols-1 gap-4 mt-4 md:grid-cols-2">
                    <div class="md:col-span-2">
                        <x-input-label for="title" :value="__('messages.title')" /><span class="text-red-400">*</span>
                        <x-text-input wire:model='title' id="title" class="block w-full mt-1" type="text"
                            name="title" :value="old('title')" autocomplete="title" />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>
                    <div class="md:col-span-2">
                        <x-input-label for="short_description" :value="__('Short Description')" />
                        <textarea wire:model='short_description' class="w-full p-2 mt-1 border rounded bg-gray-50 dark:bg-gray-600"
                            placeholder="Enter Short Description">{{ $short_description }}</textarea>
                        <x-input-error :messages="$errors->get('short_description')" class="mt-2" />
                    </div>
                    {{-- Start brand Select --}}

                    {{-- End brand Select --}}

                    <div class="flex gap-4">
                        <div class="flex-1">
                            <x-input-label for="price" :value="__('messages.price') . ' ($)'" /><span class="text-red-400">*</span>
                            <x-text-input wire:model='price' id="price" class="block w-full mt-1" type="number"
                                name="price" placeholder='Example : 7$' :value="old('price')" autocomplete="price" />
                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                        </div>
                    </div>

                    {{-- Start Image Upload --}}
                    <div class="flex items-center mb-5 md:col-span-2 space-4" wire:key='uploadimage'>
                        @if ($image)
                            <div class="pt-5 max-w-40">
                                <img src="{{ $image->temporaryUrl() }}" alt="Selected Image"
                                    class="max-w-full pr-4 max-h-40" />
                            </div>
                        @endif
                        <div class="flex flex-col flex-1">
                            <label class='mb-4 text-sm font-medium text-gray-600 dark:text-white'>
                                Upload Cover (Max: 2MB) <span class="text-red-500">*</span>
                            </label>
                            <div class="relative flex items-center justify-center w-full -mt-3 overflow-hidden">
                                <label for="dropzone-file"
                                    class="flex flex-col items-center justify-center w-full h-40 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                            <path stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="2"
                                                d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span
                                                class="font-semibold">Click to upload</span> or drag and drop</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            PNG, JPG (MAX. 2MB)
                                        </p>

                                    </div>
                                    <input wire:model="image" accept="image/png, image/jpeg, image/gif"
                                        id="dropzone-file" type="file" class="absolute h-[140%] w-[100%]" />
                                </label>
                            </div>
                            <div wire:loading wire:target="image" class="text-blue-700">
                                <span>
                                    <img class="inline w-6 h-6 text-white me-2 animate-spin"
                                        src="{{ asset('assets/images/reload.png') }}" alt="reload-icon">
                                    Uploading...
                                </span>
                            </div>
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>
                    </div>
                    {{-- End Image Upload --}}

                </div>
            </section>

            <!-- ISBN Allocation Section -->
            {{-- <section class="mt-8">
                    <h3 class="text-lg font-bold">ISBN Allocated / ISBN attribué</h3>
                    <div class="grid grid-cols-1 gap-4 mt-4 md:grid-cols-1">
                        <div>
                            <label class="block font-bold">ISBN-13: 978 - 99963 -</label>
                            <input type="text" class="w-full p-2 mt-1 border rounded" placeholder="Enter ISBN">
                        </div>
                        <div>
                            <label class="block font-bold">ISBN-13: 978 - 9924 -</label>
                            <input type="text" class="w-full p-2 mt-1 border rounded" placeholder="Enter ISBN">
                        </div>
                        <div>
                            <label class="block font-bold">ISBN-13: 978 - 9950 -</label>
                            <input type="text" class="w-full p-2 mt-1 border rounded" placeholder="Enter ISBN">
                        </div>
                    </div>
                </section> --}}


        </div>
        <!-- End Name -->


        <div>
            <x-outline-button wire:ignore href="{{ URL::previous() }}">
                Go back
            </x-outline-button>
            <button wire:loading.class="cursor-not-allowed" wire:click.prevent="save" wire:target="save, image, file"
                wire:loading.attr="disabled"
                class = 'text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800'>
                Save
            </button>
            <span wire:target="save" wire:loading>
                <img class="inline w-6 h-6 text-white me-2 animate-spin"
                    src="{{ asset('assets/images/reload.png') }}" alt="reload-icon">
                Saving
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

        let options = {
            filebrowserImageBrowseUrl: "{{ asset('laravel-filemanager?type=Images') }}",
            filebrowserImageUploadUrl: "{{ asset('laravel-filemanager/upload?type=Images&_token=') }}",
            filebrowserBrowseUrl: "{{ asset('laravel-filemanager?type=Files') }}",
            filebrowserUploadUrl: "{{ asset('laravel-filemanager/upload?type=Files&_token=') }}"
        };

        $(document).ready(function() {
            const editor = CKEDITOR.replace('description', options);
            editor.on('change', function(event) {
                console.log(event.editor.getData())
                @this.set('description', event.editor.getData(), false);
            })
        })


        function initSelect2() {
            $(document).ready(function() {
                $('.category-select').select2();
                $('.category-select').on('change', function(event) {
                    let data = $(this).val();
                    @this.set('category_id', data);
                });

                $('.sub-category-select').select2();
                $('.sub-category-select').on('change', function(event) {
                    let data = $(this).val();
                    @this.set('sub_category_id', data);
                });

                $('.brand-select').select2();
                $('.brand-select').on('change', function(event) {
                    let data = $(this).val();
                    @this.set('brand_id', data);
                });
                $('.publisher-select').select2();
                $('.publisher-select').on('change', function(event) {
                    let data = $(this).val();
                    @this.set('publisher_id', data);
                });

                $('.year-select').select2();
                $('.year-select').on('change', function(event) {
                    let data = $(this).val();
                    @this.set('year', data);
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
