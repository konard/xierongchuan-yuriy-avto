@extends('layouts.app')

@section('content')
<main>
    <section class="hero">
        <div class="hero__copy">
            <p class="eyebrow">Автомобили от официальных дилеров</p>
            <h1>Новые авто по маркам и городам</h1>
            <p>SEO-каталог с посадочными страницами для спроса вида “купить Geely в Москве”, “цены Haval в Казани” и похожих коммерческих запросов.</p>
            <form class="search" action="{{ route('landings.show', ['brand' => 'geely', 'city' => 'moskva']) }}">
                <select aria-label="Марка">
                    @foreach ($brands as $brand)
                        <option>{{ $brand['name'] }}</option>
                    @endforeach
                </select>
                <select aria-label="Город">
                    @foreach ($cities as $city)
                        <option>{{ $city['name'] }}</option>
                    @endforeach
                </select>
                <button>Показать предложения</button>
            </form>
        </div>
        <div class="hero__panel" aria-label="Сводка предложений">
            <span>{{ $brands->count() }} марок</span>
            <span>{{ $cities->count() }} городов</span>
            <span>{{ $landingLinks->count() }} SEO страниц</span>
        </div>
    </section>

    <section id="offers" class="section">
        <h2>Лучшие предложения</h2>
        <div class="cards">
            @foreach ($brands as $brand)
                @php($city = $cities[$loop->index % $cities->count()])
                <article class="card">
                    <div class="badge">{{ $city['name'] }}</div>
                    <h3>{{ $brand['name'] }} {{ $brand['models'][0] }}</h3>
                    <p>от {{ number_format($brand['min_price'], 0, ',', ' ') }} ₽, кредит от 4,9%, trade-in и резерв у дилера.</p>
                    <a href="{{ route('landings.show', ['brand' => $brand['slug'], 'city' => $city['slug']]) }}">Смотреть {{ $brand['name'] }} в {{ $city['name'] }}</a>
                </article>
            @endforeach
        </div>
    </section>

    <section id="brands" class="section">
        <h2>Марки новых авто</h2>
        <div class="link-grid">
            @foreach ($brands as $brand)
                <a href="{{ route('brands.show', $brand['slug']) }}">{{ $brand['name'] }} от {{ number_format($brand['min_price'], 0, ',', ' ') }} ₽</a>
            @endforeach
        </div>
    </section>

    <section id="cities" class="section">
        <h2>Города</h2>
        <div class="link-grid">
            @foreach ($cities as $city)
                <a href="{{ route('cities.show', $city['slug']) }}">{{ $city['name'] }} · {{ $city['region'] }}</a>
            @endforeach
        </div>
    </section>

    <section class="section">
        <h2>Посадочные страницы</h2>
        <div class="landing-grid">
            @foreach ($landingLinks as $link)
                <a href="{{ $link['url'] }}">{{ $link['label'] }}</a>
            @endforeach
        </div>
    </section>
</main>
@endsection
