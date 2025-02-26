<x-layout :breadcrumbs="$breadcrumbs">
    <x-slot:title>
        Deleted users
    </x-slot:title>

    <p>
        Users marked as deleted can be restored here. User must be manually re-approved after restoring. You can also
        permanently delete users. Users that are assigned to some audit action (create, last edit, delete) can't be
        deleted.
    </p>

    <form action="{{ route('users.deleted') }}" method="GET" id="filter-form">
        @if($perPageQuery)
            <input type="hidden" name="per_page" value="{{ $perPageQuery }}">
        @endif
    </form>

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
                    <td>
                        <div class="row mb-1">
                            <div class="col-2 col-form-label col-form-label-sm">
                                From
                            </div>
                            <div class="col-10">
                                <x-forms.standalone-input name="deleted_from"
                                                          class="form-control-sm"
                                                          form="filter-form"
                                                          type="date"
                                                          :defaultValue="$filters['deleted_from'] ?? null"
                                />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2 col-form-label col-form-label-sm">
                                To
                            </div>
                            <div class="col-10">
                                <x-forms.standalone-input name="deleted_to"
                                                          class="form-control-sm"
                                                          form="filter-form"
                                                          type="date"
                                                          :defaultValue="$filters['deleted_to'] ?? null"
                                />
                            </div>
                        </div>
                    </td>
                    <td class="text-end">
                        <button type="submit" class="btn btn-sm btn-outline-secondary" form="filter-form">Filter
                        </button>
                        @if ($hasActiveFilters)
                            <a href="{{ route('users.deleted', ['per_page' => $perPageQuery]) }}"
                               class="btn btn-sm btn-outline-danger">Clear</a>
                        @endif
                    </td>
                </tr>
            @endif
            </thead>
            <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{ Str::limit($user->email, 35) }}</td>
                    <td>{{ Str::limit($user->name, 40) }}</td>
                    <td>{{ $user->role->toHumanReadable() }}</td>
                    <td>
                        <x-audit-date :timestamp="$user->deleted_at"
                                      :by="$user->deletedBy"
                        />
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
                    <td colspan="5">
                        No deleted users found.
                        @if($hasActiveFilters)
                            Try <a href="{{ route('users.deleted', ['per_page' => $perPageQuery]) }}">resetting filters</a>.
                        @else
                            <a href="{{ route('users.index') }}">Show all users.</a>
                        @endif
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{ $users->links() }}
</x-layout>
