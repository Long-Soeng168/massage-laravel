<div class="">
    <div class="h-full space-y-8 md:grid md:grid-cols-2 lg:grid-cols-3 md:gap-12 md:space-y-0">
        <div class="flex flex-col items-center justify-center w-full p-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-layout-list">
                <rect width="7" height="7" x="3" y="3" rx="1" />
                <rect width="7" height="7" x="3" y="14" rx="1" />
                <path d="M14 4h7" />
                <path d="M14 9h7" />
                <path d="M14 15h7" />
                <path d="M14 20h7" />
            </svg>
            <div class="flex flex-col items-center justify-center">
                <dt class="mt-2 mb-2 text-3xl font-extrabold dark:text-white">{{ $counts['products'] }}</dt>
                <dd class="text-gray-500 dark:text-gray-400">Products</dd>
            </div>
        </div>
        <div class="flex flex-col items-center justify-center w-full p-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-hand-platter">
                <path d="M12 3V2" />
                <path
                    d="m15.4 17.4 3.2-2.8a2 2 0 1 1 2.8 2.9l-3.6 3.3c-.7.8-1.7 1.2-2.8 1.2h-4c-1.1 0-2.1-.4-2.8-1.2l-1.302-1.464A1 1 0 0 0 6.151 19H5" />
                <path d="M2 14h12a2 2 0 0 1 0 4h-2" />
                <path d="M4 10h16" />
                <path d="M5 10a7 7 0 0 1 14 0" />
                <path d="M5 14v6a1 1 0 0 1-1 1H2" />
            </svg>
            <div class="flex flex-col items-center justify-center">
                <dt class="mt-2 mb-2 text-3xl font-extrabold dark:text-white">{{ $counts['services'] }}</dt>
                <dd class="text-gray-500 dark:text-gray-400">Services</dd>
            </div>
        </div>
        <div class="flex flex-col items-center justify-center w-full p-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-package">
                <path
                    d="M11 21.73a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73z" />
                <path d="M12 22V12" />
                <polyline points="3.29 7 12 12 20.71 7" />
                <path d="m7.5 4.27 9 5.15" />
            </svg>
            <div class="flex flex-col items-center justify-center">
                <dt class="mt-2 mb-2 text-3xl font-extrabold dark:text-white">{{ $counts['packages'] }}</dt>
                <dd class="text-gray-500 dark:text-gray-400">Packages</dd>
            </div>
        </div>

        <div class="flex flex-col items-center justify-center w-full p-4">
            <img src="{{ asset('assets/icons/author.png') }}" alt="icon"
                class="object-contain w-16 rounded dark:bg-gray-200">
            <div class="flex flex-col items-center justify-center">
                <dt class="mt-2 mb-2 text-3xl font-extrabold dark:text-white">{{ $counts['brands'] }}</dt>
                <dd class="text-gray-500 dark:text-gray-400">Brands</dd>
            </div>
        </div>

        <div class="flex flex-col items-center justify-center w-full p-4">
            <img src="{{ asset('assets/icons/user.png') }}" alt="icon"
                class="object-contain w-16 rounded dark:bg-gray-200">
            <div class="flex flex-col items-center justify-center">
                <dt class="mt-2 mb-2 text-3xl font-extrabold dark:text-white">{{ $counts['customers'] }}</dt>
                <dd class="text-gray-500 dark:text-gray-400">Customers</dd>
            </div>
        </div>

        <div class="flex flex-col items-center justify-center w-full p-4">
            <img src="{{ asset('assets/icons/book_categories.png') }}" alt="icon"
                class="object-contain w-16 rounded dark:bg-gray-200">
            <div class="flex flex-col items-center justify-center">
                <dt class="mt-2 mb-2 text-3xl font-extrabold dark:text-white">{{ $counts['suppliers'] }}</dt>
                <dd class="text-gray-500 dark:text-gray-400">Suppliers</dd>
            </div>
        </div>

        {{-- <div class="flex flex-col items-center justify-center w-full p-4">
            <img src="{{ asset('assets/icons/news.png') }}" alt="icon"
                class="object-contain w-16 rounded dark:bg-gray-200">
            <div class="flex flex-col items-center justify-center">
                <dt class="mt-2 mb-2 text-3xl font-extrabold dark:text-white">{{ $counts['news'] }}</dt>
                <dd class="text-gray-500 dark:text-gray-400">News</dd>
            </div>
        </div> --}}

        <div class="flex flex-col items-center justify-center w-full p-4">
            <img src="{{ asset('assets/icons/user.png') }}" alt="icon"
                class="object-contain w-16 rounded dark:bg-gray-200">
            <div class="flex flex-col items-center justify-center">
                <dt class="mt-2 mb-2 text-3xl font-extrabold dark:text-white">{{ $counts['users'] }}</dt>
                <dd class="text-gray-500 dark:text-gray-400">Users</dd>
            </div>
        </div>
    </div>
</div>
