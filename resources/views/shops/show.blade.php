@extends('layouts.base')

@section('page.title', 'Промокоды и скидки ' . $shop->name . ' — актуальные акции и предложения')
@section('page.description',
'Экономьте на покупках с помощью промокодов и скидок для магазина ' . $shop->name .'. Здесь собраны выгодные предложения, доступные при оформлении заказа.')

@section('content')
    <x-breadcrumbs :$breadcrumbs />
    <div class="flex flex-col gap-2 pt-2 items-center lg:flex-row lg:gap-8 lg:justify-between">
        <div class="w-full max-w-80 min-h-20 flex items-center overflow-hidden">
            <img class="w-full h-fit my-auto" src="{{ asset('storage/shops/' . $shop->logo) }}" alt="{{ $shop->name }}">
        </div>
        <div class="mt-4">
            <h1 class="text-3xl/8 font-bold">Промокоды {{ $shop->name }} на&nbsp;{{ now()->translatedFormat('F Y') }}</h1>
            <p class="mt-2">Найдено активных промокодов: {{ $offers->count() }}</p>
        </div>
    </div>

    <h2 class="sr-only">Актуальные промокоды и скидки {{ $shop->name }}</h2>
    <x-cards>
        @foreach($offers as $offer)
            <x-card :$offer :showLogo="false" :show-description="true"/>
        @endforeach
    </x-cards>

    @if($similarShops->isNotEmpty())
        <x-h2>Похожие магазины</x-h2>
        <x-shops>
            @foreach($similarShops as $similarShop)
                <x-shop :shop="$similarShop" />
            @endforeach
        </x-shops>
    @endif

    <div class="description mt-12">{!! $shop->seo_text !!}</div>

@endsection
