<section>
    {{-- inner banner --}}
    <div class="relative w-full h-[50vh] bg-cover bg-center bg-no-repeat overflow-hidden"
        style="background-image: url('{{ asset('assets/images/inner_banner_bg.png') }}');">
        {{-- Main Content Container --}}
        <div class="relative z-50 container mx-auto px-4 sm:px-6 lg:px-8 h-full">
            <div class="flex items-center justify-between h-full">

                {{-- Left Side - "Cars List" Text --}}
                <div class="flex-1 flex justify-center">
                    <a href="#" wire:navigate class="text-3xl lg:text-4xl font-normal text-gray-900 tracking-wide">
                        {{ __('Cars List') }}
                    </a>
                </div>

                {{-- Right Side - Car Image --}}
                <div class="flex-1 flex justify-start items-center">
                    <div class="max-w-[450px] -translate-x-8">
                        <img src="{{ asset('assets/images/banner_car.png') }}" alt="Gray SUV Car"
                            class="w-full h-auto drop-shadow-2xl" />
                    </div>
                </div>

            </div>
        </div>
    </div>


    <div class="max-w-7xl bg-white mx-auto px-4 py-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 xxs:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 md:gap-8">

            <!-- Loop through the dynamic products data -->
            @foreach ($this->products as $product)
                <div
                    class="w-full bg-white rounded-xl shadow-2xl overflow-hidden   transform hover:scale-[1.02] transition duration-300 ease-in-out group">

                    <div class="relative">
                        <div
                            class="flex gap-1 absolute top-2 right-4 items-center bg-black/10 text-xs backdrop-blur-md rounded-full px-2 p-1.5 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <span>
                                <flux:icon name="photo" class="w-4 h-4 text-white" />
                            </span>
                            <span class="text-gray-200 font-medium">
                                {{ $product['id'] }}
                            </span>
                        </div>


                        <div class="h-58">
                            <!-- Dynamic Image Source -->
                            <img class="w-full h-full object-cover"
                                src="{{ asset('assets/images/' . $product['image_name']) }}"
                                alt="{{ $product['name'] }} Image">
                        </div>

                        <!-- Dynamic Tags -->
                        <span
                            class="absolute bottom-2 left-2 bg-accent text-white text-xs xxs:text-sm font-semibold px-3 py-1.5 rounded-md shadow-lg tracking-wider">
                            {{ $product['tags'] }}
                        </span>

                        <div class="absolute bottom-2 right-4 text-zinc-500 p-1">
                            <flux:icon name="eye" class="w-5 h-5" />
                        </div>
                    </div>

                    <div class="p-4">
                        <div class="p-2">
                            <div class="flex justify-between items-center mb-2">
                                <div>
                                    <!-- Dynamic Product Name -->
                                    <p
                                        class="text-xs xs:text-sm md:text-base font-normal text-gray-700 uppercase leading-snug">
                                        {{ $product['name'] }}
                                    </p>
                                </div>
                                <div class="text-right text-gray-900 font-bold text-lg md:text-xl flex-shrink-0 ml-2">
                                    <!-- Dynamic Price -->
                                    ${{ $product['price_per_day'] }} <span
                                        class="text-xs sm:text-sm font-medium text-gray-500 ml-1">{{ __('/Day') }}</span>
                                </div>
                            </div>

                            <!-- Dynamic Location -->
                            <div class="flex items-center text-xs sm:text-sm text-gray-500">
                                <flux:icon name="map-pin" class="text-zinc-500 mr-2 w-4 h-4 sm:w-5 sm:h-5" />
                                <span>{{ $product['location'] }}</span>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 my-2"></div>

                        <div class="flex justify-between items-center text-gray-600 text-xs ">
                            <!-- Dynamic Persons Capacity -->
                            <div class="flex items-center">
                                <flux:icon name="users" class="text-zinc-500 mr-1 w-4 h-4 sm:w-5 sm:h-5" />
                                <span class="font-semibold text-gray-800">{{ $product['persons'] }}</span>
                                {{ __('Persons') }}
                            </div>

                            <!-- Dynamic Features (Assuming the first feature in the array is the main one) -->
                            @if (!empty($product['features']))
                                <div class="flex items-center">
                                    <flux:icon name="smartphone" class="w-4 h-4 sm:w-5 sm:h-5  text-zinc-500" />
                                    {{ $product['features'][0] }}
                                </div>
                            @endif

                            <!-- Dynamic Trips Count -->
                            <div class="flex items-center">
                                <flux:icon name="calendar" class="text-zinc-500 mr-1 w-4 h-4 sm:w-5 sm:h-5" />
                                <span class="font-semibold text-gray-800">{{ $product['trips'] }}</span>
                                {{ __('Trips') }}
                            </div>
                        </div>

                        <div class="flex flex-col md:flex-row gap-3 mt-4 sm:mt-6">

                            <button
                                class="flex-1 flex items-center justify-center bg-accent text-white py-2! px-2! text-sm rounded-lg font-semibold shadow-md hover:bg-accent/90 transition duration-150 transform hover:scale-[1.01]">
                                <flux:icon.book-open class="w-5 h-5 mr-2" />
                                {{ __('Book') }}
                            </button>

                            <button
                                class="flex-1 bg-gray-800 text-white py-2! px-2! text-sm rounded-lg font-semibold shadow-md hover:bg-gray-700 transition duration-150 transform hover:scale-[1.01]">
                                {{ __('Get In touch') }}
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Dynamic Pagination -->
        <div class="flex justify-center items-center mt-8 mb-4 space-x-2">
            @php
                $currentPage = $this->getPage();
                $totalPages = $this->totalPages;

                // Calculate page range to display - matching second image pattern
                $rangeWithDots = [];

                if ($totalPages <= 5) {
                    // Show all pages if 5 or less
                    for ($i = 1; $i <= $totalPages; $i++) {
                        $rangeWithDots[] = $i;
                    }
                } else {
                    // Pattern: < 1 ... 3 4 5 ... 7 || >
                    // Always show first page
                    $rangeWithDots[] = 1;

                    // Determine which pages to show around current page
                    $start = max(2, $currentPage - 1);
                    $end = min($totalPages - 1, $currentPage + 1);

                    // Add left ellipsis if needed
                    if ($start > 2) {
                        $rangeWithDots[] = '...';
                    }

                    // Add pages around current page
                    for ($i = $start; $i <= $end; $i++) {
                        $rangeWithDots[] = $i;
                    }

                    // Add right ellipsis if needed
                    if ($end < $totalPages - 1) {
                        $rangeWithDots[] = '...';
                    }

                    // Always show last page
                    $rangeWithDots[] = $totalPages;
                }
            @endphp

            <!-- Previous Button -->
            <button wire:click="previousPage" @if ($currentPage === 1) disabled @endif
                class="w-10 h-10 flex items-center justify-center rounded-lg border border-gray-300 bg-white text-gray-600 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed transition duration-150">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            <!-- Page Numbers -->
            @foreach ($rangeWithDots as $page)
                @if ($page === '...')
                    <button disabled
                        class="w-10 h-10 flex items-center justify-center rounded-lg border border-gray-300 bg-white text-gray-400 cursor-default">
                        ...
                    </button>
                @else
                    <button wire:click="gotoPage({{ $page }})"
                        class="w-10 h-10 flex items-center justify-center rounded-lg font-medium transition duration-150
                        @if ($currentPage === $page) bg-zinc-500 text-white @else border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 @endif">
                        {{ $page }}
                    </button>
                @endif
            @endforeach

            <!-- Next Button -->
            <button wire:click="nextPage" @if ($currentPage === $totalPages) disabled @endif
                class="w-10 h-10 flex items-center justify-center rounded-lg border border-gray-300 bg-white text-gray-600 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed transition duration-150">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>
    </div>

</section>
