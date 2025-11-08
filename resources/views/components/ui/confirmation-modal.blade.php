@props([
    'show' => 'showModal',
    'title' => 'Are you sure?',
    'message' => 'Please confirm your action.',
    'method' => 'confirmAction',
    'buttonText' => 'Confirm',
    'colorBg' => 'zinc',
    'iconColor' => 'red',

    'buttonVariant' => 'danger',
    'iconVariant' => 'outline',
    'iconName' => 'exclamation-triangle',
    'iconClasss' => '',
])

@php
    $buttonBg = [
        'primary' => 'bg-zinc-600 text-white hover:bg-zinc-700',
        'secondary' => 'bg-zinc-400 text-white hover:bg-zinc-500',
        'accent' => 'bg-accent text-white hover:bg-accent-content',
        'success' => 'bg-green-600 text-white hover:bg-green-700',
        'danger' => 'bg-red-600 text-white hover:bg-red-700',
        'warning' => 'bg-yellow-600 text-white hover:bg-yellow-700',
        'info' => 'bg-blue-600 text-white hover:bg-blue-700',
        'dark' => 'bg-black text-white hover:bg-zinc-900 dark:bg-white dark:text-black dark:hover:bg-zinc-100',
        'light' => 'bg-white text-black hover:bg-zinc-100 dark:bg-zinc-900 dark:text-white dark:hover:bg-zinc-800',
    ];

    $iconEffectClass = [
        'primary' => 'bg-zinc-600/30',
        'secondary' => 'bg-zinc-400/30',
        'accent' => 'bg-accent/30',
        'success' => 'bg-green-600/30',
        'danger' => 'bg-red-600/30',
        'warning' => 'bg-yellow-600/30',
        'info' => 'bg-blue-600/30',
        'dark' => 'bg-black/30',
        'light' => 'bg-white/30',
    ];
@endphp

<div x-data="{ localShow: @entangle($show) }">
    <div x-show="localShow" x-cloak x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title"
        role="dialog" aria-modal="true">

        {{-- Backdrop --}}
        <div @click="localShow = false" wire:click="$set('{{ $show }}', false)"
            class="fixed inset-0 bg-gray-900/50"></div>

        {{-- Centering container --}}
        <div class="flex items-center justify-center min-h-screen px-4 py-8">

            {{-- Modal Panel --}}
            <div x-show="localShow" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="relative w-full max-w-md bg-white rounded-2xl shadow-xl overflow-hidden transform transition-all">

                {{-- Close Button --}}
                <div class="absolute top-4 right-4">
                    <button @click="localShow = false" wire:click="$set('{{ $show }}', false)"
                        class="text-gray-400 hover:text-gray-600 transition-colors duration-150 rounded-full p-1 focus:outline-none focus:ring-2 focus:ring-gray-200">
                        <span class="sr-only">Close</span>
                        <flux:icon icon="x-mark" class="w-6 h-6" />
                    </button>
                </div>

                {{-- Modal Content --}}
                <div class="p-8 text-center">
                    <div
                        class="mx-auto flex items-center justify-center h-16 w-16 rounded-full {{ $iconEffectClass[$buttonVariant] }} mb-4">
                        <flux:icon name="{{ $iconName }}" class="w-8 h-8 stroke-red-500 {{ $iconClasss }}" />
                    </div>

                    {{-- Title --}}
                    <h3 class="text-2xl font-bold text-gray-900 mb-2" id="modal-title">
                        {{ $title }}
                    </h3>

                    {{-- Description --}}
                    <p class="text-base text-gray-600 mb-6">
                        {!! $message !!} {{-- Use {!! !!} to allow for bolding or links in the message if needed --}}
                    </p>

                    {{-- Action Buttons --}}
                    <div class="flex flex-col sm:flex-row justify-center gap-3">
                        {{-- Primary Action Button --}}
                        <button wire:click="{{ $method }}" @click="localShow = false"
                            class="w-full sm:w-auto px-6 py-3 rounded-xl {{ $buttonBg[$buttonVariant] }} text-white text-base font-semibold shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 transition duration-150">
                            {{ $buttonText }}
                        </button>

                        {{-- Cancel Button --}}
                        <button wire:click="$set('{{ $show }}', false)" @click="localShow = false"
                            class="w-full sm:w-auto px-6 py-3 rounded-xl bg-white border border-gray-300 text-gray-800 text-base font-semibold shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 transition duration-150">
                            {{ __('Cancel') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
