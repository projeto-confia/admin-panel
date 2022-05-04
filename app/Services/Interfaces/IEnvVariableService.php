<?php

namespace App\Services\Interfaces;

interface IEnvVariableService
{
    public function isUpdated(array $envVariables = null): bool;
}
