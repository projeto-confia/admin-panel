<div class="col-12 {{ $component->getCustomStyleClass() }}" data-typename="{{ $component->getType() }}">
    <div class="form-floating">
        <input
            type="number"
            inputmode="decimal"
            class="form-control"
            id="{{ $component->getName() }}"
            name="{{ $component->getName() }}"
            placeholder="Digite o valor desejado"
            value="{{ old($component->getName(), '') }}"
        >
        <label for="{{ $component->getName() }}">{{ $component->getLabel() }}</label>
        @error($component->getName())
        <span class="text-danger small">{{ $message }}</span>
        @enderror()
    </div>

    <div>
        <p class="mt-2">Deve validar os valores mínimos e máximos ?</p>

        <div class="form-check form-check-inline">
            <input
                id="uses_min_max_validators_true"
                name="uses_min_max_validators"
                class="form-check-input"
                type="radio"
                value="1"
                {{ old('uses_min_max_validators') === '1' ? 'checked' : '' }}
            >
            <label class="form-check-label" for="uses_min_max_validators_true">
                Sim
            </label>
        </div>

        <div class="form-check form-check-inline">
            <input
                id="uses_min_max_validators_false"
                name="uses_min_max_validators"
                class="form-check-input"
                type="radio"
                value="0"
                {{ old('uses_min_max_validators') === '0' ? 'checked' : '' }}
            >
            <label class="form-check-label" for="uses_min_max_validators_false">
                Não
            </label>
        </div>

        @error('uses_min_max_validators')
        <span class="text-danger small">{{ $message }}</span>
        @enderror()
    </div>

    <div id="wrapper-min-max-value" class="{{ old('uses_min_max_validators', false)  ? '' : 'd-none' }}">
        <div class="form-floating">
            <input
                id="min"
                name="min"
                class="form-control mt-4"
                placeholder="Digite o valor mínimo"
                type="number"
                inputmode="decimal"
                value="{{ old('min') }}"
            >
            <label for="min">Valor mínimo</label>
            @error('min')
            <span class="text-danger small">{{ $message }}</span>
            @enderror()
        </div>
        <div class="form-floating">
            <input
                id="max"
                name="max"
                class="form-control mt-4"
                type="number"
                inputmode="decimal"
                placeholder="Digite o valor mínimo"
                value="{{ old('max') }}"
            >
            <label for="min">Valor máximo</label>
            @error('max')
            <span class="text-danger small">{{ $message }}</span>
            @enderror()
        </div>
    </div>
</div>
