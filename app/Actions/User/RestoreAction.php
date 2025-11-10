<?php


namespace App\Actions\User;

use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;

class RestoreAction
{
  public function __construct(public UserRepositoryInterface $interface) {}

  public function execute(int $id, array $actioner)
  {
    return DB::transaction(function () use ($id, $actioner) {
      return $this->interface->restore(id: $id, actioner: $actioner);
    });
  }
}
