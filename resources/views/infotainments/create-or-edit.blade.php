<x-layout>
    <x-slot:title>
        @if($infotainment->exists)
            Edit infotainment
        @else
            Create infotainment
        @endif
    </x-slot:title>

    <form action="@if($infotainment->exists)
                    {{ route('infotainments.update', $infotainment) }}
                  @else
                    {{ route('infotainments.store') }}
                  @endif" method="POST">
        @csrf
        @if($infotainment->exists)
            @method('PATCH')
        @endif

        <div class="mb-3">
            <label for="infotainment_manufacturer_id" class="form-label">Infotainment manufacturer</label>
            <select name="infotainment_manufacturer_id" id="infotainment_manufacturer_id"
                   @class(['form-select', 'is-invalid' => $errors->has('infotainment_manufacturer_id')])
                   required>
                @foreach($infotainmentManufacturers as $infotainmentManufacturer)
                    <option value="{{ $infotainmentManufacturer->id }}"
                        @selected(old('infotainment_manufacturer_id', $infotainment->infotainment_manufacturer_id) == $infotainmentManufacturer->id)>
                        {{ $infotainmentManufacturer->name }}
                    </option>
                @endforeach
            </select>
            @error('infotainment_manufacturer_id')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror

            <label for="serializer_manufacturer_id" class="form-label">Serializer manufacturer</label>
            <select name="serializer_manufacturer_id" id="serializer_manufacturer_id"
                    @class(['form-select', 'is-invalid' => $errors->has('serializer_manufacturer_id')])
                    required>
                @foreach($serializerManufacturers as $serializerManufacturer)
                    <option value="{{ $serializerManufacturer->id }}"
                        @selected(old('serializer_manufacturer_id', $infotainment->serializer_manufacturer_id) == $serializerManufacturer->id)>
                        {{ $serializerManufacturer->name }}
                    </option>
                @endforeach
            </select>
            @error('serializer_manufacturer_id')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror

            <label for="product_id" class="form-label">Product ID</label>
            <input type="text" name="product_id"
                   value="{{ old('product_id', $infotainment->product_id) }}"
                   id="product_id"
                   @class(['form-control', 'is-invalid' => $errors->has('product_id')])
                   minlength="4" maxlength="4" required>
            @error('product_id')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror

            <label for="model_year" class="form-label">Model year</label>
            <input type="number" name="model_year"
                   value="{{ old('model_year', $infotainment->model_year) }}"
                   id="model_year"
                   @class(['form-control', 'is-invalid' => $errors->has('model_year')])
                   required>
            @error('model_year')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror

            <label for="part_number" class="form-label">Part number</label>
            <input type="text" name="part_number"
                   value="{{ old('part_number', $infotainment->part_number) }}"
                   id="part_number"
                   @class(['form-control', 'is-invalid' => $errors->has('part_number')])
                   maxlength="13" required>
            @error('part_number')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror

            <label for="compatible_platforms" class="form-label">Compatible platforms</label>
            <textarea name="compatible_platforms"
                   id="compatible_platforms"
                   @class(['form-control', 'is-invalid' => $errors->has('compatible_platforms')])
                   maxlength="1500">{{ old('compatible_platforms', $infotainment->compatible_platforms) }}</textarea>
            @error('compatible_platforms')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror

            <label for="internal_code" class="form-label">Internal code</label>
            <input type="text" name="internal_code"
                   value="{{ old('internal_code', $infotainment->internal_code) }}"
                   id="internal_code"
                   @class(['form-control', 'is-invalid' => $errors->has('internal_code')])
                   maxlength="150">
            @error('internal_code')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror

            <label for="internal_notes" class="form-label">Internal notes</label>
            <textarea name="internal_notes"
                      id="internal_notes"
                      @class(['form-control', 'is-invalid' => $errors->has('internal_notes')])
                      maxlength="1500">{{ old('internal_notes', $infotainment->internal_notes) }}</textarea>
            @error('internal_notes')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</x-layout>
