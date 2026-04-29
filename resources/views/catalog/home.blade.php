@extends('layouts.app')

@section('content')
<main>
    <section class="hero">
        <div class="hero__copy">
            <p class="eyebrow">Новые автомобили от официальных дилеров</p>
            <h1>Подбор авто по марке, городу и реальной цене</h1>
            <p>Коммерческие посадочные страницы для заявок на новые Geely, Haval, Chery, LADA, OMODA и Tank с локальными дилерами, кредитом и trade-in.</p>
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
        <div class="hero__visual" aria-label="Витрина автомобилей">
            <div class="car-plate">
                <span class="car-plate__roof"></span>
                <span class="car-plate__body"></span>
                <span class="car-plate__wheel car-plate__wheel--left"></span>
                <span class="car-plate__wheel car-plate__wheel--right"></span>
            </div>
            <div class="hero__panel" aria-label="Сводка предложений">
                <span>{{ $brands->count() }} марок</span>
                <span>{{ $cities->count() }} городов</span>
                <span>{{ $landingLinks->count() }} SEO страниц</span>
            </div>
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
                    <p>{{ $brand['body'] }}, {{ $brand['power'] }}. От {{ number_format($brand['min_price'], 0, ',', ' ') }} ₽, кредит от 4,9%, trade-in и резерв у дилера.</p>
                    <div class="card__meta">
                        <span>{{ $brand['stock'] }} авто</span>
                        <span>ПТС в наличии</span>
                    </div>
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
