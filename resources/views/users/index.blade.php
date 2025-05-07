@php
    use App\Enums\UserRole;
    use App\Models\User;
    use Illuminate\Support\Str;
@endphp
<x-layout :breadcrumbs="$breadcrumbs">
    <x-slot:title>
        Users
    </x-slot:title>

    <p>
        Default admin user can't be deleted and can't be unapproved.
        You can mark the user as deleted, this will prevent the user from logging in and showing up in infotainment
        assignments. Deleting will also mark the user as unapproved. If you accidentally delete an user, you can
        recover the account on <a href="{{ route('users.deleted') }}">Show deleted</a> page, you can also permanently
        delete the user from this application there.
    </p>

    @can('create', User::class)
        <x-action-buttons.create :targetUrl="route('users.create')" label="Create user"/>
    @endcan

    <a class="btn btn-secondary mb-2" href="{{ route('users.deleted') }}">Show deleted</a>

    <form action="{{ route('users.index') }}" method="GET" id="filter-form">
        @if($perPageQuery)
            <input type="hidden" name="per_page" value="{{ $perPageQuery }}">
        @endif
    </form>

    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>Email</th>
                <th>Approved</th>
                <th>Name</th>
                <th>Role</th>
                <th class="text-end">Actions</th>
            </tr>
            @if(count($users) > 0 || $hasActiveFilters)
                <tr class="align-top">
                    <td>
                        <x-forms.standalone-input name="email"
                                                  class="form-control-sm"
                                                  form="filter-form"
                                                  :defaultValue="$filters['email'] ?? null"
                        />
                    </td>
                    <td>
                        <x-forms.radio name="approved"
                                       value="any"
                                       label="Any"
                                       form="filter-form"
                                       class="small"
                                       :isCheckedByDefault="!in_array($filters['approved'] ?? null, ['yes', 'no'])"
                        />

                        <x-forms.radio name="approved"
                                       value="yes"
                                       label="Approved"
                                       form="filter-form"
                                       class="small"
                                       :isCheckedByDefault="($filters['approved'] ?? null) === 'yes'"
                        />

                        <x-forms.radio name="approved"
                                       value="no"
                                       label="Unapproved"
                                       form="filter-form"
                                       class="small"
                                       :isCheckedByDefault="($filters['approved'] ?? null) === 'no'"
                        />
                    </td>
                    <td>
                        <x-forms.standalone-input name="name"
                                                  class="form-control-sm"
                                                  form="filter-form"
                                                  :defaultValue="$filters['name'] ?? null"
                        />
                    </td>
                    <td>
                        <x-forms.standalone-select
                            name="user_role"
                            :options="$userRoles"
                            :defaultValue="($filters['user_role'] ?? 'any')"
                            class="form-select-sm"
                            form="filter-form"
                        />
                    </td>
                    <td class="text-end">
                        <button type="submit" class="btn btn-sm btn-outline-secondary" form="filter-form">Filter
                        </button>
                        @if ($hasActiveFilters)
                            <a href="{{ route('users.index', ['per_page' => $perPageQuery]) }}"
                               class="btn btn-sm btn-outline-danger">Clear</a>
                        @endif
                    </td>
                </tr>
            @endif
            </thead>
            <tbody>
            @forelse($users as $user)
                <tr>
                    <td>
                        <x-shorten-text :text="$user->email" />
                    </td>
                    <td>
                        @if($user->is_approved)
                            <span class="badge rounded-pill text-bg-success">Approved</span>
                        @else
                            <span class="badge rounded-pill text-bg-danger">Unapproved</span>
                        @endif
                    </td>
                    <td><x-shorten-text :text="$user->name" /></td>
                    <td>{{ $user->role->toHumanReadable() }}</td>
                    <td class="text-end">
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

                        @can('view', $user)
                            <x-action-buttons.show :targetUrl="route('users.show', $user)"/>
                        @endcan

                        @can('update', $user)
                            <x-action-buttons.edit :targetUrl="route('users.edit', $user)"/>
                        @endcan

                        @can('delete', $user)
                            <x-action-buttons.delete
                                :targetUrl="route('users.destroy', $user)"
                                confirmSubject="user {{ $user->email }}"/>
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">
                        No user found.
                        @if($hasActiveFilters)
                            Try <a href="{{ route('users.index', ['per_page' => $perPageQuery]) }}">resetting filters</a>.
                        @else
                            @can('create', User::class)
                                <a href="{{ route('users.create') }}">Add user</a>
                            @endcan
                        @endif
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{ $users->links() }}
</x-layout>
