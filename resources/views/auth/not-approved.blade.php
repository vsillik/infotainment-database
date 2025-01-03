<x-guest-layout>
    <x-slot:title>Access restricted</x-slot:title>

    <p>To access the application your account needs to be approved by the application administrator first.</p>

    <form action="{{ route('logout') }}" method="POST" class="d-inline-block">
        @csrf

        <button type="submit" class="btn btn-link btn-sm">Log out</button>
    </form>

</x-guest-layout>
