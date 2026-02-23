<section>
    <div class="glass-card rounded-2xl p-4 lg:p-6 mb-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <h2 class="text-xl lg:text-2xl font-bold text-text-black dark:text-text-white">
                {{ __('Blog Comments') }}
            </h2>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.blog-comment.index', ['statusFilter' => 'pending']) }}" wire:navigate
                    class="px-4 py-2 rounded-lg text-sm font-medium transition {{ $statusFilter === 'pending' ? 'bg-second-500 text-white' : 'bg-zinc-200 dark:bg-zinc-700 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-300 dark:hover:bg-zinc-600' }}">
                    {{ __('Pending') }}
                </a>
                <a href="{{ route('admin.blog-comment.index', ['statusFilter' => 'approved']) }}" wire:navigate
                    class="px-4 py-2 rounded-lg text-sm font-medium transition {{ $statusFilter === 'approved' ? 'bg-second-500 text-white' : 'bg-zinc-200 dark:bg-zinc-700 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-300 dark:hover:bg-zinc-600' }}">
                    {{ __('Approved') }}
                </a>
                <a href="{{ route('admin.blog-comment.index', ['statusFilter' => 'all']) }}" wire:navigate
                    class="px-4 py-2 rounded-lg text-sm font-medium transition {{ $statusFilter === 'all' ? 'bg-second-500 text-white' : 'bg-zinc-200 dark:bg-zinc-700 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-300 dark:hover:bg-zinc-600' }}">
                    {{ __('All') }}
                </a>
            </div>
        </div>
    </div>

    <div class="glass-card rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800/50">
                    <tr>
                        <th class="px-4 py-3 font-semibold text-text-primary">{{ __('Author') }}</th>
                        <th class="px-4 py-3 font-semibold text-text-primary">{{ __('Comment') }}</th>
                        <th class="px-4 py-3 font-semibold text-text-primary">{{ __('Blog') }}</th>
                        <th class="px-4 py-3 font-semibold text-text-primary">{{ __('Date') }}</th>
                        <th class="px-4 py-3 font-semibold text-text-primary">{{ __('Status') }}</th>
                        <th class="px-4 py-3 font-semibold text-text-primary">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @forelse ($comments as $comment)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/30">
                            <td class="px-4 py-3">
                                <span class="font-medium text-text-primary">{{ $comment->display_name }}</span>
                                @if($comment->guest_email)
                                    <br><span class="text-xs text-zinc-500">{{ $comment->guest_email }}</span>
                                @elseif($comment->user)
                                    <br><span class="text-xs text-zinc-500">{{ $comment->user->email ?? '' }}</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-text-primary max-w-xs truncate" title="{{ strip_tags($comment->body) }}">
                                {{ Str::limit(strip_tags($comment->body), 80) }}
                            </td>
                            <td class="px-4 py-3">
                                @if($comment->blog)
                                    <a href="{{ route('blog.details', $comment->blog->slug) }}" target="_blank" rel="noopener" class="text-second-500 hover:underline">
                                        {{ Str::limit($comment->blog->title, 30) }}
                                    </a>
                                @else
                                    —
                                @endif
                            </td>
                            <td class="px-4 py-3 text-zinc-600 dark:text-zinc-400">
                                {{ $comment->created_at->format('M j, Y H:i') }}
                            </td>
                            <td class="px-4 py-3">
                                @if($comment->is_approved)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                        {{ __('Approved') }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400">
                                        {{ __('Pending') }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @if($comment->is_approved)
                                    <button type="button" wire:click="unapprove({{ $comment->id }})" wire:loading.attr="disabled"
                                        class="text-amber-600 hover:text-amber-700 dark:text-amber-400 text-sm font-medium">
                                        {{ __('Unapprove') }}
                                    </button>
                                @else
                                    <button type="button" wire:click="approve({{ $comment->id }})" wire:loading.attr="disabled"
                                        class="text-green-600 hover:text-green-700 dark:text-green-400 text-sm font-medium">
                                        {{ __('Approve') }}
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-zinc-500 dark:text-zinc-400">
                                {{ $statusFilter === 'pending' ? __('No pending comments.') : ($statusFilter === 'approved' ? __('No approved comments.') : __('No comments yet.')) }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($comments->hasPages())
            <div class="px-4 py-3 border-t border-zinc-200 dark:border-zinc-700">
                {{ $comments->links() }}
            </div>
        @endif
    </div>
</section>
