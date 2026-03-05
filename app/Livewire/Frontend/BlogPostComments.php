<?php

namespace App\Livewire\Frontend;

use App\Models\Blog;
use App\Services\BlogCommentService;
use App\Services\RecaptchaService;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

class BlogPostComments extends Component
{
    use WithNotification;

    public Blog $blog;

    public string $body = '';

    public string $guest_name = '';

    public string $guest_email = '';

    public string $recaptcha_token = '';

    protected BlogCommentService $blogCommentService;

    protected RecaptchaService $recaptchaService;

    public function boot(BlogCommentService $blogCommentService, RecaptchaService $recaptchaService): void
    {
        $this->blogCommentService = $blogCommentService;
        $this->recaptchaService = $recaptchaService;
    }

    protected function rules(): array
    {
        $rules = [
            'body' => 'required|string|min:3|max:2000',
        ];

        if (! auth()->check()) {
            $rules['guest_name'] = 'required|string|min:2|max:255';
            $rules['guest_email'] = 'required|email';
            if (config('recaptcha.site_key')) {
                $rules['recaptcha_token'] = 'required|string';
            }
        }

        return $rules;
    }

    protected function messages(): array
    {
        return [
            'recaptcha_token.required' => __('Please complete the reCAPTCHA verification.'),
        ];
    }

    public function mount(Blog $blog): void
    {
        $this->blog = $blog;
    }

    public function submit(): void
    {
        $key = 'blog-comment:'.request()->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $this->addError('body', __('You have posted too many comments. Please try again later.'));

            return;
        }

        $this->validate();

        if (! auth()->check() && config('recaptcha.secret_key')) {
            if (! $this->recaptchaService->verify($this->recaptcha_token)) {
                $this->addError('recaptcha_token', __('reCAPTCHA verification failed. Please try again.'));

                return;
            }
        }

        // Block links inside comments for additional spam protection
        if (preg_match('/https?:\/\/|www\./i', $this->body)) {
            $this->addError('body', __('Links are not allowed in comments.'));

            return;
        }

        try {
            $payload = [
                'blog_id' => $this->blog->id,
                'body' => $this->body,
                // Auto-approve when automated protections pass
                'is_approved' => true,
            ];

            if (auth()->check()) {
                $payload['user_id'] = auth()->id();
            } else {
                $payload['guest_name'] = $this->guest_name;
                $payload['guest_email'] = $this->guest_email;
            }

            $this->blogCommentService->createData($payload);

            RateLimiter::hit($key, 3600);

            $this->body = '';
            $this->guest_name = '';
            $this->guest_email = '';
            $this->recaptcha_token = '';
            $this->resetValidation();
            $this->dispatch('recaptcha-reset');
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
            'recaptchaSiteKey' => config('recaptcha.site_key'),
        ]);
    }
}
