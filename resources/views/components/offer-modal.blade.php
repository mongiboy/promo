<div>
    @if ($offer)
        <div
            x-data="{ isOpen: true }"
            x-show="isOpen"
            x-effect="document.body.classList.toggle('overflow-hidden', isOpen)"
            @keydown.escape.window="isOpen = false"
            class="fixed inset-0 z-150 bg-black/75 flex items-center justify-center px-2"
        >
            <div @click.outside="isOpen = false" class="bg-white p-6 rounded w-full max-w-md">
                <div class="text-right">
                    <button @click="isOpen = false" aria-label="Закрыть" class="font-bold text-2xl cursor-pointer">✕</button>
                </div>
                <h3 class="font-semibold text-xl/6 pb-5 text-center">{{ $offer->title }}</h3>
                <div class="bg-gray-200 rounded p-2">
                    <p class="text-center">Ваш промокод:</p>
                    <p class="text-center text-2xl font-bold">{{ $offer->promocode }}</p>
                </div>
                <button
                    type="button"
                    x-data="{ copied: false }"
                    x-on:click="
                        navigator.clipboard.writeText('{{ $offer->promocode }}');
                        copied = true;
                        setTimeout(() => copied = false, 3000);
                    "
                    :class="copied ? 'bg-white border border-accent text-accent!' : 'bg-accent text-white'"
                    class="btn mt-2"
                >
                    <span x-show="!copied">Скопировать промокод</span>
                    <span x-show="copied">Скопировано!</span>
                </button>
                <div class="mt-6">
                    {!! $offer->description !!}
                </div>
                <a href="{{$offer->url}}" rel="nofollow sponsored" target="_blank"
                   class="btn mt-6 bg-primary hover:bg-primary-dark inline-block">
                    Перейти на сайт
                </a>
            </div>
        </div>
    @endif
</div>
