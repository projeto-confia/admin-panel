<?php

namespace App\View\Components\EnvVariableType;

use Illuminate\Contracts\View\View;

class TextEnvVariableType extends EnvVariableTypeComponent
{
    /**
     * Get the type name
     * @return string
     */
    public function getType(): string
    {
        return 'string';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render(): View|string
    {
        return view('components.env-variable-type.text-env-variable', ['component' => $this]);
    }

    public static function rules(): array
    {
        return [
            'required',
            'string',
        ];
    }

    public static function messages(string $fieldName = '', $name = ''): array
    {
        return [
            "$fieldName.required" => "O campo $name é obrigatório",
            "$fieldName.string" => "O campo $name deve ser do tipo texto",
        ];
    }
}
