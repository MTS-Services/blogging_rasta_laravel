<x-frontend::app>
    <div class="max-w-4xl mx-auto py-8">
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl overflow-hidden">
            <!-- Header -->
            <div class="p-6 md:p-8 bg-gradient-to-r from-blue-600 to-blue-700">
                <h2 class="text-2xl md:text-3xl font-bold text-white">{{__('Two-Factor Authentication')}}</h2>
                <p class="text-blue-100 mt-2 text-sm md:text-base">{{__('Secure your account with additional protection')}}</p>
            </div>

            <div class="p-6 md:p-8">
                <!-- Status Messages -->
                @if (session('status') === 'two-factor-authentication-enabled')
                    <div
                        class="mb-6 p-4 bg-green-50 dark:bg-green-950/30 border-l-4 border-green-500 text-green-700 dark:text-green-300 rounded-lg">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <p class="font-semibold">{{__('Two-factor authentication setup is in progress')}}</p>
                        </div>
                    </div>
                @endif

                @if (session('status') === 'two-factor-authentication-confirmed')
                    <div
                        class="mb-6 p-4 bg-green-50 dark:bg-green-950/30 border-l-4 border-green-500 text-green-700 dark:text-green-300 rounded-lg">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <p class="font-semibold">{{__('Two-factor authentication has been confirmed')}}</p>
                        </div>
                    </div>
                @endif

                @if (session('status') === 'two-factor-authentication-disabled')
                    <div
                        class="mb-6 p-4 bg-yellow-50 dark:bg-yellow-950/30 border-l-4 border-yellow-500 text-yellow-700 dark:text-yellow-300 rounded-lg">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <p class="font-semibold">{{__('Two-factor authentication has been disabled')}}</p>
                        </div>
                    </div>
                @endif

                @if (session('status') === 'recovery-codes-generated')
                    <div
                        class="mb-6 p-4 bg-blue-50 dark:bg-blue-950/30 border-l-4 border-blue-500 text-blue-700 dark:text-blue-300 rounded-lg">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <p class="font-semibold">{{__('New recovery codes have been generated!')}}</p>
                        </div>
                    </div>
                @endif

                <!-- Enable/Disable 2FA -->
                @if (!$twoFactorEnabled)
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                        <h3 class="text-xl font-bold mb-4 text-gray-900 dark:text-white">{{__('Enable Two-Factor
                            Authentication')}}</h3>
                        <p class="text-gray-600 dark:text-gray-300 mb-6 leading-relaxed">
                            {{ __('When two-factor authentication is enabled, you will be prompted for a secure, random token
                            during authentication. You may retrieve this token from your phone\'s Google Authenticator,
                            Authy, or any compatible
                            authenticator application.') }}
                        </p>

                        <form method="POST" action="{{ route('user.two-factor.enable') }}">
                            @csrf
                            <x-ui.button type="submit" variant="primary">
                            {{ __('Enable Two-Factor Authentication') }}
                            </x-ui.button>
                        </form>
                    </div>
                @else
                    <!-- QR Code Section -->
                    @if (!auth()->user()->two_factor_confirmed_at)
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-6 mb-8">
                            <h3 class="text-xl font-bold mb-4 text-gray-900 dark:text-white">{{__('Finish Enabling Two-Factor
                                Authentication')}}</h3>

                            <p class="text-gray-600 dark:text-gray-300 mb-6 leading-relaxed">
                                {{ __('Finish enabling two-factor authentication by adding a secure, random token to your
                                phone\'s Google Authenticator, Authy, or any compatible authenticator application.') }}
                            </p>

                            <!-- QR Code Display -->
                            <div
                                class="mb-6 p-6 bg-gray-50 dark:bg-gray-800 rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-600">
                                <div id="qrCode" class="flex justify-center mb-4">
                                    <div class="text-center">
                                        <x-ui.button type="button" variant="primary" onclick="loadQRCode()">
                                            {{ __('Show QR Code') }}
                                        </x-ui.button>
                                    </div>
                                </div>
                                <div id="qrCodeContainer" class="hidden text-center"></div>
                            </div>

                            <!-- Confirm 2FA -->
                            <form method="POST" action="{{ route('user.two-factor.confirm') }}">
                                @csrf

                                <div class="mb-6">
                                    <label for="code"
                                        class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                                        {{ __('Confirm with code from authenticator app') }}
                                    </label>
                                    <input type="text" id="code" name="code"
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900 dark:text-white text-lg font-mono tracking-wider"
                                        placeholder="000000" maxlength="6" required autocomplete="off">
                                </div>

                                @error('code')
                                    <p class="text-red-600 dark:text-red-400 text-sm mb-4">{{ $message }}</p>
                                @enderror

                                <x-ui.button type="submit" variant="tertiary">
                                    {{ __('Confirm & Enable') }}
                                </x-ui.button>
                            </form>
                        </div>
                    @endif

                    <!-- Recovery Codes Section -->
                    @if (auth()->user()->two_factor_confirmed_at)
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-6 mb-8">
                            <h3 class="text-xl font-bold mb-4 text-gray-900 dark:text-white">{{__('Recovery Codes')}}</h3>
                            <p class="text-gray-600 dark:text-gray-300 mb-6 leading-relaxed">
                                {{ __(' Store these recovery codes in a secure password manager. They can be used to recover
                                access to your account if your two-factor authentication device is lost.') }}
                            </p>

                            <div class="flex flex-col sm:flex-row gap-3 mb-6">
                                <x-ui.button type="button" variant="primary" onclick="showRecoveryCodes()"
                                    class="sm:w-auto">
                                    {{ __(' Show Recovery Codes') }}
                                </x-ui.button>

                                <form method="POST" action="{{ route('user.two-factor.recovery-codes.store') }}"
                                    class="inline">
                                    @csrf
                                    <x-ui.button type="submit" variant="tertiary" class="sm:w-auto"
                                        onclick="return confirm('This will invalidate all your old recovery codes. Are you sure?')">
                                        {{ __(' Regenerate Recovery Codes') }}
                                    </x-ui.button>
                                </form>
                            </div>

                            <div id="recoveryCodes" class="hidden mb-4">
                                <div
                                    class="p-6 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl">
                                    <div id="recoveryCodesList"
                                        class="grid grid-cols-1 sm:grid-cols-2 gap-3 font-mono text-sm">
                                        <!-- Codes loaded here via JavaScript -->
                                    </div>
                                </div>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-3 flex items-start">
                                    <span class="mr-1">💡</span>
                                    <span>{{ __('Save these codes in a safe place. Each code can only be used once.') }}</span>
                                </p>
                            </div>
                        </div>
                    @endif

                    <!-- Disable/Cancel 2FA -->
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                        @if (auth()->user()->two_factor_confirmed_at)
                            <h3 class="text-xl font-bold mb-4 text-red-600 dark:text-red-400">{{__('Disable Two-Factor
                                Authentication')}}</h3>
                            <p class="text-gray-600 dark:text-gray-300 mb-6 leading-relaxed">
                                <span class="inline-flex items-center">
                                    <span class="text-lg mr-2">⚠️</span>
                                    <strong>{{__('Warning:')}}</strong>
                                </span>
                                <span class="ml-7 block">{{__('Disabling two-factor authentication will make your account
                                    significantly less secure.')}}</span>
                            </p>

                            <form method="POST" action="{{ route('user.two-factor.disable') }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-600 px-6 py-3 text-white hover:bg-red-700 border border-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 font-semibold text-base w-full sm:w-auto rounded-full flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed transition duration-150 ease-in-out"
                                    onclick="return confirm('Are you sure you want to disable two-factor authentication for your account?')">
                                    {{__('Disable Two-Factor Authentication')}}
                                </button>
                            </form>
                        @else
                            <h3 class="text-xl font-bold mb-4 text-red-600 dark:text-red-400">{{__('Cancel Processing')}}</h3>
                            <p class="text-gray-600 dark:text-gray-300 mb-6 leading-relaxed">
                                <span class="inline-flex items-center">
                                    <span class="text-lg mr-2">⚠️</span>
                                    <strong>{{__('Warning:')}}</strong>
                                </span>
                                <span class="ml-7 block">{{__('Cancel two-factor authentication processing will make your
                                    admin account significantly less secure.')}}</span>
                            </p>

                            <form method="POST" action="{{ route('user.two-factor.disable') }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-600 px-6 py-3 text-white hover:bg-red-700 border border-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 font-semibold text-base w-full sm:w-auto rounded-full flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed transition duration-150 ease-in-out"
                                    onclick="return confirm('Are you sure you want to cancel the setup process?')">
                                    {{ __('Cancel Processing') }}
                                </button>
                            </form>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <!-- Back to Dashboard -->
        <div class="mt-8 text-center">
            <a href="{{ route('user.purchased-orders') }}"
                class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 font-semibold text-sm transition-colors inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                {{ __('Back to Dashboard') }}
            </a>
        </div>
    </div>

    <script>
        function loadQRCode() {
            fetch('{{ route('user.two-factor.qr-code') }}')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('qrCodeContainer').innerHTML = data.svg;
                    document.getElementById('qrCodeContainer').classList.remove('hidden');
                    document.getElementById('qrCode').classList.add('hidden');
                })
                .catch(error => {
                    console.error('Error loading QR code:', error);
                    alert('Failed to load QR code. Please try again.');
                });
        }

        function showRecoveryCodes() {
            fetch('{{ route('user.two-factor.recovery-codes') }}')
                .then(response => response.json())
                .then(codes => {
                    const container = document.getElementById('recoveryCodesList');
                    container.innerHTML = codes.map(code =>
                        `<div class="p-4 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-center font-bold text-gray-900 dark:text-white shadow-sm">${code}</div>`
                    ).join('');
                    document.getElementById('recoveryCodes').classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error loading recovery codes:', error);
                    alert('Failed to load recovery codes. Please try again.');
                });
        }
    </script>
</x-frontend::app>
