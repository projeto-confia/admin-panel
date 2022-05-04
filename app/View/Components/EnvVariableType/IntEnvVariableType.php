<?php

namespace App\View\Components\EnvVariableType;

use Illuminate\Contracts\View\View;

class IntEnvVariableType extends EnvVariableTypeComponent
{
    public function getType(): string
    {
        return 'int';
    }

    public function render(): View
    {
        return view('components.env-variable-type.int-env-variable-type', ['component' => $this]);
    }

    public function rules(): array
    {
        return [
            'required',
            'numeric',
            'integer',
        ];
    }

    public function messages(string $fieldName = '', $name = ''): array
    {
        return [
            "$fieldName.required" => "O campo $name é obrigatório",
            "$fieldName.numeric" => "O campo $name deve conter somente números inteiros",
            "$fieldName.integer" => "O campo $name deve conter somente números inteiros",
        ];
    }
}
