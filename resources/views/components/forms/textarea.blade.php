<div class="mb-3">
    <label for="{{ $name }}" class="form-label">
        {{ $label }}
        @if($required)
            <span class="text-danger">*</span>
        @endif
    </label>

    <textarea name="{{ $name }}"
              id="{{ $name }}"
              @class(['form-control', 'is-invalid' => $errors->has($name)])
              @disabled($isDisabled)
              {{ $attributes }}
    >{{ old($name, $defaultValue) }}</textarea>

    @error($name)
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror

    @if($extraText !== null)
        <div class="form-text">
            {{ $extraText }}
        </div>
    @endif
</div>
