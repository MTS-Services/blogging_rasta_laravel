<div class="max-w-7xl mx-auto p-6 space-y-8">
    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/css/ckEditor.css') }}">
    @endpush
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-bg-secondary rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold mb-4">{{ __('Example 1: Simple Usage') }}</h2>
        <form wire:submit.prevent="saveSimple">
            <livewire:ui.text-areat wire:model="simpleContent" label="{{ __('Content') }}" :required="true" :error="$errors->first('simpleContent')" />
            <button type="submit" class="mt-4 px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                {{ __('Save Simple Content') }}
            </button>
        </form>
    </div>

    <div class="bg-bg-secondary rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold mb-4">{{ __('Example 2: With Validation') }}</h2>
        <form wire:submit.prevent="saveArticle">
            <livewire:ui.text-areat wire:model="articleContent" label="{{ __('Article Content') }}"
                placeholder="{{ __('Write your article here...') }}" :height="500" :required="true" :error="$errors->first('articleContent')" />
            <button type="submit" class="mt-4 px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                {{ __('Save Article') }}
            </button>
        </form>
    </div>

    <div class="bg-bg-secondary rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold mb-4">{{ __('Example 3: Multiple Editors') }}</h2>
        <form wire:submit.prevent="saveMultiple">
            <div class="space-y-4">
                <livewire:ui.text-areat wire:model="description" label="{{ __('Description') }}" :height="200" :required="true"
                    :error="$errors->first('description')" />

                <livewire:ui.text-areat wire:model="details" label="{{ __('Details') }}" :height="300" :required="true"
                    :error="$errors->first('details')" />
            </div>
            <button type="submit" class="mt-4 px-6 py-2 bg-purple-600 text-white rounded hover:bg-purple-700">
                {{ __('Save Both') }}
            </button>
        </form>
    </div>

    <div class="bg-bg-secondary rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold mb-4">{{ __('Example 4: Custom Configuration') }}</h2>
        <form wire:submit.prevent="updateExisting">
            <livewire:ui.text-areat wire:model="existingContent" label="{{ __('Advanced Editor') }}"
                placeholder="{{ __('Type something amazing...') }}" :height="600"
                plugins="code table lists link image media preview fullscreen searchreplace wordcount"
                toolbar="undo redo | formatselect | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | code fullscreen | searchreplace"
                :menubar="true" :required="true" :error="$errors->first('existingContent')" />
            <button type="submit" class="mt-4 px-6 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                {{ __('Update Content') }}
            </button>
        </form>
    </div>

    {{-- <div class="bg-bg-secondary rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold mb-4">{{ __('Example 5: Read-only Preview') }}</h2>
        <livewire:ui.text-areat
            :value="existingContent"
            label="{{ __('Preview Mode') }}"
            :readonly="true"
            :height="300"
        />
    </div> --}}



    <div class="bg-bg-secondary rounded-lg shadow-md p-6">
        <form wire:submit="saveContent">
            {{-- First Editor --}}
            <div class="mb-6">
                <label class="block text-sm font-medium text-text-tertiary mb-2">
                    {{ __('Main Content *') }}
                </label>

                <x-ui.text-editor model="content1" id="text-editor-main-content"
                    placeholder="{{ __('Enter your main content here...') }}" :height="250" />

                <x-tiny-editor model="content1" id="editor-main-content" placeholder="{{ __('Enter your main content here...') }}"
                    :height="250" />

                @error('content1')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            {{-- Second Editor --}}
            <div class="mb-6">
                <label class="block text-sm font-medium text-text-tertiary mb-2">
                    {{ __('Additional Content *') }}
                </label>

                <x-tiny-editor model="content2" id="editor-additional-content" placeholder="{{ __('Enter additional content...') }}"
                    :height="200" />

                @error('content2')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            {{-- Third Editor (Optional/Smaller) --}}
            <div class="mb-6">
                <label class="block text-sm font-medium text-text-tertiary mb-2">
                    {{ __('Description (Optional)') }}
                </label>

                <x-tiny-editor model="description" id="editor-description" placeholder="{{ __('Enter a brief description...') }}"
                    :height="150" />

                @error('description')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            {{-- Submit Button --}}
            <div class="flex justify-end">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition-colors duration-200"
                    wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="saveContent">{{ __('Save Content') }}</span>
                    <span wire:loading wire:target="saveContent">{{ __('Saving...') }}</span>
                </button>
            </div>
        </form>
    </div>
</div>
