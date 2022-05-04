<?php

namespace App\View\Components\EnvVariableType;

use Illuminate\Contracts\Support\Arrayable;
use JetBrains\PhpStorm\ArrayShape;

class EnvVariableType implements Arrayable
{
    const TYPES = [
        'string' => 'Texto',
        'float' => 'Número flutuante',
        'int' => 'Número inteiro',
        'bool' => 'Verdadeiro ou falso',
        'array[string]' => 'Lista de nomes',
        'array[int]' => 'Lista de números inteiros',
        'array[float]' => 'Lista de números flutuantes',
    ];

    public function __construct(
        private string $type,
        private string $name,
        private string $label,
        private ?string $value = null,
    )
    {  }

    /**
     * @var array|string[]
     */
    private static array $types = [
        'string' => TextEnvVariableType::class,
        'float' => FloatEnvVariableType::class,
        'float\\[[\d]{1,}-[\d]{1,}\\]' => FloatEnvVariableType::class,
        'int' => IntEnvVariableType::class,
        'int\\[[\d]{1,}-[\d]{1,}\\]' => IntEnvVariableType::class,
        'bool' => BooleanVariableType::class,
        'array[string]' => ListStringEnvVariableType::class,
        'array[int]' => ListIntEnvVariableType::class,
        'array[float]' => ListFloatEnvVariableType::class,
    ];

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    #[ArrayShape(['type' => "string", 'name' => "string", 'label' => "string", 'value' => "null|string"])]
    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'name' => $this->name,
            'label' => $this->label,
            'value' => $this->value,
        ];
    }

    public static function getComponentClassNameByType(string $type): string
    {
        foreach (self::$types as $availableTypePattern => $className) {
            if (preg_match("/$availableTypePattern/", $type) === 1) {
                return $className;
            }
        }

        throw new \DomainException("Component to type $type not found");
    }
}
