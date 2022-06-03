<?php

namespace App\View\Components\EnvVariableType;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

abstract class EnvVariableTypeComponent extends Component
{
    public function __construct(
        private string $name,
        private string $label,
        protected ?string $value,
        private string $customStyleClass = '',
        private bool $isEditing = false,
        protected string $type = '',
    )
    {
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

    /**
     * @return string
     */
    public function getCustomStyleClass(): string
    {
        return $this->customStyleClass;
    }

    /**
     * @return bool
     */
    public function isEditing(): bool
    {
        return $this->isEditing;
    }

    public function getType(): string
    {
        return $this->type ?? throw new \DomainException('If not specified a type, this method should be override');
    }

    abstract public function rules(): array;
    abstract public function messages(): array;

    abstract public function render(): View|string;
}

