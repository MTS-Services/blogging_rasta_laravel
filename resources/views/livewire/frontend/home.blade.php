    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/css/ckEditor.css') }}">
    @endpush
    <section class="flex items-center justify-center min-h-screen p-4 sm:p-6 flex-col">
        <div class="w-full max-w-4xl mx-auto bg-white rounded-xl shadow-2xl p-6 md:p-10">
            <!-- Header -->
            <h2 class="text-3xl font-extrabold text-center text-gray-900 mb-8">
                Welcome to <span class="text-indigo-600">{{ site_name() }}</span>
            </h2>

            <!-- Portals Container (Responsive Flex/Grid) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-5 pt-5">

                <!-- 1. Seller / Buyer Portal Card -->
                <div
                    class="flex flex-col items-center justify-between p-8 bg-gray-50 border border-gray-200 rounded-xl transition duration-300 ease-in-out hover:shadow-lg hover:border-indigo-400">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Seller / Buyer Portal</h3>

                    <div class="flex items-center justify-center space-x-4">
                        @auth('web')
                            <a href="{{ route('user.profile') }}" wire:navigate
                                class="px-6 py-3 bg-indigo-600 text-white font-medium rounded-lg shadow-md hover:bg-indigo-700 transition duration-150 transform hover:scale-105">
                                Go to Profile
                            </a>
                        @else
                            <a href="{{ route('login') }}" wire:navigate
                                class="px-5 py-3 border border-indigo-600 text-indigo-600 font-medium rounded-lg hover:bg-indigo-50 transition duration-150">
                                Login
                            </a>
                            <a href="{{ route('register') }}" wire:navigate
                                class="px-5 py-3 bg-indigo-600 text-white font-medium rounded-lg shadow-md hover:bg-indigo-700 transition duration-150">
                                Register
                            </a>
                        @endauth
                    </div>
                </div>

                <!-- 2. Administrator Portal Card -->
                <div
                    class="flex flex-col items-center justify-between p-8 bg-gray-50 border border-gray-200 rounded-xl transition duration-300 ease-in-out hover:shadow-lg hover:border-teal-400">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Administrator Portal</h3>

                    <div class="flex items-center justify-center space-x-4">
                        @auth('admin')
                            <a href="{{ route('admin.dashboard') }}" wire:navigate
                                class="px-6 py-3 bg-teal-600 text-white font-medium rounded-lg shadow-md hover:bg-teal-700 transition duration-150 transform hover:scale-105">
                                Go to Dashboard
                            </a>
                        @else
                            <a href="{{ route('admin.login') }}" wire:navigate
                                class="px-6 py-3 border border-teal-600 text-teal-600 font-medium rounded-lg hover:bg-teal-50 transition duration-150 transform hover:scale-105">
                                Login
                            </a>
                        @endauth
                    </div>
                </div>

            </div>
        </div>

        <div class="w-full max-w-4xl mx-auto bg-white rounded-xl shadow-2xl p-6 md:p-10 mt-10">
            <h2 class="text-3xl font-extrabold text-center text-gray-900 mb-8">
                Explore UI's
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-5">
                <div
                    class="flex flex-col items-center justify-between p-8 bg-gray-50 border border-gray-200 rounded-xl transition duration-300 ease-in-out hover:shadow-lg hover:border-indigo-400 gap-2 mt-4">
                    <h4 class="text-xl font-semibold text-gray-800">Inputs</h4>
                    <div class="w-full">
                        <x-ui.label value="Standard Input" class="mb-1" />
                        <x-ui.input placeholder="Standard Input" wire:model="input" />
                        <x-ui.input-error :messages="$errors->get('input')" />
                    </div>
                    <div class="w-full">
                        <x-ui.label value="Email Input" class="mb-1" />
                        <x-ui.input type="email" placeholder="Email Input" wire:model="email" />
                        <x-ui.input-error :messages="$errors->get('email')" />
                    </div>
                    <div class="w-full">
                        <x-ui.label value="Password Input" class="mb-1" />
                        <x-ui.input type="password" placeholder="Password Input" wire:model="password" />
                        <x-ui.input-error :messages="$errors->get('password')" />
                    </div>
                    <div class="w-full">
                        <x-ui.label value="Disabled Input" class="mb-1" />
                        <x-ui.input disabled="true" placeholder="Disabled Input" wire:model="disabled" />
                        <x-ui.input-error :messages="$errors->get('disabled')" />
                    </div>
                </div>
                <div
                    class="flex flex-col items-center justify-between p-8 bg-gray-50 border border-gray-200 rounded-xl transition duration-300 ease-in-out hover:shadow-lg hover:border-indigo-400 gap-2 mt-4 h-fit">
                    <h4 class="text-xl font-semibold text-gray-800">Selects</h4>
                    <div class="w-full">
                        <x-ui.label value="Standard Select" class="mb-1" />
                        <x-ui.select wire:model="standardSelect">
                            <option value="">Choose an option</option>
                            <option value="option1">Option 1</option>
                            <option value="option2">Option 2</option>
                            <option value="option3">Option 3</option>
                        </x-ui.select>
                        <x-ui.input-error :messages="$errors->get('standardSelect')" />
                    </div>
                    <div class="w-full">
                        <x-ui.label value="Disabled Select" class="mb-1" />
                        <x-ui.select disabled="true" wire:model="disabledSelect">
                            <option value="">Choose an option</option>
                            <option value="option1">Option 1</option>
                            <option value="option2">Option 2</option>
                            <option value="option3">Option 3</option>
                        </x-ui.select>
                        <x-ui.input-error :messages="$errors->get('disabledSelect')" />
                    </div>
                    <div class="w-full">
                        <x-ui.label value="Select 2 Single" class="mb-1" />
                        <x-ui.select class="select2" wire:model="select2Single">
                            <option value="">Choose an option</option>
                            <option value="option1">Option 1</option>
                            <option value="option2">Option 2</option>
                            <option value="option3">Option 3</option>
                            <option value="option4">Option 4</option>
                            <option value="option5">Option 5</option>
                            <option value="option6">Option 6</option>
                            <option value="option7">Option 7</option>
                            <option value="option8">Option 8</option>
                            <option value="option9">Option 9</option>
                            <option value="option10">Option 10</option>
                            <option value="option11">Option 11</option>
                            <option value="option12">Option 12</option>
                            <option value="option13">Option 13</option>
                            <option value="option14">Option 14</option>
                            <option value="option15">Option 15</option>
                        </x-ui.select>
                        <x-ui.input-error :messages="$errors->get('select2Single')" />
                    </div>
                    <div class="w-full">
                        <x-ui.label value="Select 2 Multiple" class="mb-1" />
                        <x-ui.select class="select2" wire:model="select2Multiple" multiple>
                            <option value="">Choose an option</option>
                            <option value="option1">Option 1</option>
                            <option value="option2">Option 2</option>
                            <option value="option3">Option 3</option>
                            <option value="option4">Option 4</option>
                            <option value="option5">Option 5</option>
                            <option value="option6">Option 6</option>
                            <option value="option7">Option 7</option>
                            <option value="option8">Option 8</option>
                            <option value="option9">Option 9</option>
                            <option value="option10">Option 10</option>
                            <option value="option11">Option 11</option>
                            <option value="option12">Option 12</option>
                            <option value="option13">Option 13</option>
                            <option value="option14">Option 14</option>
                            <option value="option15">Option 15</option>
                        </x-ui.select>
                        <x-ui.input-error :messages="$errors->get('select2Multiple')" />
                    </div>
                </div>
                {{-- <div
                    class="flex flex-col items-center justify-between p-8 bg-gray-50 border border-gray-200 rounded-xl transition duration-300 ease-in-out hover:shadow-lg hover:border-indigo-400 gap-2 mt-4 h-fit col-span-2">
                    <h4 class="text-xl font-semibold text-gray-800">Text areas</h4>
                    <form class="w-full" wire:submit.prevent="saveContent">
                        <x-ui.label value="Standard Select" class="mb-1" />
                        <div wire:ignore>
                            <textarea id="content-{{ $this->getId() }}" class="tinymce-editor">{{ $content }}</textarea>
                        </div>

                        <x-ui.input-error :messages="$errors->get('content')" />
                        <button type="submit" class="btn btn-primary mt-4">
                            Save Content
                        </button>
                    </form>
                </div> --}}
                <div
                    class="flex flex-col items-center justify-between p-8 bg-gray-50 border border-gray-200 rounded-xl transition duration-300 ease-in-out hover:shadow-lg hover:border-indigo-400 gap-2 mt-4 h-fit col-span-2">
                    <h4 class="text-xl font-semibold text-gray-800">Text areas</h4>
                    <form class="w-full" wire:submit.prevent="saveContent2">
                        <x-ui.label value="Standard Select" class="mb-1" />
                        <x-ui.text-editor id="description" placeholder="Enter your main content here..."
                            :height="350" />

                        <x-ui.input-error :messages="$errors->get('content')" />
                        <button type="submit" class="btn btn-primary mt-4">
                            Save Content
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
