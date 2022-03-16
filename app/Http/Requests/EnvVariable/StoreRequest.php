<?php

namespace App\Http\Requests\EnvVariable;

use App\Models\AdminPanel\EnvVariable\EnvVariable;
use App\View\Components\EnvVariableType\EnvVariableType;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'type' => ['required', "in:$availableTypes"],
            'value' => $this->getTypeRules(),
            'default_value' => $this->getTypeRules(),
        ];
    }

    public function messages(): array
    {
        return array_merge(
            [
                'name.required' => 'O campo nome é requerido',
                'name.string' => 'O campo nome deve possuir somente texto',
                'description.required' => 'O campo descrição é requerido',
                'description.string' => 'O campo descrição deve possuir somente texto',
                'type.required' => 'O campo tipo é requerido',
            ],
            $this->getTypeMessages(),
        );
    }

    private function getTypeRules(): array
    {
        $className = EnvVariableType::getComponentClassNameByType($this->type);
        return $className::rules();
    }

    private function getTypeMessages(): array
    {
        $className = EnvVariableType::getComponentClassNameByType($this->type);
        return array_merge(
            $className::messages('value', 'Valor'),
            $className::messages('default_value', 'Valor Padrão'),
        );
    }
}
