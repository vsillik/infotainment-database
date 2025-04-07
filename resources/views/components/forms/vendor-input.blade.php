<div class="mb-3">
    <label class="form-label">
        {{ $label }}
        @if($required)
            <span class="text-danger">*</span>
        @endif
    </label>

    <div class="form-text mt-0 mb-2">
        Each byte must contain up to 2 hexadecimal characters. Once the byte is added it must be filled in. <br>
        Bytes 1-3 will be automatically filled in with vendor ID (IEEE ID).
    </div>

    <a href="#"
       id="btn_guide_{{$name}}"
       class="btn btn-sm btn-outline-primary btn-guide"
       data-bs-toggle="modal"
       data-bs-target="#guide-modal"
       data-target="{{ $name }}"
    >
        Guide
    </a>

    <a href="#"
       id="btn_add_byte_{{ $name }}"
       @class([
            'btn',
            'btn-sm',
            'btn-success',
            'btn-add-byte',
            'disabled' => $bytesCount >= 28 || $isDisabled
       ])
       data-target="{{ $name }}"
    >
        Add byte
    </a>

    <a href="#"
       id="btn_remove_byte_{{ $name }}"
       @class([
            'btn',
            'btn-sm',
            'btn-danger',
            'btn-remove-byte',
            'disabled' => $bytesCount === 0 || $isDisabled
       ])
       data-target="{{ $name }}"
    >
        Remove byte
    </a>

    <input type="hidden" name="{{$name}}_byte_count" id="{{$name}}_byte_count" value="{{ $bytesCount }}"
           autocomplete="off" disabled>

    <div class="row">
        @for($i = 0; $i < 28; $i++)
            <div id="{{ $name }}_{{ $i }}_wrapper"
                @class(['col-2', 'd-none' => $i >= $bytesCount])
            >
                <label for="{{ $name }}_{{$i}}" class="form-label">
                    Byte {{ $i + 4 }}
                    <span class="text-danger">*</span>
                </label>

                <div class="input-group mb-1">
                    <span class="input-group-text px-2">0x</span>
                    <input type="text"
                           name="{{ $name }}[{{$i}}]"
                           value="{{ old(sprintf('%s.%s', $name, $i), array_key_exists($i, $defaultValue) ? $defaultValue[$i] : null) }}"
                           id="{{$name}}_{{$i}}"
                        @class(['form-control', 'px-2', 'is-invalid' => $errors->has(sprintf('%s.%s', $name, $i))])
                        @disabled($i >= $bytesCount || $isDisabled)
                    >
                    @error(sprintf('%s.%s', $name, $i))
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
        @endfor
    </div>
</div>

@pushonce('scripts')
    <script>
        function attachListenersForButtons() {
            const addButtons = document.getElementsByClassName('btn-add-byte');
            const removeButtons = document.getElementsByClassName('btn-remove-byte');

            for (const addButton of addButtons) {
                addButton.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();

                    const target = e.currentTarget.dataset.target;
                    const byteCountInput = document.getElementById(target + '_byte_count');
                    let byteCount = parseInt(byteCountInput.value, 10);

                    if (isNaN(byteCount) || byteCount < 0) {
                        byteCount = 0;
                    } else if (byteCount >= 28) {
                        byteCountInput.value = 28;
                        return;
                    }

                    document.getElementById(target + '_' + byteCount).disabled = false;
                    document.getElementById(target + '_' + byteCount + '_wrapper').classList.remove('d-none');

                    byteCount++;
                    byteCountInput.value = byteCount;

                    if (byteCount === 28) {
                        e.currentTarget.classList.add('disabled');
                    }

                    if (byteCount === 1) {
                        document.getElementById('btn_remove_byte_' + target).classList.remove('disabled');
                    }
                });
            }

            for (const removeButton of removeButtons) {
                removeButton.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();

                    const target = e.currentTarget.dataset.target;
                    const byteCountInput = document.getElementById(target + '_byte_count');
                    let byteCount = parseInt(byteCountInput.value, 10);

                    if (isNaN(byteCount) || byteCount <= 0) {
                        byteCountInput.value = 0;
                        return;

                    } else if (byteCount > 28) {
                        byteCount = 28;
                    }

                    byteCount--;

                    document.getElementById(target + '_' + byteCount).disabled = true;
                    document.getElementById(target + '_' + byteCount + '_wrapper').classList.add('d-none');

                    byteCountInput.value = byteCount;

                    if (byteCount === 0) {
                        e.currentTarget.classList.add('disabled');
                    }

                    if (byteCount === 27) {
                        document.getElementById('btn_add_byte_' + target).classList.remove('disabled');
                    }
                });
            }
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', attachListenersForButtons);
        } else {
            attachListenersForButtons();
        }
    </script>
@endpushonce
