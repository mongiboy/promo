<div class="shops-search relative w-full md:w-80 md:mt-0">
    <input type="text" name="shops-search" class="bg-white rounded-md outline-0 px-8 py-2 w-full text-gray-500" wire:model.live="query" placeholder="Поиск магазинов" />
    <span class="search-icon absolute left-1 top-1/2 transform -translate-y-1/2 ml-1">
        <x-heroicon-m-magnifying-glass class="w-5 h-5 text-accent" />
    </span>
    @if($shops)
        <ul class="bg-white absolute top-9 left-0 rounded-md shadow-md overflow-hidden w-full z-10">
            @foreach($shops as $shop)
                <li class="pl-4 py-2">
                    <a href="{{ route('shops.show', $shop) }}" data-search-shop="{{$shop->name}}" class="flex flex-row items-center">
                        <img src="{{ asset('storage/shops/' . $shop->logo) }}" alt="{{$shop->name}}" width="60" class="max-h-6 object-contain pe-4">
                        <span class="font-medium">{{ $shop->name }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
</div>
