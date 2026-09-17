@props([
    'letter',
    'active' => true,
])

@if($active)
    <a href="#letter-{{ $letter }}" class="text-2xl font-semibold bg-white px-3 shadow rounded-md text-primary hover:text-primary-dark hover:scale-110 transition duration-300">
        {{ $letter }}
    </a>
@endif

{{--
@if($active)
    <a href="#letter-{{ $letter }}" class="text-2xl font-semibold text-primary hover:text-primary-dark">{{ $letter }}</a>
@else
    <span class="text-2xl font-semibold text-gray-300">{{ $letter }}</span>
@endif
--}}
