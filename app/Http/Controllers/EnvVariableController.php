<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\IEnvVariableService;
use App\View\Components\EnvVariable\EnvVariableComponent;
use Illuminate\Http\Request;

class EnvVariableController extends Controller
{
    public function __construct(private IEnvVariableService $envVariableService)
    {
    }

    public function index(Request $request)
    {
        $envVariables = $this->envVariableService->all();
        /** @var EnvVariableComponent $v */

        return view('pages.envVariable.index', compact('envVariables'));
    }

    public function update(Request $request)
    {
        dd($request);
    }
}
