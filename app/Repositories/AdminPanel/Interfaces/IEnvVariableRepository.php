<?php

namespace App\Repositories\AdminPanel\Interfaces;

use App\Models\AdminPanel\EnvVariable\EnvVariable;

interface IEnvVariableRepository
{
    /**
     * @return array
     */
    public function all(): array;
}
