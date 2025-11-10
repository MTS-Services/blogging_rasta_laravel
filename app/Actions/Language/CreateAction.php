<?php

namespace App\Actions\Language;

use App\Models\Language;
use App\Repositories\Contracts\LanguageRepositoryInterface;
use Illuminate\Support\Facades\DB;

class CreateAction
{
    public function __construct(
        protected LanguageRepositoryInterface $interface
    ) {}


    public function execute(array $data): Language
    {
        return DB::transaction(function () use ($data) {
            $language = $this->interface->create($data);
            // Dispatch event
            // event(new LanguageCreated($language));
            return $language->fresh();
        });
    }
}
