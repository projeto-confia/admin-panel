<?php

namespace App\Http\Requests\EnvVariable;

use App\View\Components\EnvVariableType\EnvVariableType;
use App\View\Components\EnvVariableType\EnvVariableTypeComponent;
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
            'name' => ['required', 'string', 'unique:env_variable,name'],
            'description' => ['required', 'string'],
            'type' => ['required', "in:$availableTypes"],
            'value' => $this->getTypeRules(),
            'uses_min_max_validators' => ['sometimes ', 'required', 'boolean'],
            'min' => ['sometimes', 'nullable', 'required_if:uses_min_max_validators,1', 'integer'],
            'max' => ['sometimes', 'nullable', 'required_if:uses_min_max_validators,1', 'integer', 'gt:min'],
        ];
    }

    public function messages(): array
    {
        return array_merge(
            [
                'name.required' => 'O campo nome é requerido',
                'name.string' => 'O campo nome deve possuir somente texto',
                'name.unique' => 'Já existe um registro com esse valor',
                'description.required' => 'O campo descrição é requerido',
                'description.string' => 'O campo descrição deve possuir somente texto',
                'type.required' => 'O campo tipo é requerido',
                'uses_min_max_validators.required' => 'O campo é requerido',
                'uses_min_max_validators.boolean' => 'O campo deve ser respondido com verdadeiro ou falso',
                'min.required_if' => 'O campo Valor mínimo é requerido.',
                'min.integer' => 'O campo Valor mínimo deve receber um valor numérico.',
                'max.required_if' => 'O campo Valor máximo é requerido.',
                'max.integer' => 'O campo Valor máximo deve receber um valor numérico.',
                'max.gt' => 'O campo Valor máximo deve receber um valor maior que o campo Valor mínimo.',
            ],
            $this->getTypeMessages(),
        );
    }

    private function getComponent(string $type): EnvVariableTypeComponent
    {
        $className = EnvVariableType::getComponentClassNameByType($type);
        $data = [
            'name' => 'nome',
            'label' => 'nome',
            'value' => ''
        ];

        /** @var EnvVariableTypeComponent */
        return resolve($className, $data);
    }

    private function getTypeRules(): array
    {
        if (!$this->type) return [];

        $component = $this->getComponent($this->type);
        return $component->rules();
    }

    private function getTypeMessages(): array
    {
        if (!$this->type) return [];

        $component = $this->getComponent($this->type);
        return array_merge(
            $component->messages('value', 'Valor')
        );
    }
}
