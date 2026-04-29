<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $metaTitle }}</title>
    <meta name="description" content="{{ $metaDescription }}">
    <link rel="canonical" href="{{ $canonical }}">
    @viteReactRefresh
    @vite(['resources/css/app.css', 'resources/js/app.jsx'])
</head>
<body>
    <header class="topbar">
        <a class="brand" href="{{ route('home') }}">{{ $contacts['site_name'] }}</a>
        <nav aria-label="Основная навигация">
            <a href="{{ route('home') }}#brands">Марки</a>
            <a href="{{ route('home') }}#cities">Города</a>
            <a href="{{ route('home') }}#offers">Предложения</a>
            <a href="{{ route('sitemap') }}">Sitemap</a>
        </nav>
        <a class="phone" href="tel:+78005551488">{{ $contacts['phone'] }}</a>
    </header>

    @yield('content')

    <footer class="footer">
        <strong>{{ $contacts['site_name'] }}</strong>
        <span>Новые автомобили от официальных дилеров, кредит, trade-in и подбор под бюджет.</span>
        <a href="mailto:{{ $contacts['email'] }}">{{ $contacts['email'] }}</a>
    </footer>
</body>
</html>
