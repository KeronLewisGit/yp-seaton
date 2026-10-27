@props(['n' => null, 'left' => false])
{{-- Section label drawn as a dimension line: |—— 02 · Label ——| --}}
<p {{ $attributes->class(['dim', 'left' => $left]) }}>@if($n !== null)<span class="n">{{ $n }}</span>@endif<span>{{ $slot }}</span></p>
