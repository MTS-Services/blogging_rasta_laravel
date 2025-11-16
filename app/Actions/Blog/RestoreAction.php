<?php


namespace App\Actions\Blog;

use App\Repositories\Contracts\BlogRepositoryInterface;
use Illuminate\Support\Facades\DB;

class RestoreAction
{
  public function __construct(public BlogRepositoryInterface $interface) {}

  public function execute(int $id, ?int $actionerId)
  {
    return DB::transaction(function () use ($id, $actionerId) {
      return $this->interface->restore($id, $actionerId);
    });
  }
}
