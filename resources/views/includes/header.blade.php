<header class="fixed top-0 left-0 right-0 z-50 bg-primary shadow-md ">
    <div class="max-w-300 w-full mx-auto p-4 flex justify-center relative">
        <a href="/">
            <span class="font-logo text-2xl">Коды<span class="text-accent">&</span>Купоны</span>
        </a>
        <div x-data="{ open: false }" class="lg:hidden">
            <button aria-label="Поиск" @click="open = !open" class="focus:outline-none block absolute top-1/2 right-6 -translate-y-1/2">
                <x-heroicon-s-magnifying-glass class="w-6 h-6 text-accent" stroke-width="2"/>
            </button>
            <div x-show="open" @click.away="open = false" x-transition
                 class="absolute top-0 right-0 bg-primary z-60 w-full h-full flex mx-auto p-4 gap-2">
                <div class="grow">
                    @livewire('search', key('search-mobile'))
                </div>
                <button @click="open = !open" class="focus:outline-none block">
                    <x-heroicon-s-plus class="w-6 h-6 text-accent rotate-45" stroke-width="2"/>
                </button>
            </div>
        </div>

        <div class="hidden lg:block absolute top-1/2 right-4 -translate-y-1/2">
            @livewire('search', key('search-desktop'))
        </div>
    </div>
</header>
