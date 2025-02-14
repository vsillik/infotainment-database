<x-layout :breadcrumbs="$breadcrumbs">
    <x-slot:title>
        Deleted users
    </x-slot:title>

    <p>
        Users marked as deleted can be restored here. User must be manually re-approved after restoring. You can also
        permanently delete users. Users that are assigned to some audit action (create, last edit, delete) can't be
        deleted.
    </p>

    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>Email</th>
                <th>Name</th>
                <th>Role</th>
                <th>Deleted at</th>
                <th class="text-end">Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{ Str::limit($user->email, 35) }}</td>
                    <td>{{ Str::limit($user->name, 40) }}</td>
                    <td>{{ $user->role->toHumanReadable() }}</td>
                    <td>
                        @if($user->deletedBy)
                            @date($user->deleted_at) ({{ $user->deletedBy->email }})
                        @else
                            N/A
                        @endif
                    </td>
                    <td class="text-end">
                        @can('restore', $user)
                            <form action="{{ route('users.restore', $user) }}" method="POST" class="d-inline-block">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        class="btn btn-sm btn-success">
                                    Restore
                                </button>
                            </form>
                        @endcan

                        @can('forceDelete', $user)
                            <x-action-buttons.delete
                                :targetUrl="route('users.force-destroy', $user)"
                                confirmSubject="user {{ $user->email }}"
                                label="Force delete"
                            />
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">
                        No deleted users found.
                        @can('create', User::class)
                            <a href="{{ route('users.create') }}">Add user</a>
                        @endcan
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
        <div class="mt-2">
            {{ $users->links() }}
        </div>
    @endif
</x-layout>
