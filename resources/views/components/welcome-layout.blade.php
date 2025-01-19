<x-layout :breadcrumbs="$breadcrumbs">
    <x-slot:title>
        Home
    </x-slot:title>

    <p>Welcome to the <i>{{ config('app.name') }}</i> application, where you can download infotainment profile data in an E-EDID file format.</p>

    {{ $slot }}
</x-layout>
