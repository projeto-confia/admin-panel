<div class="col-12 {{ $component->getCustomStyleClass() }}" data-typename="{{ $component->getType() }}">
    <table class="table table-responsive">
        <tbody class="table-body">

        @if (is_null($component->getValue()))
            <tr class="item">
                <td class="w-100">
                    <div>
                        <div class="form-floating">
                            <input
                                type="number"
                                inputmode="decimal"
                                class="form-control"
                                id="{{ $component->getName() }}-0"
                                name="{{ $component->getName() }}[]"
                                placeholder="Digite o valor desejado"
                                value="{{ old("{$component->getName()}.0", '') }}"
                            >
                            <label for="{{ $component->getName() }}[]">{{ $component->getLabel() }}</label>
                        </div>
                        @error("{$component->getName()}.0")
                        <span class="text-danger small">{{ $message }}</span>
                        @enderror()
                    </div>
                </td>

                <td class="align-middle">
                    <button type="button" class="remove-item-btn btn btn-danger text-white" aria-label="Remover item">
                        <x-icons.trash style="width: 1rem"></x-icons.trash>
                    </button>
                </td>
            </tr>
        @else
            @foreach($component->getValuesAsArray() as $key => $value)
                <tr class="item">
                    <td class="w-100">
                        <div>
                            <div class="form-floating">
                                <input
                                    type="number"
                                    inputmode="decimal"
                                    class="form-control"
                                    id="{{ $component->getName() }}-{{ $key }}"
                                    name="{{ $component->getName() }}[]"
                                    placeholder="Digite o valor desejado"
                                    value="{{ old("{$component->getName()}.{$key}", $value) }}"
                                >
                                <label for="{{ $component->getName() }}-{{ $key }}">{{ $component->getLabel() }}</label>
                            </div>
                            @error("{$component->getName()}.0")
                            <span class="text-danger small">{{ $message }}</span>
                            @enderror()
                        </div>
                    </td>

                    <td class="align-middle">
                        <button type="button" class="remove-item-btn btn btn-danger text-white" aria-label="Remover item">
                            <x-icons.trash style="width: 1rem"></x-icons.trash>
                        </button>
                    </td>
                </tr>
            @endforeach
        @endif

        </tbody>
    </table>
    <button type="button" class="add-item-btn btn btn-outline-primary float-end">
        Adicionar item
    </button>
</div>
