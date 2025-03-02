<x-layout :breadcrumbs="$breadcrumbs">
    <x-slot:title>
        Serializer manufacturer
    </x-slot:title>

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
