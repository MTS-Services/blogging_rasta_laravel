<section>
    <div class="glass-card rounded-2xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-text-black dark:text-text-white">{{ __('Game View') }}</h2>
            <div class="flex items-center gap-2">
                {{-- <x-ui.button href="{{ route('admin.am.admin.trash') }}" type='secondary'>
                    <flux:icon name="trash" class="w-4 h-4 stroke-white" />
                    {{ __('Trash') }}
                </x-ui.button> --}}
                {{-- <x-ui.button href="{{ route('admin.am.admin.create') }}">
                    <flux:icon name="user-plus" class="w-4 h-4 stroke-white" />
                    {{ __('Add') }}
                </x-ui.button>  --}}
                <x-ui.button href="{{ route('admin.gm.game.index') }}" type='accent'>
                    <flux:icon name="arrow-left" class="w-4 h-4 stroke-white" />
                    {{ __('Back') }}
                </x-ui.button>
            </div>
        </div>
    </div>

    <div class=" mx-auto mt-10 bg-white shadow glass-card rounded-2xl p-6 ">
        <!-- Profile Header -->
        {{-- <div class="flex flex-col md:flex-row md:items-center md:justify-between border-b pb-6 mb-6">
            <div class="flex items-center space-x-4">
                <img src="{{ $existingAvatar ?? '' }}" alt="Profile" class="w-24 h-24 rounded-full object-cover">
                <div>
                    <h2 class="text-2xl font-semibold">{{ $admin->name }}</h2>
                    <p class="text-sm text-gray-500">{{ $admin->email }}</p>
                    <p class="text-sm text-gray-500 mt-1"><i class="fa-solid fa-location-dot mr-1"></i>
                        {{ $admin->address }}</p>
                </div>
            </div>


        </div> --}}

        <!-- Profile Info -->
        <div class="grid md:grid-cols-2 gap-6 mx-auto">


            <div class="glass-card rounded-xl border border-gray-200 overflow-hidden">
                <table class="w-full text-sm">
                    <tbody class="divide-y divide-gray-200">
                        <tr class="hover:bg-white transition-colors">
                            <td class="p-4 w-2/5 text-gray-600 font-semibold">{{ __('Game Name') }}</td>
                            <td class="p-4 text-gray-900">{{ $game->name }}</td>
                        </tr>
                        <tr class="hover:bg-white transition-colors">
                            <td class="p-4 w-2/5 text-gray-600 font-semibold">{{ __('Category Name') }}</td>
                            <td class="p-4 text-gray-900">{{ $game->category->name ?? 'No Category' }}</td>
                        </tr>
                        <tr class="hover:bg-white transition-colors">
                            <td class="p-4 text-gray-600 font-semibold">{{ __('Slug') }}</td>
                            <td class="p-4 text-gray-900">{{ '/' . $game->slug }}</td>
                        </tr>
                        <tr class="hover:bg-white transition-colors">
                            <td class="p-4 text-gray-600 font-semibold">{{ __('Developer') }}</td>
                            <td class="p-4 text-gray-900">{{ $game->developer ?? 'N/A' }}</td>
                        </tr>
                        <tr class="hover:bg-white transition-colors">
                            <td class="p-4 text-gray-600 font-semibold">{{ __('Publisher') }}</td>
                            <td class="p-4 text-gray-900">{{ $game->publisher ?? 'N/A' }}</td>
                        </tr>
                        <tr class="hover:bg-white transition-colors">
                            <td class="p-4 text-gray-600 font-semibold">{{ __('Trending') }}</td>
                            <td class="p-4 text-gray-900">{{ $game->is_trending ? 'Trending' : 'Not Trending' }}</td>
                        </tr>
                        <tr class="hover:bg-white transition-colors">
                            <td class="p-4 text-gray-600 font-semibold">{{ __('Featured') }}</td>
                            <td class="p-4 text-gray-900">{{ $game->is_featured ? 'Featured' : 'Not Featured' }}</td>
                        </tr>
                        <tr class="hover:bg-white transition-colors">
                            <td class="p-4 w-2/5 text-gray-600 font-semibold">{{ __('Game Description') }}</td>
                            <td class="p-4 text-gray-900">{{ $game->Description ?? 'N/A' }}</td>
                        </tr>





                        <tr class="hover:bg-white transition-colors">
                            <td class="p-4 text-gray-600 font-semibold">{{ __('Status') }}</td>
                            <td class="p-4">
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $data->status->color() ?? ' bg-blue-100'}} text-blue-800">
                                    {{ $data->status->label() }}
                                </span>
                            </td>
                        </tr>
                        <tr class="hover:bg-white transition-colors">
                            <td class="p-4 w-2/5 text-gray-600 font-semibold">{{ __('Created By') }}</td>
                            <td class="p-4 text-gray-900">{{ $game->creater_admin->name ?? 'System' }}</td>
                        </tr>

                        <tr class="hover:bg-white transition-colors">
                            <td class="p-4 text-gray-600 font-semibold">{{ __('Created At') }}</td>
                            <td class="p-4 text-gray-900">{{ $game->created_at_formatted }}</td>
                        </tr>
                        @if ($data->updated_by)
                            <tr class="hover:bg-white transition-colors">
                                <td class="p-4 w-2/5 text-gray-600 font-semibold">{{ __('Updated By') }}</td>
                                <td class="p-4 text-gray-900">{{ $game->updater_admin->name }}</td>

                            </tr>
                            <tr class="hover:bg-white transition-colors">
                                <td class="p-4 w-2/5 text-gray-600 font-semibold">{{ __('Updated At') }}</td>
                                <td class="p-4 text-gray-900">{{ $game->updated_at_formatted }}</td>

                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>


            <div class="glass-card rounded-xl border border-gray-200 overflow-hidden">
                <table class="w-full text-sm">
                    <tbody class="divide-y divide-gray-200">

                        <tr class="hover:bg-white transition-colors">
                            <td class="p-4 w-2/5 text-gray-600 font-semibold">{{ __('Released Date') }}</td>
                            <td class="p-4 text-gray-900">{{ $game->release_date ?? 'N/A' }}</td>
                        </tr>
                        <tr class="hover:bg-white transition-colors">
                            <td class="p-4 w-2/5 text-gray-600 font-semibold">{{ __('Platform') }}</td>
                            <td class="p-4 text-gray-900">{{ $game->platfrom ?? 'N/A' }}</td>
                        </tr>

                        <tr class="hover:bg-white transition-colors">
                            <td class="p-4 w-2/5 text-gray-600 font-semibold">{{ __('Meta Title') }}</td>
                            <td class="p-4 text-gray-900">{{ $game->meta_title ?? 'N/A' }}</td>
                        </tr>
                        <tr class="hover:bg-white transition-colors">
                            <td class="p-4 w-2/5 text-gray-600 font-semibold">{{ __('Meta Description') }}</td>
                            <td class="p-4 text-gray-900">{{ $game->meta_description ?? 'N/A' }}</td>
                        </tr>

                        <tr class="hover:bg-white transition-colors">
                            <td class="p-4 w-2/5 text-gray-600 font-semibold">{{ __('Meta Keywords') }}</td>
                            <td class="p-4 text-gray-900">{{ $game->meta_keywords ?? 'N/A' }}</td>
                        </tr>

                        <tr class="hover:bg-white transition-colors">
                            <td class="p-4 w-2/5 text-gray-600 font-semibold">{{ __('Meta Keywords') }}</td>
                            <td class="p-4 text-gray-900">{{ $game->meta_keywords ?? 'N/A' }}</td>
                        </tr>
                        <tr class="hover:bg-white transition-colors">
                            <td class="p-4 w-2/5 text-gray-600 font-semibold">{{ __('Logo') }}</td>
                            <td class="p-4 text-gray-900">
                                @if ($game->logo)
                                    <img src="{{ asset('/storage/' . $game->logo) }}" alt="{{ $game->name }}"
                                        class="w-16 h-16 object-cover">
                                @else
                                    {{ __('N/A') }}
                                @endif
                            </td>
                        </tr>
                        <tr class="hover:bg-white transition-colors">
                            <td class="p-4 w-2/5 text-gray-600 font-semibold">{{ __('Banner') }}</td>
                            <td class="p-4 text-gray-900">
                                @if ($game->banner)
                                    <img src="{{ asset('/storage/' . $game->banner) }}" alt="{{ $game->name }}"
                                        class="w-16 h-16 object-cover">
                                @else
                                    {{ __('N/A') }}
                                @endif
                            </td>
                        </tr>
                        <tr class="hover:bg-white transition-colors">
                            <td class="p-4 w-2/5 text-gray-600 font-semibold">{{ __('Thumbnail') }} </td>
                            <td class="p-4 text-gray-900">
                                @if ($game->thumbnail)
                                    <img src="{{ asset('/storage/' . $game->thumbnail) }}" alt="{{ $game->name }}"
                                        class="w-16 h-16 object-cover">
                                @else
                                    {{ __('N/A') }}
                                @endif
                            </td>
                        </tr>

                        @if ($data->updated_by)
                            <tr class="hover:bg-white transition-colors">
                                <td class="p-4 w-2/5 text-gray-600 font-semibold">{{__('Updated By')}}</td>
                                <td class="p-4 text-gray-900">{{ $game->updater_admin->name }}</td>

                            </tr>
                            <tr class="hover:bg-white transition-colors">
                                <td class="p-4 w-2/5 text-gray-600 font-semibold">{{__('Updated At')}}</td>
                                <td class="p-4 text-gray-900">{{ $game->updated_at_formatted }}</td>

                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>


        </div>


    </div>


</section>
