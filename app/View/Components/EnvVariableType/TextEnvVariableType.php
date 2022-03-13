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
}
