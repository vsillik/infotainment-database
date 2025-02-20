<div @class(["form-check", "small" => $attributes->get('class') === 'small'])>
    <input class="form-check-input" type="radio"
           name="{{ $name }}"
           id="{{ $name }}_{{ $value }}"
           value="{{ $value }}"
        @checked($isCheckedByDefault)
        {{ $attributes }}
    >
    <label class="form-check-label" for="{{ $name }}_{{ $value }}">
        {{ $label }}
    </label>

    @error($name)
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>
