<?php

namespace App\Http\Requests\Curatorship;

use Illuminate\Foundation\Http\FormRequest;

class CurateRequest extends FormRequest
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
            'is_similar' => ['sometimes', 'boolean'],
            'is_news' => ['required', 'boolean'],
            'is_fake_news' => ['required_if:is_news,1', 'boolean'],
            'text_note' => ['sometimes', 'max:1000']
        ];
    }

    public function messages(): array
    {
        return [
            'is_similar.sometimes' => 'Campo obrigatório',
            'is_news.required' => 'Campo obrigatório',
            'is_fake_news.required_if' => 'Campo obrigatório quando é notícia',
            'text_note.max' => 'Máximo de 1000 caracteres',
        ];
    }
}
