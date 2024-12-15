<x-layout>
    <x-slot:title>
        Infotainments
    </x-slot:title>

    <a href="{{ route('infotainments.create') }}" class="btn btn-primary mb-3">Create infotainment</a>

    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>Infotainment manufacturer</th>
                <th>Serializer manufacturer</th>
                <th>Product ID</th>
                <th>Model year</th>
                <th>Part number</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($infotainments as $infotainment)
                <tr>
                    <td>{{ $infotainment->infotainmentManufacturer->name }}</td>
                    <td>{{ $infotainment->serializerManufacturer->name }}</td>
                    <td>{{ $infotainment->product_id }}</td>
                    <td>{{ $infotainment->model_year }}</td>
                    <td>{{ $infotainment->part_number }}</td>
                    <td>
                        <a href="{{ route('infotainments.show', $infotainment) }}" class="btn btn-outline-primary btn-sm">
                            Show
                        </a>
                        <a href="{{ route('infotainments.edit', $infotainment) }}" class="btn btn-primary btn-sm">
                            Edit
                        </a>

                        <form action="{{ route('infotainments.destroy', $infotainment) }}" method="POST" class="d-inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">
                        No infotainment found.
                        <a href="{{ route('infotainments.create') }}">Add infotainment</a>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</x-layout>
