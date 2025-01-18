<x-layout :breadcrumbs="$breadcrumbs">
    <x-slot:title>
        @if($serializerManufacturer->exists)
            Edit serializer manufacturer
        @else
            Create serializer manufacturer
        @endif
    </x-slot:title>

    <form action="@if($serializerManufacturer->exists)
                    {{ route('serializer_manufacturers.update', $serializerManufacturer) }}
                  @else
                    {{ route('serializer_manufacturers.store') }}
                  @endif" method="POST">
        @csrf
        @if($serializerManufacturer->exists)
            @method('PATCH')
        @endif

        <x-forms.errors-alert :errors="$errors" />

        <x-forms.input
            name="id"
            label="Identifier"
            :defaultValue="$serializerManufacturer->id"
            required="true"
            extraText="Must be exactly 3 characters long."
            />

        <x-forms.input
            name="name"
            label="Name"
            :defaultValue="$serializerManufacturer->name"
            required="true"
            extraText="Maximum length 255 characters."
            />

        <x-forms.required-note />

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</x-layout>
