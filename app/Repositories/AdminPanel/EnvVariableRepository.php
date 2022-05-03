<?php

namespace App\Repositories\AdminPanel;

use App\Models\AdminPanel\EnvVariable\EnvVariable;
use App\Repositories\AdminPanel\Interfaces\IEnvVariableRepository;

class EnvVariableRepository implements IEnvVariableRepository
{
    public function all(): array
    {
        return EnvVariable::query()->orderBy('updated_at', 'desc')->get()->all();
    }

    public function store(array $data): EnvVariable
    {
        return EnvVariable::create($data);
    }
}
