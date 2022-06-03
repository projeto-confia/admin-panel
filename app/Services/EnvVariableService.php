<?php

namespace App\Services;

use App\Models\AdminPanel\EnvVariable\EnvVariable;
use App\Repositories\AdminPanel\Interfaces\IEnvVariableRepository;
use App\Services\Interfaces\IEnvVariableService;
use Illuminate\Support\Arr;

class EnvVariableService implements IEnvVariableService
{
    public function isSomeUpdated(array $envVariables): bool
    {
        return Arr::first($envVariables, fn(EnvVariable $envVariable) => $envVariable->updated === true, false);
    }
}
