<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

    <url>
        <loc>{{ url('/') }}</loc>
    </url>

    <url>
        <loc>{{ url('/shops') }}</loc>
    </url>

    @foreach ($shops as $shop)
        <url>
            <loc>{{ url('/shops/' . $shop->slug) }}</loc>
            <lastmod>{{ $shop->sitemap_lastmod->toAtomString() }}</lastmod>
        </url>
    @endforeach

</urlset>
