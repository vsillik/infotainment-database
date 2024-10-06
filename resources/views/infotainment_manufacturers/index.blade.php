<x-layout>
    <x-slot:title>
        Infotainment manufacturers
    </x-slot:title>

    <a href="{{ route('infotainment_manufacturers.create') }}" class="btn btn-primary">Create infotainment manufacturer</a>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($infotainmentManufacturers as $infotainmentManufacturer)
                    <tr>
                        <td>{{ $infotainmentManufacturer->name }}</td>
                        <td>
                            <a href="{{ route('infotainment_manufacturers.edit', $infotainmentManufacturer) }}" class="btn btn-primary">
                                Edit
                            </a>

                            <form action="{{ route('infotainment_manufacturers.destroy', $infotainmentManufacturer) }}" method="POST" class="d-inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2">No infotainment manufacturer found.
                            <a href="{{ route('infotainment_manufacturers.create') }}">Add infotainment manufacturer</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layout>
