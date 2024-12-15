<x-layout>
    <x-slot:title>
        Serializer manufacturers
    </x-slot:title>

    <a href="{{ route('serializer_manufacturers.create') }}" class="btn btn-primary mb-3">Create serializer manufacturer</a>

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
                        <a href="{{ route('serializer_manufacturers.edit', $serializerManufacturer) }}" class="btn btn-primary btn-sm">Edit</a>

                        <form action="{{ route('serializer_manufacturers.destroy', $serializerManufacturer) }}" method="POST" class="d-inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
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
