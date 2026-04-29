@extends('layouts.app')

@section('content')
<main>
    <section class="hero hero--compact">
        <div class="hero__copy">
            <p class="eyebrow">{{ $city['region'] }}</p>
            <span data-react-lead-status></span>
            <h1>Купить {{ $brand['name'] }} в {{ $city['where'] }}</h1>
            <p>{{ $description }}</p>
            <a class="primary" href="#lead">Получить предложения дилеров</a>
        </div>
        <div class="hero__panel">
            <span>Цена от {{ number_format($brand['min_price'], 0, ',', ' ') }} ₽</span>
            <span>{{ count($brand['models']) }} модели</span>
            <span>Подбор за 15 минут</span>
        </div>
    </section>

    <section class="section">
        <h2>Популярные модели {{ $brand['name'] }}</h2>
        <div class="cards">
            @foreach ($brand['models'] as $model)
                <article class="card">
                    <div class="badge">В наличии</div>
                    <h3>{{ $brand['name'] }} {{ $model }}</h3>
                    <p>от {{ number_format($brand['min_price'] + $loop->index * 270000, 0, ',', ' ') }} ₽ · гарантия дилера · ПТС в наличии</p>
                    <a href="#lead">Запросить цену</a>
                </article>
            @endforeach
        </div>
    </section>

    <section class="section two-col">
        <div>
            <h2>Почему это удобно</h2>
            <p>Страница закрывает коммерческий спрос по марке и городу: содержит точный title, description, H1, локальный интент, FAQ, перелинковку и sitemap.</p>
        </div>
        <form id="lead" class="lead">
            <input placeholder="Ваше имя" aria-label="Ваше имя">
            <input placeholder="Телефон" aria-label="Телефон">
            <button>Получить расчет</button>
        </form>
    </section>

    <section class="section">
        <h2>Вопросы о {{ $brand['name'] }} в {{ $city['where'] }}</h2>
        <details>
            <summary>Какие модели доступны?</summary>
            <p>В подборке есть {{ implode(', ', $brand['models']) }} и близкие комплектации у официальных дилеров.</p>
        </details>
        <details>
            <summary>Можно ли оформить кредит?</summary>
            <p>Да, заявка передается дилерам и банкам-партнерам для расчета ежемесячного платежа.</p>
        </details>
        <details>
            <summary>Как проверить цену?</summary>
            <p>Оставьте заявку: менеджер сверит наличие, скидки, trade-in и финальную стоимость.</p>
        </details>
    </section>
</main>
@endsection
