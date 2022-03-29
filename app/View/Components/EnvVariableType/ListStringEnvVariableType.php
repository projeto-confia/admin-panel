<?php

namespace App\View\Components\EnvVariableType;

use Illuminate\Contracts\View\View;

class ListStringEnvVariableType extends EnvVariableTypeComponent
{
    public function render(): View
    {
        return view('components.env-variable-type.list-string-env-variable-type', ['component' => $this]);
    }

    public function getType(): string
    {
        return 'array[string]';
    }

    public static function rules(): array
    {
        return ['required', 'array'];
    }

    public function getValuesAsArray(): array
    {
        return explode(',', $this->getValue() ?? '');
    }

    public static function messages(): array
    {
        return [
        ];
    }
}
