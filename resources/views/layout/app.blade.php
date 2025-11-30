<!DOCTYPE html><html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Films HDD - фильмы на жестком диске')</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Films HDD - фильмы на жестком диске. Лучшие коллекции фильмов без подписок, рекламы и интернета!">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="icon" href="{{ asset('/name.png') }}">
</head>

<body>

{{-- Header --}}
@include('layout.header')

<main class="content">
    @yield('content')
</main>

{{-- Footer --}}
@include('layout.footer')

{{-- Подключение JS --}}
<script src="{{ asset('js/cart.js') }}"></script>
<script src="{{ asset('js/script.js') }}"></script>


</body>
</html>

