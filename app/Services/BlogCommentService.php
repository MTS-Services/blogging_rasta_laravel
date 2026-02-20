<?php

namespace App\Services;

use App\Actions\BlogComment\CreateAction;
use App\Models\BlogComment;
use App\Repositories\Contracts\BlogCommentRepositoryInterface;
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

    public function createData(array $data): BlogComment
    {
        return $this->createAction->execute($data);
    }
}
