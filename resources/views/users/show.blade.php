<x-layout :breadcrumbs="$breadcrumbs">
    <x-slot:title>
        User
    </x-slot:title>

    <div class="mb-2">
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

    <h4>Role</h4>
    <p class="text-break">{{ $user->role->toHumanReadable() }}</p>

    <h4>Internal notes</h4>
    <p class="text-break">{{ $user->internal_notes ?? 'N/A' }}</p>

    <h4>Created at</h4>
    <p>
        <x-audit-date :timestamp="$user->created_at" :by="$user->createdBy" />
    </p>

    <h4>Updated at</h4>
    <p>
        <x-audit-date :timestamp="$user->updated_at" :by="$user->updatedBy" />
    </p>
</x-layout>
