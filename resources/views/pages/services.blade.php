@php($services = (array) yps('services'))
<x-layouts.site title="Services" description="Shoreline protection, sewerage and water works, housing infrastructure, roads and drainage, building, and electrical and mechanical engineering by Y.P. Seaton & Associates, Kingston.">
    <x-page-header title="Services" kicker="What we build" sheet="S-01" photo="excavator"
        lead="Civil engineering and building works for ministries, agencies, parish municipal corporations and private developers. Each service links to the public contracts that show it." />

    <nav class="wrap mt-10" aria-label="Services on this page">
        <ul class="tag-row">
            @foreach ($services as $key => $s)
                <li class="flex-none"><a class="tag" href="#{{ $key }}"><x-icon :name="$s['icon']" class="h-4 w-4" />{{ $s['title'] }}</a></li>
            @endforeach
        </ul>
    </nav>

    <div class="wrap mt-8 space-y-6">
        @foreach ($services as $key => $s)
            @php($projects = $s['sector'] ? \App\Support\Portfolio::inSector($s['sector']) : collect())
            <section id="{{ $key }}" class="sheet scroll-mt-28 grid gap-8 p-6 md:p-8 lg:grid-cols-[minmax(0,1fr)_22rem]" aria-labelledby="{{ $key }}-title">
                <div class="min-w-0">
                    <div class="flex items-center gap-4"><x-callout :n="$loop->iteration" class="text-primary" /><x-icon :name="$s['icon']" class="h-7 w-7 text-primary" /></div>
                    <h2 id="{{ $key }}-title" class="display-3 mt-4">{{ $s['title'] }}</h2>
                    <p class="measure mt-3 text-ink-2">{{ $s['summary'] }}</p>
                    <ul class="ticked mt-5 grid gap-2.5 sm:grid-cols-2">
                        @foreach ($s['items'] as $item)<li>{{ $item }}</li>@endforeach
                    </ul>
                </div>
                <div class="border-t border-line pt-6 lg:border-l lg:border-t-0 lg:pl-8 lg:pt-0">
                    <p class="kicker text-ink-3">{{ $projects->isNotEmpty() ? 'On the public record' : 'Projects' }}</p>
                    @forelse ($projects as $p)
                        <a href="{{ route('projects.show', $p['slug']) }}" class="mt-3 block min-h-11 border-b border-line pb-3 last:border-0 hover:text-link">
                            <span class="block font-semibold leading-snug">{{ $p['title'] }}</span>
                            <span class="num block text-sm text-ink-3">{{ collect([$p['parish'] ?? null, $p['year'] ?? null, jmd($p['value'] ?? null)])->filter()->implode(' · ') }}</span>
                        </a>
                    @empty
                        <p class="mt-3 text-ink-2">Project references available on request.</p>
                    @endforelse
                </div>
            </section>
        @endforeach
    </div>

    <section class="wrap mt-16">
        <div class="contours relative isolate overflow-hidden bg-sea-900 p-8 text-white on-dark md:flex md:items-center md:justify-between md:gap-8 md:p-10">
            <div><h2 class="display-3">Have works out to tender?</h2><p class="mt-2 text-white/80">Send the invitation and we reply with a bid decision well before your deadline.</p></div>
            <a href="{{ route('tenders.create') }}" class="btn btn-light mt-6 flex-none md:mt-0">Invite us to tender<x-icon name="arrow-right" class="nudge h-4 w-4" /></a>
        </div>
    </section>
</x-layouts.site>
