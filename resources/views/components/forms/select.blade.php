<div class="mb-3">
    <label for="{{ $name }}" class="form-label">
        {{ $label }}
        @if($required)
            <span class="text-danger">*</span>
        @endif
    </label>

    <select name="{{ $name }}" id="{{ $name }}"
            @class(['form-select', 'is-invalid' => $errors->has($name)])
            {{ $attributes }}
    >
        @foreach($options as $key => $option)
            <option value="{{ $key }}"
                @selected(old($name, $defaultValue) == $key)>
                {{ $option }}
            </option>
        @endforeach
    </select>

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
