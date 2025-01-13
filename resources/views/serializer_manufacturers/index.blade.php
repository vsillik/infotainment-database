@php
    use App\Models\SerializerManufacturer;
    use Illuminate\Support\Str;
@endphp
<x-layout>
    <x-slot:title>
        Serializer manufacturers
    </x-slot:title>

    @can('create', SerializerManufacturer::class)
        <x-action-buttons.create :targetUrl="route('serializer_manufacturers.create')" label="Create serializer manufacturer" />
    @endcan

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
                    <td>{{ Str::limit($serializerManufacturer->name, 70) }}</td>
                    <td>
                        @can('update', $serializerManufacturer)
                            <x-action-buttons.edit :targetUrl="route('serializer_manufacturers.edit', $serializerManufacturer)" />
                        @endcan

                        @can('delete', $serializerManufacturer)
                            <x-action-buttons.delete
                                :targetUrl="route('serializer_manufacturers.destroy', $serializerManufacturer)"
                                confirmSubject="serializer manufacturer {{ $serializerManufacturer->name }}" />
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">
                        No serializer manufacturer found.
                        @can('create', SerializerManufacturer::class)
                            <a href="{{ route('serializer_manufacturers.create') }}">Add serializer manufacturer</a>
                        @endcan
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</x-layout>
