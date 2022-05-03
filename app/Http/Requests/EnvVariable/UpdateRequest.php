<?php

namespace App\Http\Requests\EnvVariable;

use App\View\Components\EnvVariableType\EnvVariableType;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $availableTypes = join(',', array_keys(EnvVariableType::TYPES));
        return [
            'description' => ['required', 'string'],
            'value' => $this->getTypeRules(),
        ];
    }

    public function messages(): array
    {
        return array_merge(
            [
                'description.required' => 'O campo descrição é requerido',
                'description.string' => 'O campo descrição deve possuir somente texto',
            ],
            $this->getTypeMessages(),
        );
    }

    private function getTypeRules(): array
    {
        if (!$this->type) return [];

        $className = EnvVariableType::getComponentClassNameByType($this->type);
        return $className::rules();
    }

    private function getTypeMessages(): array
    {
        if (!$this->type) return [];

        $className = EnvVariableType::getComponentClassNameByType($this->type);
        return array_merge(
            $className::messages('value', 'Valor')
        );
    }
}
