<?php

namespace App\Http\Controllers;

use App\Http\Requests\EnvVariable\StoreRequest;
use App\Repositories\AdminPanel\Interfaces\IEnvVariableRepository;
use App\Services\Interfaces\IEnvVariableService;
use App\View\Components\EnvVariableType\EnvVariableComponentFactory;
use App\View\Components\EnvVariableType\EnvVariableType;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EnvVariableController extends Controller
{
    public function __construct(
        private IEnvVariableService $envVariableService,
        private IEnvVariableRepository $envVariableRepository,
    )
    {
    }

    public function create(): View
    {
        $typesTemplate = array_map(
            fn (string $type) => EnvVariableComponentFactory::create(new EnvVariableType($type, 'value', 'Valor')),
            array_keys(EnvVariableType::TYPES)
        );

        return view('pages.envVariable.create', [
            'typesAvailable' => EnvVariableType::TYPES,
            'typesTemplate' => $typesTemplate
        ]);
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $data = $request->all([
            'name',
            'description',
            'type',
        ]);

        $value = !is_array($request->value) ?: join(',', $request->value);

        $data['value'] = $value;
        $data['default_value'] = $value;

        $this->envVariableRepository->store($data);

        return redirect()->to(route('configuration.index'));
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
