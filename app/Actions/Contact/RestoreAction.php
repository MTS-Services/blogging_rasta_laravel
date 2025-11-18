<?php

namespace App\Actions\Contact;

use Illuminate\Support\Facades\DB;
use App\Repositories\Contracts\ContactRepositoryInterface;

class RestoreAction
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected ContactRepositoryInterface $interface
    ) {}


    public function execute(int $id, ?int $actionerId): bool
    {
        return DB::transaction(function () use ($id, $actionerId) {
            return $this->interface->restore($id, [$actionerId]);
        });
    }
}
