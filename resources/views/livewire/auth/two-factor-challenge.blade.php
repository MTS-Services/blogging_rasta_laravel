<div class="max-w-md mx-auto bg-bg-primary dark:bg-bg-secondary rounded-2xl shadow-glass-card p-8 mt-10 glass-card">

    <!-- Header -->
    <h2 class="text-2xl font-semibold text-center text-text-primary dark:text-text-primary mb-2 gradient-text">
        {{ __('Two-Factor Authentication') }}
    </h2>

    <p class="text-sm text-text-secondary dark:text-text-secondary text-center mb-6">
        {{ __('Please confirm access to your account by entering the authentication code
                provided by your authenticator app.') }}
    </p>

    <!-- Error Messages -->
    @if ($errors->any())
        <div
            class="mb-6 p-4 bg-red-50 dark:bg-red-950/30 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 rounded-lg">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('status'))
        <div
            class="mb-6 p-4 bg-green-50 dark:bg-green-950/30 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 rounded-lg">
            {{ session('status') }}
        </div>
    @endif

    <!-- Authentication Code Form -->
    <form method="POST" action="{{ route('admin.two-factor.login.store') }}" class="space-y-5">
        @csrf
        <div>
            <label for="code" class="block text-sm font-medium text-text-primary dark:text-text-primary">
                {{ __('Authentication Code') }}
            </label>
            <input type="text" id="code" name="code" maxlength="6" placeholder="000000"
                autocomplete="one-time-code" autofocus inputmode="numeric" pattern="[0-9]*"
                class="mt-1 w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-bg-secondary dark:bg-bg-primary
                       focus:ring-2 focus:ring-accent focus:border-accent text-text-primary dark:text-text-primary
                       shadow-sm py-2.5 px-3 text-center text-lg tracking-widest font-mono">
            <p class="mt-1 text-xs text-text-muted dark:text-text-muted">
                {{ __('Enter the 6-digit code from your authenticator app') }}
            </p>
        </div>

        <x-ui.button type="submit" variant="primary" :wire="false">
            {{ __('Verify Code') }}
        </x-ui.button>
    </form>

    <!-- Divider -->
    <div class="my-6 flex items-center">
        <div class="flex-grow border-t border-zinc-300 dark:border-zinc-700"></div>
        <span class="mx-3 text-sm text-text-muted dark:text-text-muted">{{ __('or') }}</span>
        <div class="flex-grow border-t border-zinc-300 dark:border-zinc-700"></div>
    </div>

    <!-- Recovery Code Toggle -->
    <div class="mt-6 pt-6 border-t border-zinc-200 dark:border-zinc-800">
        <button type="button" onclick="toggleRecoveryForm()"
            class="w-full text-center text-sm text-accent hover:text-accent-content font-medium transition-colors">
            {{ __('Don\'t have your authenticator? Use a recovery code') }}
        </button>

        <!-- Recovery Code Form -->
        <form method="POST" action="{{ route('admin.two-factor.login.store') }}" id="recoveryForm"
            class="hidden mt-4 space-y-4">
            @csrf
            <div>
                <label for="recovery_code"
                    class="block text-sm font-medium text-text-primary dark:text-text-primary mb-2">
                    {{ __('Recovery Code') }}
                </label>
                <input type="text" id="recovery_code" name="recovery_code"
                    class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-bg-secondary dark:bg-bg-primary
                           focus:ring-2 focus:ring-accent focus:border-accent text-text-primary dark:text-text-primary
                           shadow-sm py-2.5 px-3 font-mono"
                    placeholder="xxxxx-xxxxx">
                <p class="text-xs text-text-muted dark:text-text-muted mt-2">
                    {{ __('Enter one of your recovery codes (stored separately)') }}
                </p>
            </div>

            <x-button type="submit" variant="secondary" :wire="false">
                {{ __('Verify Recovery Code') }}
            </x-button>
        </form>
    </div>

    <!-- Back to Login -->
    <div class="mt-6 text-center">
        <a href="{{ route('admin.login') }}"
            class="text-sm text-accent hover:text-accent-content dark:text-accent-foreground transition-colors">
           {{ __(' ← Back to Login') }}
        </a>
    </div>

    <script>
        function toggleRecoveryForm() {
            const form = document.getElementById('recoveryForm');
            form.classList.toggle('hidden');
            if (!form.classList.contains('hidden')) {
                document.getElementById('recovery_code').focus();
            }
        }

        // Auto-focus code input for better UX
        document.addEventListener('DOMContentLoaded', function() {
            const codeInput = document.getElementById('code');
            if (codeInput) {
                codeInput.focus();
            }
        });
    </script>
</div>
