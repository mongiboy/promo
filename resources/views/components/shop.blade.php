@props(['shop'])

<div class="swiper-slide pb-1 lg:pb-10">
    <a href="{{ asset("shops/{$shop->slug}") }}"
       class="flex items-center justify-center w-full h-full px-4 py-6
       border-black/10 shadow-sm lg:shadow-md transition duration-300 ease-in-out rounded-lg bg-white
        hover:shadow-lg hover:translate-y-px">
        <img class="h-full" src="{{ asset('storage/shops/' . $shop->logo) }}" alt="{{ $shop->name }}">
        <span></span>
    </a>
</div>
