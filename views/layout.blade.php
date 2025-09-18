<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <title>@yield('title', 'My App')</title> -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header>
        <!-- <h1>My App</h1> -->
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <!-- <p>&copy; {{ date('Y') }} My App</p> -->
    </footer>
</body>
</html>
