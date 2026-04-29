@extends('layouts.app')

@section('content')
<main>
    <section class="section section--first">
        <h1>{{ $title }}</h1>
        <div class="landing-grid">
            @foreach ($links as $link)
                <a href="{{ $link['url'] }}">{{ $link['label'] }}</a>
            @endforeach
        </div>
    </section>
</main>
@endsection
