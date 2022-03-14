<?php

namespace App\Http\Requests\EnvVariable;

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
        return [
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'type' => $this->getTypeRules(),
            'value' => ['required'],
            'default_value' => ['required']
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O campo nome é requerido',
            'name.string' => 'O campo nome deve possuir somente texto',
            'description.required' => 'O campo descrição é requerido',
            'description.string' => 'O campo descrição deve possuir somente texto',
            'type.required' => 'O campo tipo é requerido',
        ];
    }

    private function getTypeRules(): array
    {
        $className = EnvVariableType::getComponentClassNameByType($this->type);
        return $className::rules();
    }
}
