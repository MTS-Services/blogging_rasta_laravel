<?php 


namespace App\Actions\Admin;

use App\Repositories\Contracts\AdminRepositoryInterface;
use Illuminate\Support\Facades\DB;

class RestoreAction
{
  public function __construct(public AdminRepositoryInterface $interface)
  {
    
  }

  public function execute(int $id, ?int $actionerId)
  {
    return DB::transaction(function () use ($id, $actionerId) {
      return $this->interface->restore($id, $actionerId);
    });
  }
}