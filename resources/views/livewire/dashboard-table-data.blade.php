<div class="">
    <div class="h-full space-y-8 md:grid md:grid-cols-2 lg:grid-cols-3 md:gap-12 md:space-y-0">
        <div class="flex flex-col items-center justify-center w-full p-4">
            <img src="{{ asset('assets/icons/books.png') }}" alt="icon"
                class="object-contain w-16 rounded dark:bg-gray-200">
            <div class="flex flex-col items-center justify-center">
                <dt class="mt-2 mb-2 text-3xl font-extrabold dark:text-white">{{ $counts['items'] }}</dt>
                <dd class="text-gray-500 dark:text-gray-400">Items</dd>
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

        <div class="flex flex-col items-center justify-center w-full p-4">
            <img src="{{ asset('assets/icons/news.png') }}" alt="icon"
                class="object-contain w-16 rounded dark:bg-gray-200">
            <div class="flex flex-col items-center justify-center">
                <dt class="mt-2 mb-2 text-3xl font-extrabold dark:text-white">{{ $counts['news'] }}</dt>
                <dd class="text-gray-500 dark:text-gray-400">News</dd>
            </div>
        </div>

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
