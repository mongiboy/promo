@extends('layouts.base')

@section('page.title', 'Коды & Купоны - сервис актуальных промокодов, скидок и акций')
@section('page.description', 'Экономьте на покупках с помощью промокодов, скидок и акций. Находите выгодные предложения магазинов и используйте их при оформлении заказа.')

@section('content')
    <div class="hero relative left-1/2 pb-5 xl:pb-20 pt-40 xl:pt-80 mx-[-50vw] w-screen bg-primary">
        <div class="block absolute inset-y-0 right-0 w-full bg-accent [clip-path:polygon(0_0,100%_0,100%_80%,0_20%)]"></div>
        <div class="relative z-10 max-w-300 w-full mx-auto px-4 pb-12">
            <div class="max-w-2xl mx-auto">
                <h1 class="font-logo font-bold text-3xl xl:text-5xl text-center">Покупай <span class="italic">выгодно</span> с&nbsp;актуальными промокодами</h1>
                <div class="flex justify-center mt-4">
                    @livewire('search', key('search-hero'))
                </div>
            </div>
            <div class="flex justify-around mt-10 xl:mt-20">
                <div>
                    <p class="text-3xl/7 xl:text-[40px]/7 font-logo text-accent text-center">{{ round($allShops /100, 1) * 100 }}+</p>
                    <p class="xl:text-2xl font-logo">магазинов</p>
                </div>
                <div>
                    <p class="text-3xl/7 xl:text-[40px]/7 font-logo text-accent text-center">{{ round($allOffers /100, 1) * 100 }}+</p>
                    <p class="xl:text-2xl font-logo">промокодов</p>
                </div>

            </div>
        </div>
    </div>


    <x-h2>Популярные магазины</x-h2>
    <x-shops>
        @foreach($popularShops as $popularShop)
            <x-shop :shop="$popularShop" />
        @endforeach
    </x-shops>

    <x-h2>Популярные промокоды</x-h2>
    <x-cards>
        @foreach($popularOffers as $popularOffer)
            <x-card :offer="$popularOffer" />
        @endforeach
    </x-cards>

    <x-h2>Новые промокоды</x-h2>
    <x-cards>
        @foreach($latestOffers as $latestOffer)
            <x-card :offer="$latestOffer" />
        @endforeach
    </x-cards>

    <x-h2>Промокоды и скидки в интернет-магазинах</x-h2>
    <p class="mt-4">Находите актуальные промокоды и выгодные предложения популярных интернет-магазинов. Мы собираем промокоды в одном месте, чтобы перед покупкой вы могли быстро проверить доступные способы сэкономить.</p>
    <p class="mt-2">Выбирайте магазин, находите подходящий промокод и переходите к покупке с выгодой. Предложения обновляются по мере появления новых промокодов и изменений у магазинов.</p>
@endsection
