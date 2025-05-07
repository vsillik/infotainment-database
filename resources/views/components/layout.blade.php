@php
    use App\Models\Infotainment;
    use App\Models\InfotainmentManufacturer;
    use App\Models\SerializerManufacturer;
    use App\Models\User;
@endphp

<x-base-layout>
    <header class="navbar bg-dark flex-md-nowrap p-1 shadow" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand col-md-3 col-lg-2 me-0 pe-3 fs-6 text-white"
               href="{{ route('index') }}">{{ config('app.name') }}</a>

            <div class="d-flex ms-auto align-items-center">
                <div class="dropdown">
                    <a href="#" class="d-block link-light text-decoration-none dropdown-toggle" id="dropdownUser"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>

                    <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end text-small"
                        aria-labelledby="dropdownUser">
                        <li>
                            <a href="{{ route('profile.edit') }}" class="dropdown-item link-light">
                                Profile settings
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('profile.password.edit') }}" class="dropdown-item link-light">
                                Change password
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf

                                <button type="submit" class="dropdown-item link-light">Log out</button>
                            </form>
                        </li>
                    </ul>
                </div>

                <button class="navbar-toggler d-lg-none ms-3" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#sidebarMenu"
                        aria-controls="sidebarMenu" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </div>
    </header>

    <div class="container-fluid flex-grow-1">
        <div class="row h-100">
            <div class="border border-right col-auto offcanvas-lg offcanvas-end py-0 px-2 bg-body-tertiary"
                 tabindex="-1" id="sidebarMenu"
                 aria-labelledby="sidebarMenuLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="sidebarMenuLabel">{{ config('app.name') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                            data-bs-target="#sidebarMenu" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body d-md-flex flex-column pb-3 pt-md-3 overflow-y-auto">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item">
                            <a @class([
                                       'nav-link',
                                       'd-flex',
                                       'align-items-center',
                                       'gap-2',
                                       'mt-1',
                                       'active' => request()->routeIs('index')
                                   ])
                               @if(request()->routeIs('index'))
                                   aria-current="page"
                               @endif
                               href="{{ route('index') }}"
                            >
                                Home
                            </a>
                        </li>

                        @can('viewAny', InfotainmentManufacturer::class)
                            <li class="nav-item">
                                <a @class([
                                           'nav-link',
                                           'd-flex',
                                           'align-items-center',
                                           'gap-2',
                                           'mt-1',
                                           'active' => request()->routeIs('infotainment_manufacturers.*')
                                       ])
                                   @if(request()->routeIs('infotainment_manufacturers.*'))
                                       aria-current="page"
                                   @endif
                                   href="{{ route('infotainment_manufacturers.index') }}"
                                >
                                    Infotainment manufacturers
                                </a>
                            </li>
                        @endcan

                        @can('viewAny', SerializerManufacturer::class)
                            <li class="nav-item">
                                <a @class([
                                           'nav-link',
                                           'd-flex',
                                           'align-items-center',
                                           'gap-2',
                                           'mt-1',
                                           'active' => request()->routeIs('serializer_manufacturers.*')
                                       ])
                                   @if(request()->routeIs('serializer_manufacturers.*'))
                                       aria-current="page"
                                   @endif
                                   href="{{ route('serializer_manufacturers.index') }}"
                                >
                                    Serializer manufacturers
                                </a>
                            </li>
                        @endcan

                        @can('viewAny', Infotainment::class)
                            <li class="nav-item">
                                <a @class([
                                           'nav-link',
                                           'd-flex',
                                           'align-items-center',
                                           'gap-2',
                                           'mt-1',
                                           'active' => request()->routeIs('infotainments.*')
                                       ])
                                   @if(request()->routeIs('infotainments.*'))
                                       aria-current="page"
                                   @endif
                                   href="{{ route('infotainments.index') }}"
                                >
                                    Infotainments
                                </a>
                            </li>
                        @endcan

                        @can('viewAny', User::class)
                            <li class="nav-item">
                                <a @class([
                                           'nav-link',
                                           'd-flex',
                                           'align-items-center',
                                           'gap-2',
                                           'mt-1',
                                           'active' => request()->routeIs('users.*')
                                       ])
                                   @if(request()->routeIs('users.*'))
                                       aria-current="page"
                                   @endif
                                   href="{{ route('users.index') }}"
                                >
                                    Users
                                </a>
                            </li>
                        @endcan
                    </ul>
                </div>
            </div>

            <main class="col px-md-4 pb-3">
                @if(count($breadcrumbs) > 0)
                    <nav class="mt-3" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            @foreach($breadcrumbs as $url => $breadcrumb)
                                <li @class([
                                    'breadcrumb-item',
                                    'active' => $loop->last
                                    ])
                                    @if ($loop->last)
                                        aria-current="page"
                                    @endif
                                >
                                    @unless($loop->last)
                                        <a href="{{ $url }}">
                                            @endunless

                                            <x-shorten-text :text="$breadcrumb" />

                                            @unless($loop->last)
                                        </a>
                                    @endunless
                                </li>
                            @endforeach
                        </ol>
                    </nav>
                @else
                    <div class="mt-3"></div>
                @endif

                @if(isset($title))
                    <div
                        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                        <h1>{{ $title }}</h1>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success text-break">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger text-break">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="main-content-wrapper mt-3">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
</x-base-layout>
