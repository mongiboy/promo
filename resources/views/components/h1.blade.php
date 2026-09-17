@props(['align'=> 'center' ])

<h1 class="text-3xl text-{{ $align }} font-bold mt-12">
    {{ $slot }}
</h1>
