@props(['breadcrumbs'])

<div class="flex text-sm/4 flex-wrap pt-2">
    <div class="flex">
        <a class="text-primary hover:text-primary-dark" href="{{ route('main') }}">Главная</a>
        <span class="text-accent mx-1">/</span>
    </div>
    @foreach($breadcrumbs as $breadcrumb)
        @if ($loop->last)
            <span class="">{{ $breadcrumb['title'] }}</span>
        @else
            <div class="flex">
                <a class="text-primary hover:text-primary-dark" href="{{ $breadcrumb['route'] }}">{{ $breadcrumb['title'] }}</a>
                <span class="text-accent mx-1">/</span>
            </div>
        @endif
    @endforeach
</div>

<script type="application/ld+json">
    {!! json_encode([
        '@@context' => 'https://schema.org',
        '@@type' => 'BreadcrumbList',
        'itemListElement' => collect($breadcrumbs)->prepend(['title' => 'Главная', 'route' => route('main')])
            ->values()
            ->map(fn ($item, $index) => [
                '@@type' => 'ListItem',
                'position' => $index + 1,
                'item' => [
                    '@@id' => $item['route'],
                    'name' => $item['title'],
                ],
            ])->all(),
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>
