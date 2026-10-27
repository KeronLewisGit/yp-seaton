<x-layouts.site title="Careers" description="Site labour, plant operators, foremen, engineers and quantity surveyors: work with Y.P. Seaton & Associates on civil engineering projects across Jamaica.">
    <x-page-header title="Build with us" kicker="Careers" sheet="C-01" photo="concrete-pour"
        lead="We hire site labour, tradesmen, plant operators, drivers, foremen, engineers and quantity surveyors as projects start. Apply for an opening below, or send a general application and we will call when a project needs your skills." />

    <section class="wrap mt-12 md:mt-16">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div><x-dim n="01" :left="true">Openings</x-dim><h2 class="display-3 mt-3">{{ $jobs->isEmpty() ? 'No openings posted right now' : $jobs->count().' '.\Illuminate\Support\Str::plural('opening', $jobs->count()).' posted' }}</h2></div>
            <a href="{{ route('careers.apply') }}" class="btn btn-outline">General application<x-icon name="arrow-right" class="nudge h-4 w-4" /></a>
        </div>
        <div class="mt-8 grid gap-5 md:grid-cols-2">
            @forelse ($jobs as $job)
                <article class="card-link sheet p-6" data-reveal>
                    <p class="kicker text-ink-3">{{ $job->category->label() }}</p>
                    <h3 class="display-3 mt-2 text-[1.375rem]"><a class="stretch" href="{{ route('careers.show', $job) }}">{{ $job->title }}</a></h3>
                    <p class="mt-2 text-ink-2">{{ $job->summary }}</p>
                    <p class="mt-4 flex flex-wrap gap-x-5 gap-y-1 text-sm text-ink-3">
                        <span class="inline-flex items-center gap-1.5"><x-icon name="map-pin" class="h-4 w-4" />{{ $job->location }}</span>
                        <span class="inline-flex items-center gap-1.5"><x-icon name="briefcase" class="h-4 w-4" />{{ $job->employment_type->label() }}</span>
                        @if ($job->closes_on)<span class="inline-flex items-center gap-1.5"><x-icon name="calendar" class="h-4 w-4" />Closes {{ $job->closes_on->format('j M') }}</span>@endif
                    </p>
                    @if ($job->is_demo)<p class="mt-4"><span class="demo-badge">Sample posting</span></p>@endif
                </article>
            @empty
                <p class="panel p-6 text-ink-2 md:col-span-2">Send a general application and we will keep it on file for upcoming projects.</p>
            @endforelse
        </div>
    </section>

    <section class="wrap mt-20">
        <div class="grid gap-8 lg:grid-cols-3">
            @foreach (yps('careers.points') as $i => $p)
                <div class="flex gap-4"><x-callout :n="$i + 1" class="text-primary" /><div><h3 class="font-display text-lg font-bold">{{ $p['title'] }}</h3><p class="mt-1 text-ink-2">{{ $p['text'] }}</p></div></div>
            @endforeach
        </div>
    </section>
</x-layouts.site>
