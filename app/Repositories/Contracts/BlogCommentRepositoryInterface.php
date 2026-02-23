<?php

namespace App\Repositories\Contracts;

use App\Models\BlogComment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface BlogCommentRepositoryInterface
{
    public function getByBlogId(int $blogId): Collection;

    public function getPaginatedForAdmin(int $perPage = 15, array $filters = []): LengthAwarePaginator;

    public function create(array $data): BlogComment;

    public function update(int $id, array $data): bool;
}
