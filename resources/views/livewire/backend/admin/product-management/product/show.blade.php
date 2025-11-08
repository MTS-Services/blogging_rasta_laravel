<div>
    {{-- Page Header --}}
    <div class="glass-card rounded-2xl p-4 lg:p-6 mb-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <h2 class="text-xl lg:text-2xl font-bold text-text-black dark:text-text-white">
                {{ __('Product Details') }}
            </h2>
            <div class="flex items-center gap-2 w-full sm:w-auto">
                <x-ui.button href="{{ route('admin.pm.product.edit', $data->id) }}" variant="secondary"
                    class="w-auto py-2!">
                    <flux:icon name="pencil"
                        class="w-4 h-4 stroke-text-btn-secondary group-hover:stroke-text-btn-primary" />
                    {{ __('Edit') }}
                </x-ui.button>

                <x-ui.button href="{{ route('admin.pm.product.index') }}" class="w-auto py-2!">
                    <flux:icon name="arrow-left"
                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                    {{ __('Back') }}
                </x-ui.button>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6 min-h-[500px]">
        <h3 class="text-2xl font-bold mb-4 text-gray-900 dark:text-white">
            {{ $data->title }}
        </h3>

        {{-- Product Images Section --}}
        <div class="mb-8">
            <h2 class="text-2xl font-semibold mb-4">{{ __('Product Images') }}</h2>

            @if ($data->images && $data->images->count() > 0)

                {{-- Primary/Main Image --}}
                @php
                    $primaryImage = $data->images->where('is_primary', true)->first() ?? $data->images->first();
                @endphp

                <div class="mb-6">
                    <h3 class="text-lg font-medium mb-2">{{ __('Primary Image') }}</h3>
                    <div class="overflow-hidden">
                        <img src="{{ asset('storage/' . $primaryImage->image_path) }}" alt="{{ $data->name }}"
                            class="w-auto object-contain bg-gray-100">
                    </div>
                </div>

                {{-- All Images Grid --}}
                @if ($data->images->count() > 1)
                    <div>
                        <h3 class="text-lg font-medium mb-2">{{ __('All Images') }} ({{ $data->images->count() }})
                        </h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach ($data->images->sortBy('sort_order') as $image)
                                <div
                                    class="relative border rounded-lg overflow-hidden hover:shadow-lg transition-shadow">
                                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $data->name }}"
                                        class="w-full h-48 object-cover cursor-pointer"
                                        onclick="showImageModal('{{ asset('storage/' . $image->image_path) }}')">

                                    {{-- Primary Badge --}}
                                    @if ($image->is_primary)
                                        <span
                                            class="absolute top-2 right-2 bg-green-500 text-white text-xs px-2 py-1 rounded">
                                            {{ __('Primary') }}
                                        </span>
                                    @endif

                                    {{-- Sort Order --}}
                                    <div
                                        class="absolute bottom-2 left-2 bg-black bg-opacity-50 text-white text-xs px-2 py-1 rounded">
                                        #{{ $image->sort_order + 1 }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @else
                <div class="text-center py-12 bg-gray-100 rounded-lg">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    <p class="mt-2 text-gray-500">{{ __('No images found for this product.') }}</p>
                </div>
            @endif
        </div>
        {{-- Basic Information Section --}}
        <div class="mb-8">
            <h4
                class="text-lg font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                {{ __('Basic Information') }}
            </h4>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

                {{-- Seller --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">{{ __('Seller') }}</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white">
                        {{ $data->seller?->first_name ?? 'N/A' }}
                    </p>
                </div>

                {{-- Game --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">{{ __('Game') }}</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white">
                        {{ $data->game?->name ?? 'N/A' }}
                    </p>
                </div>

                {{-- Product Type --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">{{ __('Product Type') }}</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white">
                        {{ $data->productType?->name ?? 'N/A' }}
                    </p>
                </div>

                {{-- Slug --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">{{ __('Slug') }}</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white">{{ $data->slug }}</p>
                </div>

                {{-- Server --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">{{ __('Server') }}</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white">
                        {{ $data->server?->name ?? 'N/A' }}
                    </p>
                </div>

                {{-- Platform --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">{{ __('Platform') }}</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white">{{ $data->platform ?? 'N/A' }}</p>
                </div>

                {{-- Region --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">{{ __('Region') }}</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white">{{ $data->region ?? 'N/A' }}</p>
                </div>

                {{-- Status --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">{{ __('Status') }}</p>
                    <span
                        class="px-3 py-1 rounded-full text-xs font-bold inline-block badge badge-soft {{ $data->status->color() }}">
                        {{ $data->status->label() }}
                    </span>
                </div>

            </div>
        </div>

        {{-- Pricing Information Section --}}
        <div class="mb-8">
            <h4
                class="text-lg font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                {{ __('Pricing Information') }}
            </h4>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

                {{-- Price --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">{{ __('Price') }}</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white">
                        {{ number_format($data->price, 2) }} {{ $data->currency }}
                    </p>
                </div>

                {{-- Currency --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">{{ __('Currency') }}</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white uppercase">{{ $data->currency }}
                    </p>
                </div>

                {{-- Discount Percentage --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">{{ __('Discount (%)') }}</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white">
                        {{ $data->discount_percentage ? number_format($data->discount_percentage, 2) . '%' : '0.00%' }}
                    </p>
                </div>

                {{-- Discounted Price --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">{{ __('Discounted Price') }}</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white">
                        {{ $data->discounted_price ? number_format($data->discounted_price, 2) . ' ' . $data->currency : 'N/A' }}
                    </p>
                </div>

            </div>
        </div>

        {{-- Stock & Inventory Section --}}
        <div class="mb-8">
            <h4
                class="text-lg font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                {{ __('Stock & Inventory') }}
            </h4>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

                {{-- Stock Quantity --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">{{ __('Stock Quantity') }}</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white">
                        {{ $data->unlimited_stock ? 'Unlimited' : $data->stock_quantity }}
                    </p>
                </div>

                {{-- Unlimited Stock --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">{{ __('Unlimited Stock') }}</p>
                    <span class="rounded-full text-xs font-bold inline-block">
                        {{ $data->unlimited_stock ? __('Yes') : __('No') }}
                    </span>
                </div>

                {{-- Min Purchase Quantity --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">{{ __('Min Purchase Quantity') }}</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white">{{ $data->min_purchase_quantity }}
                    </p>
                </div>

                {{-- Max Purchase Quantity --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">{{ __('Max Purchase Quantity') }}</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white">
                        {{ $data->max_purchase_quantity ?? 'N/A' }}
                    </p>
                </div>

            </div>
        </div>

        {{-- Delivery Information Section --}}
        <div class="mb-8">
            <h4
                class="text-lg font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                {{ __('Delivery Information') }}
            </h4>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

                {{-- Delivery Method --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">{{ __('Delivery Method') }}</p>
                    <span
                        class="px-3 py-1 rounded-full text-xs font-bold inline-block badge badge-soft {{ $data->delivery_method->color() }}">
                        {{ $data->delivery_method->label() }}
                    </span>
                </div>

                {{-- Delivery Time --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">{{ __('Delivery Time') }}</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white">
                        {{ $data->delivery_time_hours }} {{ __('hours') }}
                    </p>
                </div>

            </div>

            {{-- Auto Delivery Content --}}
            @if ($data->auto_delivery_content)
                <div class="mt-4">
                    <p class="text-gray-500 dark:text-gray-400 mb-2">{{ __('Auto Delivery Content') }}</p>
                    <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-lg">
                        <pre class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $data->auto_delivery_content }}</pre>
                    </div>
                </div>
            @endif
        </div>

        {{-- Sales & Performance Section --}}
        <div class="mb-8">
            <h4
                class="text-lg font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                {{ __('Sales & Performance') }}
            </h4>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

                {{-- Total Sales --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">{{ __('Total Sales') }}</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white">
                        {{ number_format($data->total_sales) }}
                    </p>
                </div>

                {{-- Total Revenue --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">{{ __('Total Revenue') }}</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white">
                        {{ number_format($data->total_revenue, 2) }} {{ $data->currency }}
                    </p>
                </div>

                {{-- View Count --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">{{ __('View Count') }}</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white">
                        {{ number_format($data->view_count) }}
                    </p>
                </div>

                {{-- Favorite Count --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">{{ __('Favorite Count') }}</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white">
                        {{ number_format($data->favorite_count) }}
                    </p>
                </div>

                {{-- Average Rating --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">{{ __('Average Rating') }}</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white">
                        {{ number_format($data->average_rating, 2) }} / 5.00
                    </p>
                </div>

                {{-- Total Reviews --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">{{ __('Total Reviews') }}</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white">
                        {{ number_format($data->total_reviews) }}
                    </p>
                </div>

            </div>
        </div>

        {{-- Visibility & Features Section --}}
        <div class="mb-8">
            <h4
                class="text-lg font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                {{ __('Visibility & Features') }}
            </h4>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

                {{-- Visibility --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">{{ __('Visibility') }}</p>
                    <span
                        class="px-3 py-1 rounded-full text-xs font-bold inline-block badge badge-soft {{ $data->visibility->color() }}">
                        {{ $data->visibility->label() }}
                    </span>
                </div>

                {{-- Is Featured --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">{{ __('Is Featured') }}</p>
                    <span class="rounded-full text-xs font-bold inline-block">
                        {{ $data->is_featured ? __('Yes') : __('No') }}
                    </span>
                </div>

                {{-- Is Hot Deal --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">{{ __('Is Hot Deal') }}</p>
                    <span class="rounded-full text-xs font-bold inline-block">
                        {{ $data->is_hot_deal ? __('Yes') : __('No') }}
                    </span>
                </div>

            </div>
        </div>

        {{-- Review Information Section --}}
        <div class="mb-8">
            <h4
                class="text-lg font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                {{ __('Review Information') }}
            </h4>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

                {{-- Reviewed By --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">{{ __('Reviewed By') }}</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white">
                        {{ $data->reviewer?->name ?? 'N/A' }}
                    </p>
                </div>

                {{-- Reviewed At --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">{{ __('Reviewed At') }}</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white">
                        {{ $data->reviewed_at ? $data->reviewed_at->format('Y-m-d H:i:s') : 'N/A' }}
                    </p>
                </div>

            </div>

            {{-- Rejection Reason --}}
            @if ($data->rejection_reason)
                <div class="mt-4">
                    <p class="text-gray-500 dark:text-gray-400 mb-2">{{ __('Rejection Reason') }}</p>
                    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 p-4 rounded-lg">
                        <p class="text-sm text-red-700 dark:text-red-300">{{ $data->rejection_reason }}</p>
                    </div>
                </div>
            @endif
        </div>

        {{-- SEO Information Section --}}
        <div class="mb-8">
            <h4
                class="text-lg font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                {{ __('SEO Information') }}
            </h4>
            <div class="space-y-4">

                {{-- Meta Title --}}
                <div>
                    <p class="text-gray-500 dark:text-gray-400 mb-1">{{ __('Meta Title') }}</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white">
                        {{ $data->meta_title ?? 'N/A' }}
                    </p>
                </div>

                {{-- Meta Description --}}
                @if ($data->meta_description)
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 mb-1">{{ __('Meta Description') }}</p>
                        <p class="text-gray-700 dark:text-gray-300">{{ $data->meta_description }}</p>
                    </div>
                @endif

                {{-- Meta Keywords --}}
                @if ($data->meta_keywords)
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 mb-1">{{ __('Meta Keywords') }}</p>
                        <p class="text-gray-700 dark:text-gray-300">{{ $data->meta_keywords }}</p>
                    </div>
                @endif

            </div>
        </div>

        {{-- Specifications Section --}}
        @if ($data->specifications)
            <div class="mb-8">
                <h4
                    class="text-lg font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                    {{ __('Specifications') }}
                </h4>
                <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-lg">
                    <pre class="text-sm text-gray-700 dark:text-gray-300">{{ json_encode($data->specifications, JSON_PRETTY_PRINT) }}</pre>
                </div>
            </div>
        @endif

        {{-- Requirements Section --}}
        @if ($data->requirements)
            <div class="mb-8">
                <h4
                    class="text-lg font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                    {{ __('Requirements') }}
                </h4>
                <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-lg">
                    <pre class="text-sm text-gray-700 dark:text-gray-300">{{ json_encode($data->requirements, JSON_PRETTY_PRINT) }}</pre>
                </div>
            </div>
        @endif

        {{-- Audit Information Section --}}
        <div class="mb-8">
            <h4
                class="text-lg font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                {{ __('Audit Information') }}
            </h4>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

                {{-- Created Date --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">{{ __('Created Date') }}</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white uppercase">
                        {{ $data->created_at_formatted }}
                    </p>
                </div>

                {{-- Updated Date --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">{{ __('Updated Date') }}</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white uppercase">
                        {{ $data->updated_at_formatted ?? 'N/A' }}
                    </p>
                </div>

                {{-- Deleted Date --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">{{ __('Deleted Date') }}</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white uppercase">
                        {{ $data->deleted_at_formatted ?? 'N/A' }}
                    </p>
                </div>

                {{-- Restored Date --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">{{ __('Restored Date') }}</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white uppercase">
                        {{ $data->restored_at ? $data->restored_at->format('Y-m-d H:i:s') : 'N/A' }}
                    </p>
                </div>

                {{-- Created By Type --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">{{ __('Created By Type') }}</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white uppercase">
                        {{ $data->created_by_type ?? 'N/A' }}
                    </p>
                </div>

                {{-- Updated By Type --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">{{ __('Updated By Type') }}</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white uppercase">
                        {{ $data->updated_by_type ?? 'N/A' }}
                    </p>
                </div>

                {{-- Deleted By Type --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">{{ __('Deleted By Type') }}</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white uppercase">
                        {{ $data->deleted_by_type ?? 'N/A' }}
                    </p>
                </div>

            </div>
        </div>

        {{-- Description Section --}}
        @if ($data->description)
            <div class="mb-8">
                <h4
                    class="text-lg font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                    {{ __('Description') }}
                </h4>
                <div class="prose dark:prose-invert max-w-none text-gray-700 dark:text-gray-300">
                    {!! $data->description !!}
                </div>
            </div>
        @endif
    </div>
</div>
