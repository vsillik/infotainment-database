<div class="mb-3">
    <label for="{{ $name }}" class="form-label">
        {{ $label }}
        @if($required)
            <span class="text-danger">*</span>
        @endif
    </label>
    <input type="{{ $type }}" name="{{ $name }}"
           value="{{ old($name, $defaultValue) }}"
           id="{{ $name }}"
           @class(['form-control', 'is-invalid' => $errors->has($name)])
           @if ($minLength !== null) minlength="{{ $minLength }}" @endif
           @if ($maxLength !== null) maxlength="{{ $maxLength }}" @endif
           @required($required)>
    @error($name)
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>
