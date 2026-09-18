<!doctype html>
<html lang="ru" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="verify-admitad" content="dc4273e022" />
    <meta name="yandex-verification" content="b8b6855667ee094a" />
    <meta name="google-site-verification" content="MjfvupKrSaQrV-rOKn4frxmkdqjI4Els1AHz0F5fC6M" />

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicons/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('/site.webmanifest') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>@yield('page.title', config('app.name'))</title>
    @if (!isset($exception) || $exception->getStatusCode() !== 404)
        <meta name="description" content="@yield('page.description')">
        <link rel="canonical" href="{{ url()->current() }}">
    @endif
    @livewireStyles
</head>
<body class="text-dark font-text bg-light overflow-x-hidden">
    <div class="flex flex-col h-screen">
        @include('includes.header')
        <main id="top" class="max-w-300 w-full mx-auto px-4 pb-12 mt-16 grow scroll-mt-20">
            @yield('content')
        </main>
        @include('includes.footer')
        @include('includes.topbutton')
    </div>
    @if (request()->has('cid'))
        <x-offer-modal />
    @endif
    @livewireScripts
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
        window.addEventListener('load', function () {
            (function(m,e,t,r,i,k,a){
                m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
                m[i].l=1*new Date();
                for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
                k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)
            })(window, document,'script','https://mc.yandex.ru/metrika/tag.js?id=112751477', 'ym');

            ym(112751477, 'init', {ssr:true, webvisor:true, clickmap:true, ecommerce:"dataLayer", referrer: document.referrer, url: location.href, accurateTrackBounce:true, trackLinks:true});
        });
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/112751477" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->
    @stack('scripts')
</body>
</html>
