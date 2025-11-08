<x-admin::app>
    <x-slot name="pageSlug">{{__('two-factor')}}</x-slot>
    <x-slot name="breadcrumb">{{__('Two-Factor Authentication')}}</x-slot>
    <x-slot name="title">{{__('Two-Factor Authentication')}}</x-slot>

    <div class="max-w-4xl  mx-auto py-8">
        <div class="glass-card min-h-[50vh] rounded-lg overflow-hidden">
            <!-- Header -->
            <div class="p-6 bg-gradient-to-r from-zinc-600 to-zinc-700">
                <h2 class="text-2xl font-bold text-text-btn-primary">{{__('Two-Factor Authentication')}}</h2>
                <p class="text-zinc-100 mt-1">{{__('Secure your account with additional protection')}}</p>
            </div>

            <div class="p-6">
                <!-- Status Messages -->
                @if (session('status') === 'two-factor-authentication-enabled')
                    <div
                        class="mb-6 p-4 bg-zinc-100 dark:bg-zinc-800/50 border-l-4 border-zinc-500 text-text-primary rounded">
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
                        class="mb-6 p-4 bg-zinc-100 dark:bg-zinc-800/50 border-l-4 border-zinc-500 text-text-primary rounded">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <p class="font-semibold">{{__('Two-factor authentication confirmed successfully!')}}</p>
                        </div>
                    </div>
                @endif

                @if (session('status') === 'two-factor-authentication-disabled')
                    <div
                        class="mb-6 p-4 bg-pink-100 dark:bg-pink-900/30 border-l-4 border-pink-500 text-text-primary rounded">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <p class="font-semibold">{{__('Two-factor authentication has been disabled.')}}</p>
                        </div>
                    </div>
                @endif

                @if (session('status') === 'recovery-codes-generated')
                    <div
                        class="mb-6 p-4 bg-zinc-100 dark:bg-zinc-800/50 border-l-4 border-zinc-500 text-text-primary rounded">
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
                    <div class="border-t border-text-muted/20 pt-6">
                        <h3 class="text-lg font-semibold mb-4">{{__('Enable Two-Factor Authentication')}}</h3>
                        <p class="text-text-secondary mb-6">
                        {{ __('When two-factor authentication is enabled, you will be prompted for a secure, random token
                            during authentication.
                            You may retrieve this token from your phone\'s Google Authenticator, Authy, or any compatible
                            authenticator application.') }}
                        </p>

                        <form method="POST" action="{{ route('admin.two-factor.enable') }}">
                            @csrf
                            {{-- <x-ui.button class="w-auto py-2!" type="submit" variant="primary">
                                Enable Two-Factor Authentication
                            </x-ui.button> --}}
                            <button type="submit"
                                class="px-6 py-3 bg-zinc-600 text-white font-semibold rounded-md hover:bg-zinc-700 transition duration-200">
                                {{ __('Enable Two-Factor Authentication') }}
                            </button>
                        </form>
                    </div>
                @else
                    <!-- QR Code Section -->
                    @if (!auth()->guard('admin')->user()->two_factor_confirmed_at)
                        <div class="border-t border-text-muted/20 pt-6 mb-6">
                            <h3 class="text-lg font-semibold mb-4">{{__('Finish Enabling Two-Factor Authentication')}}</h3>

                            <p class="text-text-secondary mb-4">
                                {{ __('To finish enabling two-factor authentication, scan the following QR code using your
                                phone\'s authenticator application
                                or enter the setup key and provide the generated OTP code.') }}
                            </p>

                            <!-- QR Code Display -->
                            <div
                                class="mb-6 p-6 bg-bg-secondary rounded-lg border-2 border-dashed border-zinc-300 dark:border-zinc-700">
                                <div id="qrCode" class="flex justify-center mb-4">
                                    <div class="text-center">
                                        <x-ui.button class="w-auto py-2!" type="button" onclick="loadQRCode()"
                                            variant="primary">
                                            {{ __('Show QR Code') }}
                                        </x-ui.button>
                                        {{-- <button type="button" onclick="loadQRCode()"
                                            class="px-6 py-3 bg-blue-600 text-white font-semibold rounded hover:bg-blue-700 transition">
                                            Show QR Code
                                        </button> --}}
                                    </div>
                                </div>
                                <div id="qrCodeContainer" class="hidden text-center"></div>
                            </div>

                            <!-- Confirm 2FA -->
                            <form method="POST" action="{{ route('admin.two-factor.confirm') }}">
                                @csrf

                                <div class="mb-4">
                                    <label for="code" class="block text-sm font-medium text-text-primary mb-2">
                                        {{ __('Confirm with code from authenticator app') }}
                                    </label>
                                    <input type="text" id="code" name="code"
                                        class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-700 rounded-md bg-bg-primary text-text-primary focus:ring-2 focus:ring-accent focus:ring-offset-2 focus:ring-offset-accent-foreground"
                                        placeholder="000000" maxlength="6" requipink>
                                </div>

                                @error('code')
                                    <p class="text-pink-600 text-sm mb-4">{{ $message }}</p>
                                @enderror

                                {{-- <x-ui.button class="w-auto py-2!" type="submit" variant="tertiary">
                                    Confirm & Enable
                                </x-ui.button> --}}
                                <button type="submit"
                                    class="px-6 py-2 bg-green-600 text-white font-semibold rounded-md hover:bg-green-700 transition duration-200">
                                    {{ __('Confirm & Enable') }}
                                </button>
                            </form>
                        </div>
                    @endif

                    <!-- Recovery Codes Section -->
                    @if (auth()->guard('admin')->user()->two_factor_confirmed_at)
                        <div class="border-t border-text-muted/20 pt-6 mb-6">
                            <h3 class="text-lg font-semibold mb-4">{{__('Recovery Codes')}}</h3>
                            <p class="text-text-secondary mb-4">
                                {{ __('Store these recovery codes in a secure password manager. They can be used to recover
                                access to your account
                                if your two-factor authentication device is lost.') }}
                            </p>

                            <x-ui.button class="w-auto py-2! mb-4" type="button" onclick="showRecoveryCodes()"
                                variant="primary">
                                {{ __('Show Recovery Codes') }}
                            </x-ui.button>

                            <div id="recoveryCodes" class="hidden mb-4">
                                <div class="p-4 bg-bg-secondary border border-zinc-200 dark:border-zinc-700 rounded-lg">
                                    <div id="recoveryCodesList"
                                        class="grid grid-cols-1 md:grid-cols-2 gap-2 font-mono text-sm">
                                        <!-- Codes loaded here via JavaScript -->
                                    </div>
                                </div>
                                <p class="text-sm text-text-secondary mt-2">{{__('💡 Save these codes in a safe place. Each
                                    code
                                    can only be used once.')}}</p>
                            </div>

                            <form method="POST" action="{{ route('admin.two-factor.recovery-codes.store') }}"
                                class="inline">
                                @csrf
                                <x-ui.button class="w-auto py-2!" type="submit" variant="secondary"
                                    onclick="return confirm('This will invalidate all your old recovery codes. Are you sure?')">
                                    {{ __('Regenerate Recovery Codes') }}
                                </x-ui.button>
                            </form>
                        </div>
                    @endif

                    <!-- Two-Factor Authentication Actions -->
                    @if (is_null(auth()->guard('admin')->user()->two_factor_confirmed_at))
                        <!-- Cancel 2FA Processing -->
                        <div class="border-t border-text-muted/20 pt-6">
                            <h3 class="text-lg font-semibold mb-4 text-pink-600">{{__('Cancel Processing')}}</h3>
                            <p class="text-text-secondary mb-4">
                                ⚠️ <strong>{{__('Warning:')}}</strong> {{ __('Canceling two-factor authentication processing will make
                                your admin
                                account significantly less secure.') }}
                            </p>

                            <form method="POST" action="{{ route('admin.two-factor.disable') }}">
                                @csrf
                                @method('DELETE')
                                {{-- <x-ui.button class="w-auto py-2!" type="submit" variant="tertiary"
                                    onclick="return confirm('Are you sure you want to cancel processing for your admin account?')">
                                    Cancel Processing
                                </x-ui.button> --}}
                                <button type="submit"
                                    class="px-6 py-2 bg-pink-600 text-white font-semibold rounded-md hover:bg-pink-700 transition duration-200"
                                    onclick="return confirm('Are you sure you want to cancel Processing for your admin account?')">
                                    {{ __('Cancel Processing') }}
                                </button>
                            </form>
                        </div>
                    @else
                        <!-- Disable 2FA -->
                        <div class="border-t border-text-muted/20 pt-6">
                            <h3 class="text-lg font-semibold mb-4 text-pink-600">{{__('Disable Two-Factor Authentication')}}</h3>
                            <p class="text-text-secondary mb-4">
                                ⚠️ <strong>{{__('Warning:')}}</strong> {{ __('Disabling two-factor authentication will make your admin
                                account significantly less secure.') }}
                            </p>

                            <form method="POST" action="{{ route('admin.two-factor.disable') }}">
                                @csrf
                                @method('DELETE')
                                {{-- <x-ui.button class="w-auto py-2!" type="submit" variant="tertiary"
                                    onclick="return confirm('Are you sure you want to disable two-factor authentication for your admin account?')">
                                    Disable Two-Factor Authentication
                                </x-ui.button> --}}
                                <button type="submit"
                                    class="px-6 py-2 bg-pink-600 text-white font-semibold rounded-md hover:bg-pink-700 transition duration-200"
                                    onclick="return confirm('Are you sure you want to disable two-factor for your admin account?')">
                                    {{ __('Disable Two-Factor Authentication') }}
                                </button>
                            </form>
                        </div>
                    @endif

                @endif
            </div>
        </div>

        <!-- Back to Dashboard -->
        <div class="mt-6 text-center">
            <a href="{{ route('admin.dashboard') }}" class="text-accent hover:text-accent-content font-medium">
                {{ __('← Back to Dashboard') }}
            </a>
        </div>
    </div>

    <script>
        function loadQRCode() {
            fetch('{{ route('admin.two-factor.qr-code') }}')
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
            fetch('{{ route('admin.two-factor.recovery-codes') }}')
                .then(response => response.json())
                .then(codes => {
                    const container = document.getElementById('recoveryCodesList');
                    container.innerHTML = codes.map(code =>
                        `<div class="p-3 bg-bg-primary border border-zinc-300 dark:border-zinc-700 rounded text-center font-bold">${code}</div>`
                    ).join('');
                    document.getElementById('recoveryCodes').classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error loading recovery codes:', error);
                    alert('Failed to load recovery codes. Please try again.');
                });
        }
    </script>
</x-admin::app>
