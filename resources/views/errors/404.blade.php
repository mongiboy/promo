@extends('layouts.base')

@section('page.title', 'Страница не найдена — Коды & Купоны')

@section('content')
    <div class="flex justify-center items-center w-full h-full flex-col">
        <p class="text-9xl text-primary font-bold font-logo">404</p>
        <p class="text-center">Возможно, страница была удалена или адрес указан неверно.</p>
        <p class="text-center mt-4">Попробуйте найти нужный магазин:</p>
        <div class="flex justify-center mt-2">
            @livewire('search', key('search-hero'))
        </div>
        <a href="{{ route('shops.index') }}" class="text-center text-primary hover:text-primary-dark font-bold mt-8">Все магазины</a>
    </div>
@endsection
<script>
    /*
    trackGoal('404_page', {
        url: window.location.pathname,
    });
    */
</script>
