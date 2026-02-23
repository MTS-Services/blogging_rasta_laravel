<div class="mt-10 pt-8 border-t border-zinc-200 dark:border-zinc-700">
    <h2 class="text-xl font-semibold text-text-primary mb-4">{{ __('Comments') }} ({{ $comments->count() }})</h2>

    <form id="blog-comment-form" wire:submit="submit" class="mb-8">
        <x-ui.label value="{{ __('Add a comment') }}" class="mb-2 block text-text-primary font-medium" />
        @guest
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                <div>
                    <x-ui.label value="{{ __('Your name') }}" class="mb-1 block text-sm text-text-primary" />
                    <input type="text" wire:model="guest_name"
                        class="w-full rounded-lg border-2 border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-gray-900 dark:text-white px-4 py-2.5 text-base focus:ring-2 focus:ring-second-500 focus:border-second-500"
                        placeholder="{{ __('Your name') }}" />
                    <x-ui.input-error :messages="$errors->get('guest_name')" />
                </div>
                <div>
                    <x-ui.label value="{{ __('Your email') }}" class="mb-1 block text-sm text-text-primary" />
                    <input type="email" wire:model="guest_email"
                        class="w-full rounded-lg border-2 border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-gray-900 dark:text-white px-4 py-2.5 text-base focus:ring-2 focus:ring-second-500 focus:border-second-500"
                        placeholder="{{ __('your@email.com') }}" />
                    <x-ui.input-error :messages="$errors->get('guest_email')" />
                </div>
            </div>
        @endguest
        <textarea
            wire:model="body"
            rows="4"
            class="w-full rounded-lg border-2 border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-gray-900 dark:text-white placeholder:text-zinc-500 dark:placeholder:text-zinc-400 px-4 py-3 text-base focus:ring-2 focus:ring-second-500 focus:border-second-500 dark:focus:ring-second-500 dark:focus:border-second-500 transition-shadow"
            placeholder="{{ __('Write your comment...') }}"
        ></textarea>
        <x-ui.input-error :messages="$errors->get('body')" />
        @guest
            @if($recaptchaSiteKey)
                <div class="mt-3" wire:ignore>
                    <div id="recaptcha-comment-container" class="g-recaptcha" data-sitekey="{{ $recaptchaSiteKey }}"></div>
                    <x-ui.input-error :messages="$errors->get('recaptcha_token')" />
                </div>
            @endif
        @endguest
        <div class="mt-3">
            <button type="submit" id="blog-comment-submit-btn" class="px-5 py-2.5 rounded-lg bg-second-500 text-white text-sm font-medium shadow-md hover:bg-second-600 hover:shadow-lg transition-colors">
                {{ __('Post comment') }}
            </button>
        </div>
    </form>

    <div class="space-y-4">
        @forelse ($comments as $comment)
            @php
                $commenter = $comment->user;
                $displayName = $comment->display_name;
                $avatarUrl = $commenter && method_exists($commenter, 'avatar_url') ? $commenter->avatar_url : 'https://ui-avatars.com/api/?name=' . urlencode($displayName);
                $initial = strtoupper(mb_substr($displayName, 0, 1));
            @endphp
            <div class="flex gap-3 p-4 rounded-lg bg-zinc-50 dark:bg-zinc-800/50 border border-zinc-200 dark:border-zinc-700">
                <div class="flex-shrink-0 relative w-11 h-11 rounded-full overflow-hidden bg-second-500/30 border-2 border-second-500/60 shadow-sm ring-2 ring-white dark:ring-zinc-700">
                    <img
                        src="{{ $avatarUrl }}"
                        alt="{{ $displayName }}"
                        class="w-full h-full object-cover"
                        loading="lazy"
                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                    />
                    <span class="absolute inset-0 flex items-center justify-center bg-second-500/25 text-second-600 dark:text-second-400 font-bold text-base pointer-events-none select-none" style="display: none;">{{ $initial }}</span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-medium text-text-primary">{{ $displayName }}</p>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $comment->created_at->diffForHumans() }}</p>
                    <p class="mt-1 text-text-primary whitespace-pre-wrap">{{ $comment->body }}</p>
                </div>
            </div>
        @empty
            <p class="text-zinc-500 dark:text-zinc-400 text-sm">{{ __('No comments yet.') }}</p>
        @endforelse
    </div>
</div>

@guest
    @if($recaptchaSiteKey)
        @push('head_scripts')
            <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        @endpush
        @push('scripts')
            <script>
                (function() {
                    function initCommentRecaptcha() {
                        var form = document.getElementById('blog-comment-form');
                        if (!form) return;
                        form.id = 'blog-comment-form';
                        form.addEventListener('submit', function(e) {
                            var container = document.getElementById('recaptcha-comment-container');
                            if (!container || typeof grecaptcha === 'undefined') return;
                            e.preventDefault();
                            var token = grecaptcha.getResponse();
                            var wrapper = form.closest('[wire\\:id]');
                            if (wrapper) {
                                var comp = window.Livewire.find(wrapper.getAttribute('wire:id'));
                                if (comp) {
                                    comp.set('recaptcha_token', token);
                                    comp.call('submit');
                                }
                            }
                        });
                    }
                    if (document.readyState === 'loading') {
                        document.addEventListener('DOMContentLoaded', initCommentRecaptcha);
                    } else {
                        initCommentRecaptcha();
                    }
                    document.addEventListener('livewire:navigated', initCommentRecaptcha);
                    Livewire.on('recaptcha-reset', function () {
                        if (typeof grecaptcha !== 'undefined' && document.getElementById('recaptcha-comment-container')) {
                            try { grecaptcha.reset(); } catch (e) {}
                        }
                    });
                })();
            </script>
        @endpush
    @endif
@endguest
