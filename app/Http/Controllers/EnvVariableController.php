<?php

namespace App\Http\Controllers;

use App\Http\Requests\EnvVariable\StoreRequest;
use App\Http\Requests\EnvVariable\UpdateRequest;
use App\Models\AdminPanel\EnvVariable\EnvVariable;
use App\Repositories\AdminPanel\Interfaces\IEnvVariableRepository;
use App\Services\Interfaces\IEnvVariableService;
use App\View\Components\EnvVariableType\EnvVariableComponentFactory;
use App\View\Components\EnvVariableType\EnvVariableType;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
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
        $data['name'] = preg_replace('/\s+/', '', Str::upper($request->name));
        $data['description'] = $request->description;
        $data['type'] = $request->uses_min_max_validators
            ? "$request->type[$request->min-$request->max]"
            : $request->type;


        $data['value'] = $this->parseValue($request);
        $data['default_value'] = $data['value'];
        $data['updated'] = true;
        $this->envVariableRepository->store($data);

        return redirect()->to(route('configuration.index'));
    }

    public function index(): View
    {
        $envVariables = $this->envVariableRepository->all();
        $isUpdated = $this->envVariableService->isSomeUpdated($envVariables);

        return view('pages.envVariable.index', compact('envVariables', 'isUpdated'));
    }

    public function edit(EnvVariable $envVariable)
    {
        $value = is_array($envVariable->value) ? join(',', $envVariable->value) : $envVariable->value;
        $envVariableType = new EnvVariableType($envVariable->type, 'value', 'Valor', $value);
        $envVariableComponent = EnvVariableComponentFactory::create($envVariableType, isEditing: true);

        return view('pages.envVariable.edit', compact('envVariable', 'envVariableComponent'));
    }

    public function update(EnvVariable $envVariable, UpdateRequest $request): RedirectResponse
    {
        $envVariable->fill([
            'updated' => true,
            'value' => $this->parseValue($request),
            'description' => $request->description
        ]);
        $envVariable->save();

        return redirect()->to(route('configuration.index'));
    }

    public function delete(int $id): RedirectResponse
    {
        EnvVariable::destroy($id);
        return redirect()->back();
    }

    /**
     * Move this logic to component type and get instance by type
     * Something like
     * $className = EnvVariableType::getComponentClassNameByType($type);
     * $valueParsed = $className::parseValue($value);
     * @param $request
     * @return float|int|bool|array|string
     */
    private function parseValue($request): float|int|bool|array|string
    {
        if (is_array($request->value)) {
            if (str_contains($request->type, 'int')) {
                $values = array_map(fn($item) => (int) $item, $request->value);
            }

            if (str_contains($request->type, 'float')) {
                $values = array_map(fn($item) => (float) $item, $request->value);
            }

            $value = join(',', $values ?? array_map(fn($item) => $item, $request->value));
        } else {
            if (str_contains($request->type, 'int')) {
                $value = (int) $request->value;
            }

            if (str_contains($request->type, 'float')) {
                $value = (float) $request->value;
            }

            if (str_contains($request->type, 'bool')) {
                $value = (bool) $request->value;
            }
        }

        return $value ?? $request->value;
    }
}
