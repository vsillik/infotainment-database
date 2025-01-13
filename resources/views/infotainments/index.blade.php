@php
    use App\Models\Infotainment;
    use Illuminate\Support\Str;
@endphp
<x-layout>
    <x-slot:title>
        Infotainments
    </x-slot:title>

    @can('create', Infotainment::class)
        <x-action-buttons.create :targetUrl="route('infotainments.create')" label="Create infotainment" />
    @endcan

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
                    <td>{{ Str::limit($infotainment->infotainmentManufacturer->name, 35) }}</td>
                    <td>{{ Str::limit($infotainment->serializerManufacturer->name, 35) }}</td>
                    <td>{{ $infotainment->product_id }}</td>
                    <td>{{ $infotainment->model_year }}</td>
                    <td>{{ $infotainment->part_number }}</td>
                    <td>
                        @can('view', $infotainment)
                            <x-action-buttons.show :targetUrl="route('infotainments.show', $infotainment)" />
                        @endcan

                        @can('update', $infotainment)
                            <x-action-buttons.edit :targetUrl="route('infotainments.edit', $infotainment)" />
                        @endcan

                        @can('delete', $infotainment)
                            <x-action-buttons.delete
                                :targetUrl="route('infotainments.destroy', $infotainment)"
                                confirmSubject="infotainment ID: {{ $infotainment->id }}" />
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">
                        No infotainment found.
                        @can('create', Infotainment::class)
                            <a href="{{ route('infotainments.create') }}">Add infotainment</a>
                        @endcan
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</x-layout>
