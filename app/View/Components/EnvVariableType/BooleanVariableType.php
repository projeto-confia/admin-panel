<?php

namespace App\View\Components\EnvVariableType;

use Illuminate\Contracts\View\View;

class BooleanVariableType extends EnvVariableTypeComponent
{
    public function getType(): string
    {
        return 'bool';
    }

    public function render(): View
    {
        return view('components.env-variable-type.boolean-variable-type', ['component' => $this]);
    }

    public static function rules(): array
    {
        return ['required', 'boolean'];
    }

    public static function messages(string $fieldName = '', $name = ''): array
    {
        return [
            "$fieldName.required" => "O campo $name é obrigatório",
            "$fieldName.boolean" => "O campo $name deve possuir um valor que represente verdadeiro ou falso",
        ];
    }
}
