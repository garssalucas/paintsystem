<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <header>
        <h1>Header</h1>
    </header>
    <main>
        @yield('content')
    </main>
    <footer>
        <h1>Footer</h1>
    </footer>
</body>
</html>