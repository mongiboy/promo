@props([
    'offer',
    'showLogo' => true,
    'showDescription' => false
])

<a class="offer flex flex-col basis-full md:basis-1/2 lg:basis-1/3 border-black/10 shadow-lg transition duration-300 ease-in-out hover:shadow-xl rounded-lg bg-white py-9 px-4 lg:px-9 offer"
   href="{{ route('offer.redirect', $offer) }}" rel="nofollow sponsored" data-id="{{$offer->id}}" {{ $offer->promocode ? 'data-coupon' : 'target="_blank"' }}>
    @if($showLogo)
    <div class="mx-5 lg:mx-0 h-20 flex justify-center mb-6">
        <img class="" src="{{ asset('storage/shops/' . $offer->shop->logo) }}" alt="{{ $offer->shop->name }}">
    </div>
    @endif

    <h3 class="font-semibold text-xl/6">{{ $offer->title }}</h3>
    @if($showDescription)
        <div class="mt-2">
            {!! $offer->description !!}
        </div>
    @endif

    <p class="mt-auto pt-6 text-text/70 text-center">до {{ $offer->expires_at ? $offer->expires_at->format('d.m.Y') : now()->endOfMonth()->format('d.m.Y') }}</p>

    <span class="mt-6 btn bg-primary hover:bg-primary-dark">
        {{$offer->promocode ? 'Показать промокод' : 'Открыть акцию'}}
    </span>
</a>
