<div>
    <div class="bg-bg-primary rounded-lg shadow p-6">


        <!-- Video Player Section -->
        <div class="mb-6 pb-4 border-b">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold mb-4">Video Preview</h2>
                <div class="mb-4">
                    <x-ui.button href="{{ route('admin.tiktok-videos') }}" variant="tertiary" class="py-2! px-4">
                        <flux:icon name="arrow-left"
                            class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-tertiary" />
                        <span class="text-text-btn-primary group-hover:text-text-btn-secondary">Back</span>
                    </x-ui.button>
                </div>
            </div>

            <div class="aspect-video max-w-2xl mx-auto bg-black rounded-lg overflow-hidden">
                @if ($data->play_url)
                    <video controls class="w-full h-full" poster="{{ $data->thumbnail_url }}">
                        <source src="{{ $data->play_url }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                @else
                    <div class="flex items-center justify-center h-full text-gray-400">
                        <p>No video available</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Video Details -->
        <div class="mb-6 pb-4 border-b">
            <h2 class="text-2xl font-bold mb-3">{{ $data->title }}</h2>

            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="font-semibold">Video ID:</span>
                    <span class="text-gray-600">{{ $data->video_id }}</span>
                </div>
                <div>
                    <span class="font-semibold">Author:</span>
                    <span class="text-gray-600">{{ $data->author_name }}</span>
                </div>
                <div>
                    <span class="font-semibold">Play Count:</span>
                    <span class="text-gray-600">{{ number_format($data->play_count) }}</span>
                </div>
                <div>
                    <span class="font-semibold">Duration:</span>
                    <span class="text-gray-600">{{ $data->duration }}s</span>
                </div>
            </div>

            @if ($data->desc)
                <div class="mt-3">
                    <span class="font-semibold text-sm">Description:</span>
                    <p class="text-gray-600 text-sm mt-1">{{ $data->desc }}</p>
                </div>
            @endif
        </div>

        <!-- Keywords Selection -->
        <div>
            <label for="keywords" class="block font-semibold text-lg mb-3">
                Select HashTags
            </label>

            <div wire:ignore>
                <select id="keywords" multiple class="w-full border-gray-300 rounded select2" style="width: 100%">
                    @foreach ($keywords as $keyword)
                        <option value="{{ $keyword->id }}" @if (in_array($keyword->id, $selectedKeywords)) selected @endif>
                            {{ $keyword->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Currently Selected Keywords Preview -->
            @if (count($selectedKeywordDetails) > 0)
                <div class="mt-4">
                    <p class="text-sm font-medium text-gray-700 mb-2">
                        Selected Keywords ({{ count($selectedKeywordDetails) }}):
                    </p>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($selectedKeywordDetails as $keyword)
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                                {{ $keyword->name }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Save Button -->
            <div class="flex items-center justify-end gap-4 mt-6">
                <x-ui.button wire:click="resetForm" variant="tertiary" class="w-auto! py-2!">
                    <flux:icon name="x-circle"
                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-tertiary" />
                    <span wire:loading.remove wire:target="resetForm"
                        class="text-text-btn-primary group-hover:text-text-btn-secondary">{{ __('Reset') }}</span>
                    <span wire:loading wire:target="resetForm"
                        class="text-text-btn-primary group-hover:text-text-btn-secondary">{{ __('Reseting...') }}</span>
                </x-ui.button>

                <x-ui.button wire:click="save" class="w-auto! py-2!">
                    <span wire:loading.remove wire:target="save"
                        class="text-text-btn-primary group-hover:text-text-btn-secondary">
                        {{ $hasExistingKeywords ? __('Update') : __('Create') }}
                    </span>
                    <span wire:loading wire:target="save"
                        class="text-text-btn-primary group-hover:text-text-btn-secondary">
                        {{ $hasExistingKeywords ? __('Updating...') : __('Creating...') }}
                    </span>
                </x-ui.button>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function select2Init() {
                $('#keywords').select2({
                    placeholder: 'Select keywords...',
                    allowClear: true
                });

                // Update Livewire when Select2 changes
                $('#keywords').on('change', function(e) {
                    let selectedValues = $(this).val();
                    @this.set('selectedKeywords', selectedValues || []);
                });

                // Listen for reset event
                Livewire.on('reset-select2', (event) => {
                    $('#keywords').val(event.selectedKeywords).trigger('change');
                });

                // Re-initialize Select2 after Livewire updates
                Livewire.hook('morph.updated', ({
                    el,
                    component
                }) => {
                    $('#keywords').select2({
                        placeholder: 'Select keywords...',
                        allowClear: true
                    });
                });
            }
            document.addEventListener('DOMContentLoaded', () => {
                // Initialize Select2
                select2Init();
            });
            document.addEventListener('livewire:navigated', () => {
                // Initialize Select2
                select2Init();
            });
        </script>
    @endpush
</div>
