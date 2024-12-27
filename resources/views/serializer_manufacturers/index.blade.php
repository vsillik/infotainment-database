<x-layout>
    <x-slot:title>
        Serializer manufacturers
    </x-slot:title>

    <x-action-buttons.create :targetUrl="route('serializer_manufacturers.create')" label="Create serializer manufacturer" />

    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>Identifier</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($serializerManufacturers as $serializerManufacturer)
                <tr>
                    <td>{{ $serializerManufacturer->id }}</td>
                    <td>{{ $serializerManufacturer->name }}</td>
                    <td>
                        <x-action-buttons.edit :targetUrl="route('serializer_manufacturers.edit', $serializerManufacturer)" />
                        <x-action-buttons.delete :targetUrl="route('serializer_manufacturers.destroy', $serializerManufacturer)" />
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">
                        No serializer manufacturer found.
                        <a href="{{ route('serializer_manufacturers.create') }}">Add serializer manufacturer</a>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</x-layout>
