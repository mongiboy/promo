<!doctype html>
<html lang="ru" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="verify-admitad" content="dc4273e022" />

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
</body>
</html>
