<?php

namespace App\View\Components\EnvVariableType;

use Illuminate\View\View;

class FloatEnvVariableType extends EnvVariableTypeComponent
{
    public function getType(): string
    {
        return 'float';
    }

    public function render(): View
    {
        return view('components.env-variable-type.float-env-variable-type', ['component' => $this]);
    }

    public static function rules(): array
    {
        return ['required', 'numeric'];
    }

    public static function messages(string $fieldName = '', $name = ''): array
    {
        return [
            "$fieldName.required" => "O campo $name é obrigatório",
            "$fieldName.numeric" => "O campo $name deve conter somente números",
        ];
    }

}
