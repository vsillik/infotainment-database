@php
    use App\Enums\UserRole;
@endphp

<x-welcome-layout :breadcrumbs="$breadcrumbs">
    @if($userRole === UserRole::ADMINISTRATOR)
        <h3>How to approve a user</h3>
        <ol>
            <li>
                <p>
                    You can either view all unapproved users in the table below, or go to the <a
                        href="{{ route('users.index') }}">users list page</a> to approve users.
                </p>
                <p>
                    To approve a user, click the button
                    <span class="btn btn-outline-success btn-sm disabled opacity-75">Approve</span> in the "Actions"
                    column.
                </p>
            </li>
        </ol>
    @endif

    <h3>How to approve a profile</h3>
    <ol>
        <li>
            <p>
                You can view all infotainments with unapproved profiles in the table below, or select an
                infotainment from
                <a href="{{ route('infotainments.index') }}">this page</a> using the button
                <span class="btn btn-outline-primary btn-sm disabled opacity-75">Show</span> in the "Actions"
                column.
            </p>
        </li>
        <li>
            <p>
                In the infotainment details, select a profile that is not approved (it will not have the
                <span class="badge rounded-pill text-bg-success">Approved</span> badge). You can start reviewing it by
                clicking the button
                <span class="btn btn-outline-success btn-sm disabled opacity-75">Approve</span> in the "Actions"
                column. After checking (and possibly fixing) the parameters, you can click the button <span
                    class="btn btn-primary btn-sm disabled opacity-75">Approve</span> at the end of the page.
            </p>
        </li>
    </ol>

    <hr>
    @if($userRole === UserRole::ADMINISTRATOR)
        <h3 class="mt-4">Users to approve</h3>

        @if(count($users) === 0)
            <p>All users are approved.</p>
        @else
            <p>
                Below are listed <span class="fs-5 fw-bolder">{{ count($users) }}</span> users that are not approved.
            </p>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Email</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th class="text-end">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>
                                {{ Str::limit($user->email, 35) }}
                            </td>
                            <td>{{ Str::limit($user->name, 40) }}</td>
                            <td>{{ $user->role->toHumanReadable() }}</td>
                            <td class="text-end">
                                @if(!$user->is_approved)
                                    <x-action-buttons.approve :targetUrl="route('users.approve', $user)"/>
                                @endif

                                <x-action-buttons.show :targetUrl="route('users.show', $user)"/>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    @endif

    <h3 class="mt-4">Infotainments with unapproved profiles</h3>
    @if(count($infotainments) === 0)
        <p>All infotainments have all profiles already approved.</p>
    @else
        <p>
            Below are listed <span class="fs-5 fw-bolder">{{ count($infotainments) }}</span> infotainments that do not
            have all profiles approved.
        </p>

        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>Infotainment manufacturer</th>
                    <th>Serializer manufacturer</th>
                    <th>Product ID</th>
                    <th>Model year</th>
                    <th>Part number</th>
                    <th class="text-end">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($infotainments as $infotainment)
                    <tr>
                        <td>{{ Str::limit($infotainment->infotainmentManufacturer->name, 35) }}</td>
                        <td>{{ Str::limit($infotainment->serializerManufacturer->name, 35) }}</td>
                        <td>{{ $infotainment->product_id }}</td>
                        <td>{{ $infotainment->model_year }}</td>
                        <td>{{ $infotainment->part_number }}</td>
                        <td class="text-end">
                            <x-action-buttons.show :targetUrl="route('infotainments.show', $infotainment)"/>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
</x-welcome-layout>
