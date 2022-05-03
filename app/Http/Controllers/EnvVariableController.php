<?php

namespace App\Http\Controllers;

use App\Http\Requests\EnvVariable\StoreRequest;
use App\Models\AdminPanel\EnvVariable\EnvVariable;
use App\Repositories\AdminPanel\Interfaces\IEnvVariableRepository;
use App\Services\Interfaces\IEnvVariableService;
use App\View\Components\EnvVariableType\EnvVariableComponentFactory;
use App\View\Components\EnvVariableType\EnvVariableType;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
        $data = [];
        $data['name'] = Str::upper(Str::snake($request->name));
        $data['description'] = $request->description;
        $data['type'] = $request->uses_min_max_validators
            ? "$request->type[$request->min-$request->max]"
            : $request->type;

        //@todo refactor this mess to every type handle the parse of value
        if (is_array($request->value)) {
            if (str_contains($request->type, 'int')) {
                $values = array_map(fn($item) => (int) $item, $request->value);
            }

            if (str_contains($request->type, 'float')) {
                $values = array_map(fn($item) => (float) $item, $request->value);
            }

            $value = join(',', $values);
        } else {
            if (str_contains($request->type, 'int')) {
                $value = (int) $request->value;
            }

            if (str_contains($request->type, 'float')) {
                $value = (float) $request->value;
            }
        }
        $data['value'] = $value ?? $request->value;
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

    public function edit(EnvVariable $envVariable)
    {
        $value = is_array($envVariable->value) ? join(',', $envVariable->value) : $envVariable->value;
        $envVariableType = new EnvVariableType($envVariable->type, 'value', 'Valor', $value);
        $envVariableComponent = EnvVariableComponentFactory::create($envVariableType);

        return view('pages.envVariable.edit', compact('envVariable', 'envVariableComponent'));
    }

    public function update(Request $request)
    {
        dd($request);
    }

    public function delete(int $id): RedirectResponse
    {
        EnvVariable::destroy($id);
        return redirect()->back();
    }
}
