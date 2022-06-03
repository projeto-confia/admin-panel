<?php

namespace App\Services\Interfaces;

interface IEnvVariableService
{
    public function isSomeUpdated(array $envVariables): bool;
}
