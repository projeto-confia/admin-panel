<?php

namespace App\Services;

use App\Models\AdminPanel\EnvVariable\EnvVariable;
use App\Repositories\AdminPanel\Interfaces\IEnvVariableRepository;
use App\Services\Interfaces\IEnvVariableService;
use Illuminate\Support\Arr;

class EnvVariableService implements IEnvVariableService
{
    public function __construct(private IEnvVariableRepository $envVariableRepository)
    {
    }

    public function isUpdated(array $envVariables = null): bool
    {
        if (is_null($envVariables)) {
            throw new \Exception('Método não implementado');
        }

        return ! Arr::first($envVariables, fn(EnvVariable $envVariable) => $envVariable->updated === false, false);
    }

}
