@props(['title', 'lead' => null, 'kicker' => null, 'sheet' => null, 'photo' => null, 'position' => 'center', 'block' => null])
{{--
    The one hero band every inner page uses, so titles start at the same height and left edge
    site-wide. Harbour-blue band with bathymetric contours (or a photo behind a scrim), a
    dimension-line kicker, and a drawing title block on the right. An armour-stone revetment
    band closes it. Breadcrumbs, actions and chips go in the slot.
--}}
@php
    $fields = $block ?? [
        'Sheet' => $sheet ?? 'YPS',
        'Rev.' => 'A · '.now()->format('M Y'),
        '*Drawing' => $kicker ?? $title,
        '*Contractor' => 'Y.P. Seaton & Associates · Kingston 10',
    ];
@endphp
<section {{ $attributes->merge(['class' => 'contours relative isolate overflow-hidden bg-sea-900 text-white on-dark']) }}>
    @if ($photo)
        <div class="hero-photo absolute inset-0 -z-10">
            <x-photo :key="$photo" alt="" :eager="true" sizes="100vw" class="h-full w-full" :position="$position" />
            <div class="hero-scrim absolute inset-0"></div>
        </div>
    @endif
    <div class="wrap grid gap-8 pb-10 pt-10 md:pb-14 md:pt-16 lg:grid-cols-[minmax(0,1fr)_19rem] lg:items-end lg:gap-12">
        <div class="min-w-0">
            @if ($kicker)<x-dim :n="$sheet" :left="true">{{ $kicker }}</x-dim>@endif
            <h1 class="display-2 mt-5 max-w-4xl">{{ $title }}</h1>
            @if ($lead)<p class="lead mt-4 text-white/85 md:mt-5">{{ $lead }}</p>@endif
            {{ $slot }}
        </div>
        <x-titleblock :fields="$fields" class="hidden lg:grid" />
    </div>
    <div class="armour on-sea" aria-hidden="true"></div>
</section>
