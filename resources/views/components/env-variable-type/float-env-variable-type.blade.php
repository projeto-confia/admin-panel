<div class="col-12 {{ $component->getCustomStyleClass() }}" data-typename="{{ $component->getType() }}">
    <div class="form-floating">
        <input
            type="number"
            inputmode="decimal"
            class="form-control"
            id="{{ $component->getName() }}"
            name="{{ $component->getName() }}"
            placeholder="Digite o valor desejado"
            value="{{ is_array(old($component->getName(), $component->getValue())) ? '' : old($component->getName(), $component->getValue()) }}"
        >
        <label for="{{ $component->getName() }}">{{ $component->getLabel() }}</label>
    </div>
    @error($component->getName())
    <span class="text-danger small">{{ $message }}</span>
    @enderror()
</div>
