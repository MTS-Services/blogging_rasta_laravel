<?php

namespace App\Livewire\Frontend;

use App\Models\Blog;
use App\Services\BlogCommentService;
use App\Traits\Livewire\WithNotification;
use Livewire\Component;

class BlogPostComments extends Component
{
    use WithNotification;

    public Blog $blog;

    public string $body = '';

    protected BlogCommentService $blogCommentService;

    public function boot(BlogCommentService $blogCommentService): void
    {
        $this->blogCommentService = $blogCommentService;
    }

    protected function rules(): array
    {
        return [
            'body' => 'required|string|min:3|max:2000',
        ];
    }

    public function mount(Blog $blog): void
    {
        $this->blog = $blog;
    }

    public function submit(): void
    {
        if (! auth()->check()) {
            $this->redirect(route('login'), navigate: true);

            return;
        }

        $this->validate();

        try {
            $this->blogCommentService->createData([
                'blog_id' => $this->blog->id,
                'user_id' => auth()->id(),
                'body' => $this->body,
            ]);

            $this->body = '';
            $this->resetValidation();
            $this->success(__('Comment posted successfully.'));
        } catch (\Exception $e) {
            $this->error(__('Failed to post comment.'));
        }
    }

    public function render()
    {
        $comments = $this->blogCommentService->getByBlogId($this->blog->id);

        return view('livewire.frontend.blog-post-comments', [
            'comments' => $comments,
        ]);
    }
}
