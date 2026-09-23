<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'BeriPeduli' }}</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logosetengah-transparent.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logosetengah-transparent.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logosetengah-transparent.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-800">

    @include('partials.navbar')

    <main>
        {{ $slot ?? '' }}
        @yield('content')
    </main>

    @include('partials.footer')

</body>

</html>