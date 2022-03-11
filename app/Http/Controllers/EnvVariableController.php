<?php

namespace App\Http\Controllers;

use App\Models\AdminPanel\EnvVariable\EnvVariable;
use App\Services\Interfaces\IEnvVariableService;
use App\View\Components\EnvVariable\EnvVariableComponent;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class EnvVariableController extends Controller
{
    public function __construct(private IEnvVariableService $envVariableService)
    {
    }

    public function index(Request $request)
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
