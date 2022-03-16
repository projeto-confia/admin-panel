<?php

namespace App\View\Components\EnvVariableType;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

abstract class EnvVariableTypeComponent extends Component
{
    public function __construct(
        private string $name,
        private string $label,
        private ?string $value,
        private string $customStyleClass = ''
    )
    {}

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

    /**
     * @return string
     */
    public function getCustomStyleClass(): string
    {
        return $this->customStyleClass;
    }

    abstract public function getType(): string;
    abstract public static function rules(): array;
    abstract public static function messages(): array;

    abstract public function render(): View|string;

}

