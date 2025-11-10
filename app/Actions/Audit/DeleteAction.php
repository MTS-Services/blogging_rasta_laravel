<?php

namespace App\Actions\Audit;

use App\Repositories\Contracts\AuditRepositoryInterface;
use Illuminate\Support\Facades\DB;

class DeleteAction
{
    public function __construct(
        protected AuditRepositoryInterface $auditInterface
    ) {}

    public function execute(int $id, bool $forceDelete = false): bool
    {
        return DB::transaction(function () use ($id, $forceDelete) {
            $data = $this->auditInterface->find($id);

            if (!$data) {
                throw new \Exception('Data not found');
            }

            if ($forceDelete) {
                return $this->auditInterface->forceDelete($id);
            }

            return $this->auditInterface->delete($id);
        });
    }

    public function restore(int $id): bool
    {
        return $this->auditInterface->restore($id);
    }
}
