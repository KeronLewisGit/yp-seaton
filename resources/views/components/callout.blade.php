@props(['n', 'sub' => 'YPS'])
<span {{ $attributes->merge(['class' => 'callout']) }} aria-hidden="true"><b>{{ $n }}</b><i>{{ $sub }}</i></span>
