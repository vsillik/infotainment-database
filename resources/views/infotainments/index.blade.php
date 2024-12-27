<x-layout>
    <x-slot:title>
        Infotainments
    </x-slot:title>

    <x-action-buttons.create :targetUrl="route('infotainments.create')" label="Create infotainment" />

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
                        <x-action-buttons.show :targetUrl="route('infotainments.show', $infotainment)" />
                        <x-action-buttons.edit :targetUrl="route('infotainments.edit', $infotainment)" />
                        <x-action-buttons.delete :targetUrl="route('infotainments.destroy', $infotainment)" />
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
