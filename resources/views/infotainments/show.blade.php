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

    <table class="table">
        <thead>
            <tr>
                <th>Field 1</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="2">
                    No infotainment profile found.
                </td>
            </tr>
        </tbody>
    </table>
</x-layout>
