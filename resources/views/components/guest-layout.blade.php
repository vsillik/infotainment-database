<x-base-layout>
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="container">
            <h1 class="text-center">Infotainment database</h1>

            <div class="row justify-content-center mt-3">
                <div class="col-md-6 bg-light p-3 border rounded">
                    @if(isset($title))
                        <h2>{{ $title }}</h2>
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
                </div>
            </div>
        </div>
    </div>
</x-base-layout>
