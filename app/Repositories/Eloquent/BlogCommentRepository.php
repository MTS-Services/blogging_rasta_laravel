<?php

namespace App\Repositories\Eloquent;

use App\Models\BlogComment;
use App\Repositories\Contracts\BlogCommentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class BlogCommentRepository implements BlogCommentRepositoryInterface
{
    public function __construct(
        protected BlogComment $model
    ) {}

    public function getByBlogId(int $blogId): Collection
    {
        return $this->model->query()
            ->where('blog_id', $blogId)
            ->with('user:id,name,email,avatar')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function create(array $data): BlogComment
    {
        return $this->model->create($data);
    }
}
