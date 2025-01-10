<div class="mb-3">
    <label for="{{ $name }}" class="form-label">
        {{ $label }}
        @if($required)
            <span class="text-danger">*</span>
        @endif
    </label>

    <div @class(['input-group' => $suffixText !== null, 'has-validation' => $suffixText !== null])>
        <input type="{{ $type }}" name="{{ $name }}"
               value="{{ old($name, $defaultValue) }}"
               id="{{ $name }}"
            @class(['form-control', 'is-invalid' => $errors->has($name)])
            {{ $attributes }}
        >

        @if($suffixText !== null)
            <span class="input-group-text">{{ $suffixText }}</span>
        @endif

        @error($name)
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>

    @if($extraText !== null)
        <div class="form-text">
            {{ $extraText }}
        </div>
    @endif
</div>
