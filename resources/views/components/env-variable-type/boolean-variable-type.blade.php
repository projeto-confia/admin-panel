<div class="col-12 {{ $component->getCustomStyleClass() }}" data-typename="{{ $component->getType() }}">
    <div>
        <p id="{{ $component->getName() }}_label">{{ $component->getLabel() }}</p>
        <div class="form-check form-check-inline">
            <input
                class="form-check-input"
                type="radio"
                name="{{ $component->getName() }}"
                id="{{ $component->getName() }}_true"
                value="1"
                {{ old($component->getName(), $component->getValue()) == true ? 'checked' : '' }}
            >
            <label class="form-check-label" for="{{ $component->getName() }}_true">
                Habilitado
            </label>
        </div>
        <div class="form-check form-check-inline">
            <input
                class="form-check-input"
                type="radio"
                name="{{ $component->getName() }}"
                id="{{ $component->getName() }}_false"
                value="0"
                {{ old($component->getName(), $component->getValue()) == false ? 'checked' : '' }}
            >
            <label class="form-check-label" for="{{ $component->getName() }}_false">
                Desabilitado
            </label>
        </div>
    </div>

    @error($component->getName())
    <span class="text-danger small">{{ $message }}</span>
    @enderror()
</div>
