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

    public function getValuesAsArray(): array
    {
        return explode(',', $this->getValue() ?? '');
    }

    public function rules(): array
    {
        return ['required', 'array'];
    }

    public function messages(): array
    {
        return [
        ];
    }
}
