<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Vojtěch Sillik">
    <title>{{ config('app.name') }}</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div class="vh-100 d-flex flex-column">
        {{ $slot }}
    </div>
</body>
</html>