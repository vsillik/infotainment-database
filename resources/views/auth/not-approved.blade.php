<x-guest-layout>
    <x-slot:title>Access restricted</x-slot:title>

    @if($user?->trashed())
        <p>Your account has been deleted. If you think this is a mistake, please contact application administrator.</p>
    @else
        <p>To access the application your account needs to be first approved by the application administrator.</p>
    @endif

    <form action="{{ route('logout') }}" method="POST" class="d-inline-block">
        @csrf

        <button type="submit" class="btn btn-secondary btn-sm">Log out</button>
    </form>

</x-guest-layout>
