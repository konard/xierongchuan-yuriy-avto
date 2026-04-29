@extends('layouts.app')

@section('content')
<main>
    <section class="section section--first index-hero">
        <div>
            <p class="eyebrow">Навигация по каталогу</p>
            <h1>{{ $title }}</h1>
            <p>Выберите посадочную страницу с локальным спросом, ценами, моделями и формой заявки для дилерского подбора.</p>
        </div>
        <div class="index-stats">
            <span>{{ $links->count() }} направлений</span>
            <span>Цены дилеров</span>
            <span>Кредит и trade-in</span>
        </div>
    </section>

    <section class="section">
        <h2>Доступные страницы</h2>
        <div class="cards cards--links">
            @foreach ($links as $link)
                <article class="card">
                    <div class="badge">SEO страница</div>
                    <h3>{{ $link['label'] }}</h3>
                    <p>Коммерческий экран с моделями, локальным интентом, заявкой и перелинковкой.</p>
                    <a href="{{ $link['url'] }}">Открыть подбор</a>
                </article>
            @endforeach
        </div>
    </section>
</main>
@endsection
