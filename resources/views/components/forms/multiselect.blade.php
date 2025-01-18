<div class="mb-3">
    <label for="{{ $name }}" class="form-label">
        {{ $label }}
        @if($required)
            <span class="text-danger">*</span>
        @endif
    </label>

    <select name="{{ $name }}[]" id="{{ $name }}"
        @class(['form-select', 'is-invalid' => $errors->has($name)])
        {{ $attributes }}
        multiple
    >
        @foreach($options as $key => $option)
            <option value="{{ $key }}"
                @selected(in_array($key, $selected))>
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
