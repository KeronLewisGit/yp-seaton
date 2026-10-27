@props(['project', 'heading' => 'h3'])
{{-- Portfolio card. The photos are illustrative stock (see /photo-credits) until the firm supplies its own. --}}
<article {{ $attributes->merge(['class' => 'card-link sheet flex flex-col']) }} data-reveal>
    <div class="card-img relative aspect-[16/10] overflow-hidden border-b-[1.5px] border-ink">
        <x-photo :key="$project['photo']" :alt="$project['photo_alt']" sizes="(min-width: 1024px) 400px, (min-width: 640px) 50vw, 100vw" class="h-full w-full" />
        @unless (in_array($project['photo'], (array) yps('own_photos'), true))<span class="photo-note">Illustrative photo</span>@endunless
        <span class="absolute left-3 top-3 bg-sea-900/90 px-2 py-1 text-[0.75rem] font-bold uppercase tracking-[0.12em] text-white">{{ \App\Support\Portfolio::sectorLabel($project['sector']) }}</span>
    </div>
    <div class="flex flex-1 flex-col p-5">
        <{{ $heading }} class="font-display text-[1.25rem] font-bold leading-snug tracking-tight"><a class="stretch" href="{{ route('projects.show', $project['slug']) }}">{{ $project['title'] }}</a></{{ $heading }}>
        <p class="mt-1 text-ink-3">{{ $project['location'] }}@if(! empty($project['parish']) && ! str_contains($project['location'], $project['parish'])), {{ $project['parish'] }}@endif</p>
        <dl class="mt-auto grid grid-cols-2 gap-3 border-t border-line pt-4 text-sm">
            <div><dt class="text-ink-3">Value</dt><dd class="num font-display text-base font-bold">{{ jmd($project['value'] ?? null) ?? 'Not published' }}</dd></div>
            <div><dt class="text-ink-3">Year</dt><dd class="num font-display text-base font-bold">{{ $project['year'] ?? 'Not published' }}</dd></div>
        </dl>
    </div>
</article>
