<!doctype html>
<html lang="sk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Auto Inventory</title>

    {{-- Bootstrap z CDN, žiadny Vite --}}
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
        crossorigin="anonymous">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-dark navbar-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="{{ route('cars.index') }}">Auto Inventory</a>
        <div class="navbar-nav">
            <a class="nav-link {{ request()->is('cars*') ? 'active' : '' }}" href="{{ route('cars.index') }}">Cars</a>
            <a class="nav-link {{ request()->is('parts*') ? 'active' : '' }}" href="{{ route('parts.index') }}">Parts</a>
        </div>
    </div>
</nav>

<main class="container mb-5">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
</html>
