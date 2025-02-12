<x-guest-layout>
    <x-slot:title>Log in</x-slot:title>

    <p class="text-secondary">Don't have account yet? <a href="{{ route('register') }}">Register</a></p>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <x-forms.errors-alert :errors="$errors" />

        <x-forms.input
            name="email"
            type="email"
            label="Email"
            required="true"
        />

        <x-forms.input
            name="password"
            type="password"
            label="Password"
            required="true"
        />

        <x-forms.checkbox
            name="remember_me"
            label="Remember me"
        />

        <x-forms.required-note />

        <div class="mb-2">
            <a href="{{ route('password.request') }}">Forgot your password?</a>
        </div>

        <button type="submit" class="btn btn-primary">Log in</button>
    </form>
</x-guest-layout>
