<?php

namespace App\Repositories\Contracts;

use App\Models\BlogComment;
use Illuminate\Database\Eloquent\Collection;

interface BlogCommentRepositoryInterface
{
    public function getByBlogId(int $blogId): Collection;

    public function create(array $data): BlogComment;
}
