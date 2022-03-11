<?php

namespace App\Services;

use App\Models\AdminPanel\EnvVariable\EnvVariable;
use App\Repositories\AdminPanel\Interfaces\IEnvVariableRepository;
use App\Services\Interfaces\IEnvVariableService;
use App\View\Components\EnvVariable\EnvVariableComponent;
use App\View\Components\EnvVariable\EnvVariableComponentFactory;
use Illuminate\Support\Arr;

class EnvVariableService implements IEnvVariableService
{
    public function __construct(private IEnvVariableRepository $envVariableRepository)
    {
    }

    public function all(): array
    {
        return $this->envVariableRepository->all();
    }

    public function isUpdated(array $envVariables = null): bool
    {
        if (is_null($envVariables)) {
            throw new \Exception('Método não implementado');
        }

        return ! Arr::first($envVariables, fn(EnvVariable $envVariable) => $envVariable->updated === false, false);
    }
    /**
     * @return EnvVariableComponent[]
     */
    public function getEnvVariablesAsViewComponent(): array
    {
        $envVariables = $this->envVariableRepository->all();
        $createComponent = fn(EnvVariable $envVariable) => EnvVariableComponentFactory::create(
            $envVariable->type,
            $envVariable->name,
            $envVariable->description,
            $envVariable->value,
            $envVariable->default_value
        );

        return array_map($createComponent, $envVariables);
    }
}
