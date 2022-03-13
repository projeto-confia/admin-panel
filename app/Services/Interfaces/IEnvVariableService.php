<?php

namespace App\Services\Interfaces;

interface IEnvVariableService
{
    public function all(): array;
    public function isUpdated(array $envVariables = null): bool;
}
