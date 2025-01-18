<x-layout :breadcrumbs="$breadcrumbs">
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

        <x-forms.errors-alert :errors="$errors" />

        <x-forms.select
            name="infotainment_manufacturer_id"
            label="Infotainment manufacturer"
            :options="$infotainmentManufacturers"
            :defaultValue="$infotainment->infotainment_manufacturer_id"
            required="true"
            />

        <x-forms.select
            name="serializer_manufacturer_id"
            label="Serializer manufacturer"
            :options="$serializerManufacturers"
            :defaultValue="$infotainment->serializer_manufacturer_id"
            required="true"
            />

        <x-forms.input
            name="product_id"
            label="Product ID"
            :defaultValue="$infotainment->product_id"
            required="true"
            extraText="Must be exactly 4 characters long."
            />

        <x-forms.input
            name="model_year"
            type="number"
            label="Model year"
            :defaultValue="$infotainment->model_year"
            required="true"
            extraText="The value must be between 1990-2245."
            />

        <x-forms.input
            name="part_number"
            label="Part number"
            :defaultValue="$infotainment->part_number"
            required="true"
            extraText="Maximum length 13 characters."
            />

        <x-forms.textarea
            name="compatible_platforms"
            label="Compatible platforms"
            :defaultValue="$infotainment->compatible_platforms"
            extraText="Maximum length 1500 characters."
            />

        <x-forms.input
            name="internal_code"
            label="Internal code"
            :defaultValue="$infotainment->internal_code"
            extraText="Maximum length 150 characters."
            />

        <x-forms.textarea
            name="internal_notes"
            label="Internal notes"
            :defaultValue="$infotainment->internal_notes"
            extraText="Maximum length 1500 characters."/>

        <x-forms.required-note />

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</x-layout>
