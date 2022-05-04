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
        $rules = ['required', 'numeric', 'integer'];
        $minMax = $this->getMinMaxValidations();
        if (! $minMax) {
            return $rules;
        }

        list($min, $max) = $minMax;

        return array_merge(
            $rules,
            [
                "min:$min",
                "max:$max",
            ]
        );
    }

    public function messages(string $fieldName = '', $name = ''): array
    {
        $messages = [
            "$fieldName.required" => "O campo $name é obrigatório",
            "$fieldName.numeric" => "O campo $name deve conter somente números",
            "$fieldName.integer" => "O campo $name deve conter somente números inteiros",
        ];
        $minMax = $this->getMinMaxValidations();
        if (! $minMax) {
            return $messages;
        }

        list($min, $max) = $minMax;

        return array_merge(
            $messages,
            [
                "$fieldName.min" => "O campo $name deve ter um valor maior ou igual a $min",
                "$fieldName.max" => "O campo $name deve ter um valor menor ou igual a $max",
            ]
        );
    }

    private function getMinMaxValidations(): ?array
    {
        if (preg_match_all('/[\d]+/', $this->type, $matches) !== 2) {
            return null;
        }

        return $matches[0];
    }
}
