<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Könyvtár Laravel</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
<nav class="navbar">
    <ul class="nav-list">
        <li><a href="{{ route('books.index') }}" class="nav-button">📚 Könyvek</a></li>
        <li><a href="{{ route('writers.index') }}" class="nav-button">✍️ Írók</a></li>
        <li><a href="{{ route('publishers.index') }}" class="nav-button">🏢 Kiadók</a></li>
        <li><a href="{{ route('categories.index') }}" class="nav-button">🏷️ Kategóriák</a></li>
    </ul>
</nav>

<main class="container">
    @if(session('success'))
        <div class="alert success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert error">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    @yield('content')
</main>

<footer>
    <hr>
    <p>Created by: Oszaczki Csaba</p>
</footer>

<script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
