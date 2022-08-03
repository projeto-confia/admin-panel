<?php

namespace App\Http\Requests\EnvVariable;

use App\View\Components\EnvVariableType\EnvVariableType;
use App\View\Components\EnvVariableType\EnvVariableTypeComponent;
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

    private function getComponent(string $type): EnvVariableTypeComponent
    {
        $className = EnvVariableType::getComponentClassNameByType($type);
        $data = [
            'type' => $type,
            'name' => 'nome',
            'label' => 'nome',
            'value' => '',
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
