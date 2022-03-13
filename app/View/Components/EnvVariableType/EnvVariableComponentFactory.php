<?php

namespace App\View\Components\EnvVariableType;

use App\Models\AdminPanel\EnvVariable\EnvVariable;
use ReflectionException;

abstract class EnvVariableComponentFactory
{
    /**
     * @var array|string[]
     */
    private static array $types = [
        'string' => TextEnvVariableType::class,
//        'float' => 'Número flutuante',
//        'int' => 'Número',
//        'array[string]' => 'Lista de nomes',
//        'array[int]' => 'Lista de números',
//        'array[float]' => 'Lista de números flutuantes',
//        'bool' => 'Verdadeiro ou falso'
    ];

    /**
     * @return EnvVariableTypeComponent
     */
    public static function create(EnvVariableType $envVariableType): object
    {
        return resolve(self::get($envVariableType->getType()),$envVariableType->toArray());
    }

    private static function get(string $type): string
    {
        return self::$types[$type] ?? throw new \DomainException("Component to type $type not found");
    }
}
