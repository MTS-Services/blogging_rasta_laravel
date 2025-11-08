<?php 


namespace App\Actions\User;


use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;

class RestoreAction
{
  public function __construct(public UserRepositoryInterface $interface)
  {
    
  }

  public function execute(int $id, ?int $actionerId)
  {
    return DB::transaction(function () use ($id, $actionerId) {
      return $this->interface->restore($id, $actionerId);
    });
  }
}