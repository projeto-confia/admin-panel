<?php

namespace App\Http\Controllers;

use App\Models\AdminPanel\EnvVariable\EnvVariable;
use App\Services\Interfaces\IEnvVariableService;
use App\View\Components\EnvVariableType\EnvVariableComponentFactory;
use App\View\Components\EnvVariableType\EnvVariableType;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class EnvVariableController extends Controller
{
    public function __construct(private IEnvVariableService $envVariableService)
    {
    }

    public function create(): View
    {
        $typesTemplate = array_map(
            fn (string $type) => EnvVariableComponentFactory::create(new EnvVariableType($type, 'value', 'Valor')),
            array_keys(EnvVariable::TYPES)
        );

        return view('pages.envVariable.create', [
            'typesAvailable' => EnvVariable::TYPES,
            'typesTemplate' => $typesTemplate
        ]);
    }

    public function store(): View
    {
        return view('pages.envVariable.store');
    }

    public function index(): View
    {
        $envVariables = $this->envVariableService->all();
        $isUpdated = $this->envVariableService->isUpdated($envVariables);

        return view('pages.envVariable.index', compact('envVariables', 'isUpdated'));
    }

    public function update(Request $request)
    {
        dd($request);
    }
}
