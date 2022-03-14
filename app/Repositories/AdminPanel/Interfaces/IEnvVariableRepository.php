<?php

namespace App\Repositories\AdminPanel\Interfaces;

interface IEnvVariableRepository
{
    /**
     * @return array
     */
    public function all(): array;

    public function store(array $data);
}
