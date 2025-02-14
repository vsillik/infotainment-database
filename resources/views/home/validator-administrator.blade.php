@php
    use App\Enums\UserRole;
@endphp

<x-welcome-layout :breadcrumbs="$breadcrumbs">
    @if($userRole === UserRole::VALIDATOR)
        <h3>How to approve profile</h3>
        <ol>
            <li>
                <p>
                    You can either view all infotainments with not approved profiles below in a table or select
                    infotainment from
                    <a href="{{ route('infotainments.index') }}">here</a> via the action
                    <span class="btn btn-outline-primary btn-sm disabled opacity-75">Show</span> in the "Actions"
                    column.
                <p>
            </li>
            <li>
                <p>
                    From there select profile that is not approved (does not have the
                    <span class="badge rounded-pill text-bg-success">Approved</span> badge) to approve via the
                    <span class="btn btn-outline-success btn-sm disabled opacity-75">Approve</span> action in "Actions"
                    column. Then you can check there all the values and fix them if needed.
                </p>
            </li>
        </ol>
    @elseif($userRole === UserRole::ADMINISTRATOR)
        <h3>How to approve user</h3>
        <ol>
            <li>
                <p>
                    You can either view all not approved users below in a table or approve a user from
                    <a href="{{ route('users.index') }}">here</a>.
                </p>
                <p>
                    You can approve the user via the
                    <span class="btn btn-outline-success btn-sm disabled opacity-75">Approve</span> action in "Actions"
                    column.
                </p>
            </li>
        </ol>

        <hr>

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
                        <th>Actions</th>
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
                            <td>
                                @if(!$user->is_approved)
                                    <x-action-buttons.approve :targetUrl="route('users.approve', $user)"/>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    @endif

    <h3 class="mt-4">Infotainments with not approved profiles</h3>
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
                    <th>Actions</th>
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
                        <td>
                            <x-action-buttons.show :targetUrl="route('infotainments.show', $infotainment)"/>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
</x-welcome-layout>
