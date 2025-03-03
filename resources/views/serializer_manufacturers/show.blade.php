<x-layout :breadcrumbs="$breadcrumbs">
    <x-slot:title>
        Serializer manufacturer
    </x-slot:title>

    <div class="mb-2">
        @can('update', $serializerManufacturer)
            <x-action-buttons.edit
                :targetUrl="route('serializer_manufacturers.edit', $serializerManufacturer)"/>
        @endcan

        @can('delete', $serializerManufacturer)
            <x-action-buttons.delete
                :targetUrl="route('serializer_manufacturers.destroy', $serializerManufacturer)"
                confirmSubject="serializer manufacturer {{ $serializerManufacturer->name }}"/>
        @endcan
    </div>

    <h4>Identifier</h4>
    <p>{{ $serializerManufacturer->id }}</p>

    <h4>Name</h4>
    <p class="text-break">{{ $serializerManufacturer->name }}</p>

    <h4>Created at</h4>
    <p>
        <x-audit-date :timestamp="$serializerManufacturer->created_at" :by="$serializerManufacturer->createdBy" />
    </p>

    <h4>Updated at</h4>
    <p>
        <x-audit-date :timestamp="$serializerManufacturer->updated_at" :by="$serializerManufacturer->updatedBy" />
    </p>
</x-layout>
