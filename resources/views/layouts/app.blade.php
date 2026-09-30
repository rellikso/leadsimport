<!DOCTYPE html>

<html lang="{{ env('APP_LOCALE') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import leads</title>
    <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
            rel="stylesheet"
    >
</head>
<body class="bg-light">

@include('partials.header')

<main class="container py-4">
    @yield('content')
</main>

@include('partials.footer')

@stack('scripts')
</body>
</html>
