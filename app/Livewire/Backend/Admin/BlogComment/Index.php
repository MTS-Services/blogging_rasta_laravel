<?php

namespace App\Livewire\Backend\Admin\BlogComment;

use App\Services\BlogCommentService;
use App\Traits\Livewire\WithNotification;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, WithNotification;

    /** @var string 'pending' | 'approved' | 'all' */
    public string $statusFilter = 'pending';

    protected BlogCommentService $service;

    protected $queryString = [
        'statusFilter' => ['except' => 'pending'],
    ];

    public function boot(BlogCommentService $service): void
    {
        $this->service = $service;
    }

    public function approve(int $id): void
    {
        if ($this->service->approve($id)) {
            $this->success(__('Comment approved. It will now be visible on the frontend.'));
        } else {
            $this->error(__('Failed to approve comment.'));
        }
    }

    public function unapprove(int $id): void
    {
        if ($this->service->unapprove($id)) {
            $this->success(__('Comment unapproved. It will no longer be visible on the frontend.'));
        } else {
            $this->error(__('Failed to unapprove comment.'));
        }
    }

    public function render()
    {
        $filters = [];
        if ($this->statusFilter === 'pending') {
            $filters['is_approved'] = false;
        } elseif ($this->statusFilter === 'approved') {
            $filters['is_approved'] = true;
        }
        // 'all' or any other value: no filter

        $comments = $this->service->getPaginatedForAdmin(15, $filters);

        return view('livewire.backend.admin.blog-comment.index', [
            'comments' => $comments,
        ]);
    }
}
