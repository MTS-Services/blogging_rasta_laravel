<?php

namespace App\Repositories\Eloquent;

use App\Models\BlogComment;
use App\Repositories\Contracts\BlogCommentRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
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
            ->where('is_approved', true)
            ->with('user:id,name,email,avatar')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getPaginatedForAdmin(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        $query = $this->model->query()
            ->with(['blog:id,title,slug', 'user:id,name,email'])
            ->orderBy('created_at', 'desc');

        if (isset($filters['is_approved']) && $filters['is_approved'] !== '') {
            $query->where('is_approved', (bool) $filters['is_approved']);
        }

        return $query->paginate($perPage);
    }

    public function create(array $data): BlogComment
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): bool
    {
        $comment = $this->model->find($id);
        if (! $comment) {
            return false;
        }
        return $comment->update($data);
    }
}
