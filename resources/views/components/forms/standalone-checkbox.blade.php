<input type="checkbox" name="{{ $name }}"
       value="{{ $value }}" id="{{ $name }}"
       class="form-check-input"
    {{ $attributes }}
    @checked(old($name, $isCheckedByDefault))
>
