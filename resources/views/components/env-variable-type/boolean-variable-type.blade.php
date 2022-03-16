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
                {{ old($component->getName()) === '1' ? 'checked' : '' }}
            >
            <label class="form-check-label" for="{{ $component->getName() }}_true">
                Verdadeiro
            </label>
        </div>
        <div class="form-check form-check-inline">
            <input
                class="form-check-input"
                type="radio"
                name="{{ $component->getName() }}"
                id="{{ $component->getName() }}_false"
                value="0"
                {{ old($component->getName()) === '0' ? 'checked' : '' }}
            >
            <label class="form-check-label" for="{{ $component->getName() }}_false">
                Falso
            </label>
        </div>
    </div>

    @error($component->getName())
    <span class="text-danger small">{{ $message }}</span>
    @enderror()
</div>
