@php use App\Models\InfotainmentManufacturer;use App\Models\SerializerManufacturer; @endphp
<x-base-layout>
    <header class="navbar bg-dark flex-md-nowrap p-1 shadow" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6 text-white" href="#">{{ config('app.name') }}</a>

            <div class="dropdown">
                <a href="#" class="d-block link-light text-decoration-none dropdown-toggle" id="dropdownUser"
                   data-bs-toggle="dropdown" aria-expanded="false">
                    {{ Auth::user()->name }}
                </a>
                <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end text-small" aria-labelledby="dropdownUser">
                    <li>
                        <a href="{{ route('profile.edit') }}" class="dropdown-item link-light">Profile settings</a>
                    </li>
                    <li>
                        <a href="{{ route('profile.password.edit') }}" class="dropdown-item link-light">Change password</a>
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
        </div>
    </header>

    <div class="container-fluid h-100 flex-grow-1">
        <div class="row">
            <div class="sidebar border border-right col-md-2 col-lg-1 p-0 bg-body-tertiary">
                <div class="offcanvas-md offcanvas-end bg-body-tertiary" tabindex="-1" id="sidebarMenu"
                     aria-labelledby="sidebarMenuLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="sidebarMenuLabel">{{ config('app.name') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                data-bs-target="#sidebarMenu" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center gap-2 active" aria-current="page"
                                   href="{{ route('index') }}">
                                    Home
                                </a>
                            </li>

                            @can('viewAny', InfotainmentManufacturer::class)
                                <li class="nav-item">
                                    <a class="nav-link d-flex align-items-center gap-2"
                                       href="{{ route('infotainment_manufacturers.index') }}">
                                        Infotainment manufacturers
                                    </a>
                                </li>
                            @endcan

                            @can('viewAny', SerializerManufacturer::class)
                                <li class="nav-item">
                                    <a class="nav-link d-flex align-items-center gap-2"
                                       href="{{ route('serializer_manufacturers.index') }}">
                                        Serializer manufacturers
                                    </a>
                                </li>
                            @endcan

                            @can('viewAny', \App\Models\Infotainment::class)
                                <li class="nav-item">
                                    <a class="nav-link d-flex align-items-center gap-2"
                                       href="{{ route('infotainments.index') }}">
                                        Infotainments
                                    </a>
                                </li>
                            @endcan

                            @can('viewAny', \App\Models\User::class)
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center gap-2"
                                   href="{{ route('users.index') }}">
                                    Users
                                </a>
                            </li>
                            @endcan

                            <!--
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center gap-2" href="#">
                                    Preferences
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center gap-2" href="#">
                                    Site settings
                                </a>
                            </li>
                            -->
                        </ul>
                    </div>
                </div>
            </div>

            <main class="col-md-10 ms-sm-auto col-lg-11 px-md-4 pb-3">
                @if(isset($title))
                    <div
                        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1>{{ $title }}</h1>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
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
