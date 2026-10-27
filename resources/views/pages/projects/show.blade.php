@php
    $sources = $project['sources'] ?? [];
    $block = ['Client' => $project['client'] ?? 'Not published', 'Parish' => $project['parish'] ?? null, '*Value' => jmd($project['value'] ?? null) ?? 'Not published', '*Year' => $project['year_label'] ?? 'Not published'];
@endphp
<x-layouts.site :title="$project['title']" :description="$project['summary']">
    <x-page-header :title="$project['title']" :kicker="\App\Support\Portfolio::sectorLabel($project['sector'])" sheet="P-{{ str_pad((string) (\App\Support\Portfolio::all()->keys()->search($project['slug']) + 1), 2, '0', STR_PAD_LEFT) }}" :lead="$project['summary']" :block="$block">
        <p class="mt-6"><a href="{{ route('projects.index') }}" class="inline-flex min-h-11 items-center gap-2 font-semibold text-white/85 hover:text-white"><x-icon name="arrow-left" class="h-4 w-4" />All projects</a></p>
    </x-page-header>

    <section class="wrap mt-12 grid gap-12 md:mt-16 lg:grid-cols-[minmax(0,1fr)_22rem]">
        <div class="min-w-0">
            <figure>
                <x-photo :key="$project['photo']" :alt="$project['photo_alt']" sizes="(min-width: 1024px) 760px, 100vw" class="aspect-[16/9] border-[1.5px] border-ink" />
                <figcaption class="photo-caption">Illustrative photo: {{ lcfirst($project['photo_alt']) }}. It does not show this project. <a class="text-link" href="{{ route('credits') }}">Credit</a></figcaption>
            </figure>

            @if (! empty($project['scope']))
                <x-dim n="01" :left="true" class="mt-12">Scope of works</x-dim>
                <ul class="ticked mt-5 space-y-2.5">@foreach ($project['scope'] as $line)<li>{{ $line }}</li>@endforeach</ul>
            @endif

            <x-dim n="02" :left="true" class="mt-12">Sources</x-dim>
            <ul class="mt-5 divide-y divide-line border-y border-line">
                @foreach ($sources as $s)
                    <li><a href="{{ $s['url'] }}" target="_blank" rel="noopener" class="flex min-h-14 items-center gap-4 py-3 hover:text-link"><x-icon name="file" class="h-5 w-5 flex-none text-ink-3" /><span class="flex-1"><span class="block font-semibold">{{ $s['label'] }}</span>@if(! empty($s['date']))<span class="block text-sm text-ink-3">{{ $s['date'] }}</span>@endif</span><x-icon name="external" class="h-4 w-4 flex-none" /><span class="sr-only">(opens in a new tab)</span></a></li>
                @endforeach
            </ul>
        </div>

        <aside class="space-y-6">
            <x-titleblock :light="true" :cols="1" :fields="['Client' => $project['client'] ?? 'Not published', 'Location' => $project['location'].(! empty($project['parish']) && ! str_contains($project['location'], $project['parish']) ? ', '.$project['parish'] : ''), 'Value' => jmd($project['value'] ?? null) ? jmd($project['value']).(! empty($project['value_label']) ? ' · '.$project['value_label'] : '') : 'Not published', 'Year' => $project['year_label'] ?? 'Not published', 'Status' => $project['status'] ?? null]" />
            <div class="panel p-5">
                <h2 class="font-display text-lg font-bold">Similar works out to tender?</h2>
                <p class="mt-2 text-ink-2">Send us the invitation and documents.</p>
                <a href="{{ route('tenders.create') }}" class="btn btn-primary mt-4 w-full">Invite us to tender</a>
            </div>
        </aside>
    </section>

    @if ($related->isNotEmpty())
        <section class="wrap mt-20">
            <x-dim n="03" :left="true">More projects</x-dim>
            <div class="mt-6 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($related as $p)<x-project-card :project="$p" />@endforeach
            </div>
        </section>
    @endif
</x-layouts.site>
