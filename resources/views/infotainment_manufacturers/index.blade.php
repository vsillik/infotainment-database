<x-layout>
    <x-slot:title>
        Infotainment manufacturers
    </x-slot:title>

    <x-action-buttons.create :targetUrl="route('infotainment_manufacturers.create')" label="Create infotainment manufacturer" />

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
                            <x-action-buttons.edit :targetUrl="route('infotainment_manufacturers.edit', $infotainmentManufacturer)" />
                            <x-action-buttons.delete :targetUrl="route('infotainment_manufacturers.destroy', $infotainmentManufacturer)" />
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2">
                            No infotainment manufacturer found.
                            <a href="{{ route('infotainment_manufacturers.create') }}">Add infotainment manufacturer</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layout>
