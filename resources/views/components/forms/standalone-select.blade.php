<select name="{{ $name }}" id="{{ $name }}"
    @disabled($isDisabled)
    {{ $attributes->class(['form-select', 'is-invalid' => $errors->has($name)]) }}
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
