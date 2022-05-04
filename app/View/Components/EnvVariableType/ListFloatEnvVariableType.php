<?php

namespace App\View\Components\EnvVariableType;

use Illuminate\Contracts\View\View;

class ListFloatEnvVariableType extends EnvVariableTypeComponent
{
    public function render(): View
    {
        return view('components.env-variable-type.list-float-env-variable-type', ['component' => $this]);
    }

    public function getType(): string
    {
        return 'array[float]';
    }

    public function getValuesAsArray(): array
    {
        return explode(',', $this->getValue() ?? '');
    }

    public function rules(): array
    {
        return ['required', 'array'];
    }

    public function messages(string $fieldName = '', $name = ''): array
    {
        return [
            "$fieldName.required" => "O campo $name é obrigatório",
            "$fieldName.array" => "O campo $name deve ser uma lista"
        ];
    }
}
