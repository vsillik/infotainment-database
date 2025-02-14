@php
    use App\Models\InfotainmentManufacturer;
    use Illuminate\Support\Str;
@endphp

<x-layout :breadcrumbs="$breadcrumbs">
    <x-slot:title>
        Infotainment manufacturers
    </x-slot:title>

    @can('create', InfotainmentManufacturer::class)
        <x-action-buttons.create :targetUrl="route('infotainment_manufacturers.create')" label="Create infotainment manufacturer" />
    @endcan

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Created at</th>
                    <th>Updated at</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($infotainmentManufacturers as $infotainmentManufacturer)
                    <tr>
                        <td>{{ Str::limit($infotainmentManufacturer->name, 70) }}</td>
                        <td>
                            @if($infotainmentManufacturer->createdBy)
                                @date($infotainmentManufacturer->created_at) ({{ $infotainmentManufacturer->createdBy->email }})
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            @if($infotainmentManufacturer->updatedBy)
                                @date($infotainmentManufacturer->updated_at) ({{ $infotainmentManufacturer->updatedBy->email }})
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            @can('update', $infotainmentManufacturer)
                                <x-action-buttons.edit :targetUrl="route('infotainment_manufacturers.edit', $infotainmentManufacturer)" />
                            @endcan

                            @can('delete', $infotainmentManufacturer)
                                <x-action-buttons.delete
                                    :targetUrl="route('infotainment_manufacturers.destroy', $infotainmentManufacturer)"
                                    confirmSubject="infotainment manufacturer {{$infotainmentManufacturer->name}}" />
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2">
                            No infotainment manufacturer found.
                            @can('create', InfotainmentManufacturer::class)
                                <a href="{{ route('infotainment_manufacturers.create') }}">Add infotainment manufacturer</a>
                            @endcan
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($infotainmentManufacturers->hasPages())
        <div class="mt-2">
            {{ $infotainmentManufacturers->links() }}
        </div>
    @endif
</x-layout>
