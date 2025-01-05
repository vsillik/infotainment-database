<x-layout>
    <x-slot:title>
        Infotainment manufacturers
    </x-slot:title>

    @can('create', \App\Models\InfotainmentManufacturer::class)
        <x-action-buttons.create :targetUrl="route('infotainment_manufacturers.create')" label="Create infotainment manufacturer" />
    @endcan

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
                            @can('update', $infotainmentManufacturer)
                                <x-action-buttons.edit :targetUrl="route('infotainment_manufacturers.edit', $infotainmentManufacturer)" />
                            @endcan

                            @can('delete', $infotainmentManufacturer)
                                <x-action-buttons.delete :targetUrl="route('infotainment_manufacturers.destroy', $infotainmentManufacturer)" />
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2">
                            No infotainment manufacturer found.
                            @can('create', \App\Models\InfotainmentManufacturer::class)
                                <a href="{{ route('infotainment_manufacturers.create') }}">Add infotainment manufacturer</a>
                            @endcan
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layout>
