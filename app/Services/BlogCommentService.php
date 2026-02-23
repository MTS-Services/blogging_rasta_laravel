<?php

namespace App\Services;

use App\Actions\BlogComment\CreateAction;
use App\Models\BlogComment;
use App\Repositories\Contracts\BlogCommentRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class BlogCommentService
{
    public function __construct(
        protected BlogCommentRepositoryInterface $interface,
        protected CreateAction $createAction,
    ) {}

    public function getByBlogId(int $blogId): Collection
    {
        return $this->interface->getByBlogId($blogId);
    }

    public function getPaginatedForAdmin(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        return $this->interface->getPaginatedForAdmin($perPage, $filters);
    }

    public function createData(array $data): BlogComment
    {
        return $this->createAction->execute($data);
    }

    public function approve(int $id): bool
    {
        return $this->interface->update($id, ['is_approved' => true]);
    }

    public function unapprove(int $id): bool
    {
        return $this->interface->update($id, ['is_approved' => false]);
    }
}
