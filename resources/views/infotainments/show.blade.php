<x-layout>
    <x-slot:title>
        Infotainment
    </x-slot:title>

    <h4>Infotainment manufacturer</h4>
    <p>{{ $infotainment->infotainmentManufacturer->name }}</p>

    <h4>Serializer manufacturer</h4>
    <p>{{ $infotainment->serializerManufacturer->name }}</p>

    <h4>Product ID</h4>
    <p>{{ $infotainment->product_id }}</p>

    <h4>Model year</h4>
    <p>{{ $infotainment->model_year }}</p>

    <h4>Part number</h4>
    <p>{{ $infotainment->part_number }}</p>

    <h4>Compatible platforms</h4>
    <p>{{ $infotainment->compatible_platforms }}</p>

    <h4>Internal code</h4>
    <p>{{ $infotainment->internal_code }}</p>

    <h4>Internal notes</h4>
    <p>{{$infotainment->internal_notes }}</p>

    <h3>Infotainment profiles</h3>
    <hr />

    <a href="{{ route('infotainments.profiles.create', $infotainment) }}" class="btn btn-primary">Create infotainment manufacturer</a>

    <table class="table">
        <thead>
            <tr>
                <th>Profile ID</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($infotainmentProfiles as $infotainmentProfile)
                <tr>
                    <td>
                        {{ $infotainmentProfile->id }}
                        @if($infotainmentProfile->extraTiming)
                            <span class="badge rounded-pill text-bg-info">Extra timing</span>
                        @endif
                    </td>
                    <td>
                        <a href="#" class="btn btn-success btn-sm disabled" aria-disabled="true">
                            Download EDID
                        </a>

                        <a href="{{ route('infotainments.profiles.edit', [$infotainment, $infotainmentProfile]) }}" class="btn btn-primary btn-sm">
                            Edit
                        </a>

                        <form action="{{ route('infotainments.profiles.destroy', [$infotainment, $infotainmentProfile]) }}" method="POST" class="d-inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="2">
                        No infotainment profile found.
                        <a href="{{ route('infotainments.profiles.create', $infotainment) }}">Add infotainment profile</a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</x-layout>
