<input type="checkbox" name="{{ $name }}"
       value="{{ $value }}" id="{{ $name }}"
    {{ $attributes->merge(['class' => 'form-check-input']) }}
    @checked(old($name, $isCheckedByDefault))
    @disabled($isDisabled)
>
