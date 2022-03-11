<?php

namespace App\Services\Interfaces;

interface IEnvVariableService
{
    public function getEnvVariablesAsViewComponent(): array;
}
