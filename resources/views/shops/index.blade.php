@extends('layouts.base')

@section('page.title', 'Коды & Купоны - все магазины с промокодами и скидками')
@section('page.description', 'Найдите нужный магазин и экономьте на покупках с помощью промокодов, скидок и специальных предложений.')

@section('content')
<x-breadcrumbs :$breadcrumbs />
<nav class="mb-8">
    @if ($shops->has('0-9'))
        <x-letter :$letter :active="$shops->has($letter)" />
    @endif

    <div class="flex flex-wrap gap-2 pt-2">
        @foreach ($enAlphabet as $letter)
            <x-letter :$letter :active="$shops->has($letter)" />
        @endforeach
    </div>

    <div class="flex flex-wrap gap-2 pt-2">
        @foreach ($ruAlphabet as $letter)
            <x-letter :$letter :active="$shops->has($letter)" />
        @endforeach
    </div>
</nav>
<x-h1>Все магазины с действующими промокодами и скидками</x-h1>
<div class="mt-6">
    @foreach($shops as $letter => $shopGroup)
        <p id="letter-{{ $letter }}" class="mt-10 font-logo text-4xl font-semibold text-accent scroll-mt-20">{{ $letter }}</p>
        <div class="flex flex-wrap">
            @foreach($shopGroup as $shop)
                <div class="w-full sm:w-1/2 lg:w-1/3 xl:w-1/4 shrink-0">
                    <a href="{{ route('shops.show', $shop)  }}" class="text-xl text-primary hover:text-primary-dark">{{ $shop->name }}</a>
                </div>
            @endforeach
        </div>
    @endforeach
</div>

<div class="mt-6">
    <p class="mt-3">На этой странице собраны магазины, для которых доступны актуальные промокоды, скидки и специальные предложения. Выберите нужный магазин, чтобы посмотреть действующие промокоды и условия их использования.</p>
    <p class="mt-3">Мы регулярно обновляем предложения и добавляем новые промокоды, чтобы вы могли найти подходящую скидку перед покупкой.</p>
</div>

@endsection
