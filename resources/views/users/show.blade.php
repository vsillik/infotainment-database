@php
    use App\Enums\UserRole;
@endphp

<x-layout :breadcrumbs="$breadcrumbs">
    <x-slot:title>
        User
    </x-slot:title>

    <div class="mb-2">
        @if($user->role === UserRole::CUSTOMER)
            @can('assignInfotainments', $user)
                <x-action-buttons.assign
                    :targetUrl="route('users.assign-infotainments', $user)"
                    label="Assign infotainments"
                />
            @endcan
        @endif

        @if($user->is_approved)
            @can('unapprove', $user)
                <x-action-buttons.unapprove :targetUrl="route('users.unapprove', $user)"/>
            @endcan
        @else
            @can('approve', $user)
                <x-action-buttons.approve :targetUrl="route('users.approve', $user)"/>
            @endcan
        @endif

        @can('update', $user)
            <x-action-buttons.edit :targetUrl="route('users.edit', $user)"/>
        @endcan

        @can('delete', $user)
            <x-action-buttons.delete
                :targetUrl="route('users.destroy', $user)"
                confirmSubject="user {{ $user->email }}"/>
        @endcan
    </div>

    <h4>Name</h4>
    <p class="text-break">{{ $user->name }}</p>

    <h4>Email</h4>
    <p class="text-break">{{ $user->email }}</p>

    <h4>Approval</h4>
    <p>
        @if($user->is_approved)
            <span class="badge rounded-pill text-bg-success">Approved</span>
        @else
            <span class="badge rounded-pill text-bg-danger">Unapproved</span>
        @endif
    </p>

    <h4>Role</h4>
    <p class="text-break">{{ $user->role->toHumanReadable() }}</p>

    <h4>Internal notes</h4>
    <p class="text-break">{{ $user->internal_notes ?? 'N/A' }}</p>

    <h4>Created at</h4>
    <p>
        @date($user->created_at)
    </p>

    <h4>Updated at</h4>
    <p>
        @date($user->updated_at)
    </p>
</x-layout>
