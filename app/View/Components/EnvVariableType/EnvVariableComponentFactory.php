<?php

namespace App\View\Components\EnvVariableType;

use App\Models\AdminPanel\EnvVariable\EnvVariable;
use ReflectionException;

abstract class EnvVariableComponentFactory
{
    /**
     * @param EnvVariableType $envVariableType
     * @return EnvVariableTypeComponent
     */
    public static function create(EnvVariableType $envVariableType, string $customStyleClass = '', bool $isEditing = false): EnvVariableTypeComponent
    {
        return resolve(
            EnvVariableType::getComponentClassNameByType($envVariableType->getType()),
            array_merge(
               $envVariableType->toArray(),
               compact('customStyleClass', 'isEditing')
            )
        );
    }
}
