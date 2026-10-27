@php
    use App\Support\Portfolio;
    $nmia = Portfolio::find('nmia-shoreline-protection');
    $services = (array) yps('services');
@endphp
<x-layouts.site>
    {{-- Hero: the home page's own version of the shared band, with the firm's facts in the title block. --}}
    <section class="contours relative isolate overflow-hidden bg-sea-900 text-white on-dark">
        <div class="hero-photo absolute inset-0 -z-10">
            <x-photo key="revetment" alt="" :eager="true" sizes="100vw" class="h-full w-full" position="center 60%" />
            <div class="hero-scrim absolute inset-0"></div>
        </div>
        <div class="wrap grid gap-10 pb-12 pt-12 md:pb-20 md:pt-24 lg:grid-cols-[minmax(0,1fr)_20rem] lg:items-end">
            <div class="min-w-0">
                <x-dim n="YPS" :left="true">Contractors since {{ yps('founded') }}</x-dim>
                <h1 class="display-1 mt-6 max-w-[15ch]">Shorelines, sewers and housing infrastructure for Jamaica.</h1>
                <p class="lead mt-6 max-w-[56ch] text-white/85">Y.P. Seaton &amp; Associates builds the public works that keep roads open, runways dry and new communities serviced, for government agencies and private developers across the island.</p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('tenders.create') }}" class="btn btn-light">Invite us to tender<x-icon name="arrow-right" class="nudge h-4 w-4" /></a>
                    <a href="{{ route('capability.pdf') }}" class="btn btn-on-dark"><x-icon name="download" class="h-4 w-4" />Capability statement</a>
                </div>
            </div>
            <x-titleblock class="hidden lg:grid" :fields="['Founded' => (string) yps('founded'), 'Office' => 'Kingston 10', '*Contractor' => yps('name'), '*Telephone' => format_phone(yps('phone'))]" />
        </div>
        <div class="armour tall on-sea" aria-hidden="true"></div>
    </section>

    {{-- Sourced figures only --}}
    <section class="wrap mt-14 md:mt-20" aria-labelledby="record-title">
        <h2 id="record-title" class="sr-only">On the public record</h2>
        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
            <div class="figure-stamp"><b>{{ yps('founded') }}</b><span class="mt-2 block text-ink-2">Founded as electrical and mechanical engineering contractors</span></div>
            <div class="figure-stamp"><b>{{ jmd($nmia['value'] ?? null) }}</b><span class="mt-2 block text-ink-2">Shoreline protection at Norman Manley airport, approved by Cabinet in 2021</span></div>
            <div class="figure-stamp"><b>7.4 km</b><span class="mt-2 block text-ink-2">Sewage force main for the UDC at Caymanas Estate, 2015</span></div>
            <div class="figure-stamp"><b>800</b><span class="mt-2 block text-ink-2">Housing solutions served by the Whitehall Phase 2 infrastructure contract</span></div>
        </div>
        <p class="hint mt-6">Figures as published by the Jamaica Observer, the UDC and JIS. <a class="text-link" href="{{ route('projects.index') }}">See the sources on each project.</a></p>
    </section>

    {{-- Services --}}
    <section class="wrap mt-20 md:mt-28" aria-labelledby="services-title">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <x-dim n="01" :left="true">What we build</x-dim>
                <h2 id="services-title" class="display-2 mt-4 max-w-[20ch]">Six lines of work, one contractor.</h2>
            </div>
            <a href="{{ route('services') }}" class="btn btn-outline">All services<x-icon name="arrow-right" class="nudge h-4 w-4" /></a>
        </div>
        <div class="mt-10 grid border-l-[1.5px] border-t-[1.5px] border-ink sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($services as $key => $s)
                <a href="{{ route('services') }}#{{ $key }}" class="group flex flex-col gap-3 border-b-[1.5px] border-r-[1.5px] border-ink bg-surface p-6 hover:bg-surface-2" data-reveal>
                    <span class="flex items-center justify-between"><x-icon :name="$s['icon']" class="h-7 w-7 text-primary" /><x-callout :n="$loop->iteration" class="text-ink-3" /></span>
                    <span class="font-display text-[1.25rem] font-bold leading-snug tracking-tight">{{ $s['title'] }}</span>
                    <span class="text-ink-2">{{ $s['summary'] }}</span>
                </a>
            @endforeach
        </div>
    </section>

    {{-- Projects --}}
    <section class="drawing-grid mt-20 border-y-[1.5px] border-ink py-16 md:mt-28 md:py-24" aria-labelledby="projects-title">
        <div class="wrap">
            <div class="flex flex-wrap items-end justify-between gap-4">
                <div>
                    <x-dim n="02" :left="true">Project portfolio</x-dim>
                    <h2 id="projects-title" class="display-2 mt-4 max-w-[22ch]">Public contracts, with the sources to prove them.</h2>
                </div>
                <a href="{{ route('projects.index') }}" class="btn btn-outline">All {{ $projectCount }} projects<x-icon name="arrow-right" class="nudge h-4 w-4" /></a>
            </div>
            <div class="mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($featured as $project)
                    <x-project-card :project="$project" />
                @endforeach
            </div>
        </div>
    </section>

    {{-- For procurement --}}
    <section class="wrap mt-20 md:mt-28" aria-labelledby="proc-title">
        <x-dim n="03" :left="true">For procuring entities</x-dim>
        <h2 id="proc-title" class="display-2 mt-4 max-w-[22ch]">Everything a tender panel asks for, in one place.</h2>
        <ol class="mt-10 grid gap-6 lg:grid-cols-3">
            <li class="sheet p-6">
                <x-callout n="1" class="text-primary" />
                <h3 class="mt-4 font-display text-xl font-bold">Read the capability statement</h3>
                <p class="mt-2 text-ink-2">Services, contracts, values and sources on one printable page.</p>
                <a href="{{ route('capability') }}" class="btn btn-outline btn-sm mt-5">Open it</a>
            </li>
            <li class="sheet p-6">
                <x-callout n="2" class="text-primary" />
                <h3 class="mt-4 font-display text-xl font-bold">Send the invitation</h3>
                <p class="mt-2 text-ink-2">Upload the bidding documents or link to GOJEP. You get a reference number straight away.</p>
                <a href="{{ route('tenders.create') }}" class="btn btn-primary btn-sm mt-5">Invite us to tender</a>
            </li>
            <li class="sheet p-6">
                <x-callout n="3" class="text-primary" />
                <h3 class="mt-4 font-display text-xl font-bold">Share project documents</h3>
                <p class="mt-2 text-ink-2">On contract, we give your project team a private link to drawings, reports and certificates.</p>
                <a href="{{ route('contact') }}" class="btn btn-outline btn-sm mt-5">Ask about it</a>
            </li>
        </ol>
    </section>

    {{-- Suppliers and careers --}}
    <section class="wrap mt-20 grid gap-6 md:mt-28 lg:grid-cols-2">
        <div class="contours relative isolate overflow-hidden bg-sea-900 p-8 text-white on-dark md:p-10">
            <x-dim :left="true">Subcontractors and suppliers</x-dim>
            <h2 class="display-3 mt-4">Prequalify once. We remind you before your certificates expire.</h2>
            <p class="mt-3 text-white/80">Upload your TCC, NCC/PPC registration and insurance with their expiry dates.</p>
            <a href="{{ route('prequal.create') }}" class="btn btn-light mt-6">Start prequalification<x-icon name="arrow-right" class="nudge h-4 w-4" /></a>
        </div>
        <div class="sheet p-8 md:p-10">
            <x-dim :left="true">Careers</x-dim>
            <h2 class="display-3 mt-4">Tradesmen, operators, foremen, engineers.</h2>
            <p class="mt-3 text-ink-2">{{ $openJobs ? $openJobs.' '.\Illuminate\Support\Str::plural('opening', $openJobs).' posted now. ' : '' }}Site roles can apply with a phone number; no CV needed.</p>
            <a href="{{ route('careers.index') }}" class="btn btn-primary mt-6">See openings<x-icon name="arrow-right" class="nudge h-4 w-4" /></a>
        </div>
    </section>

    {{-- Contact strip --}}
    <section class="wrap mt-20 md:mt-28" aria-labelledby="visit-title">
        <div class="grid gap-8 border-t-[1.5px] border-ink pt-10 md:grid-cols-3">
            <div><h2 id="visit-title" class="display-3">Talk to the office</h2><p class="mt-2 text-ink-2">{{ yps('hours.0.0') }}, {{ yps('hours.0.1') }}. {{ yps('hours.1.0') }}, {{ yps('hours.1.1') }}.</p></div>
            <div>
                <p class="kicker text-ink-3">Telephone</p>
                <a href="{{ tel_href(yps('phone')) }}" class="mt-1 inline-flex min-h-11 items-center font-display text-2xl font-bold text-link">{{ format_phone(yps('phone')) }}</a>
                <p class="kicker mt-3 text-ink-3">Email</p>
                <a href="mailto:{{ yps('email') }}" class="mt-1 inline-flex min-h-11 items-center text-lg font-semibold text-link">{{ yps('email') }}</a>
            </div>
            <div>
                <p class="kicker text-ink-3">Office</p>
                <p class="mt-1 text-lg">{{ yps('address.street') }}<br>{{ yps('address.city') }}, {{ yps('address.country') }}</p>
                <a href="{{ yps('map_url') }}" target="_blank" rel="noopener" class="mt-1 inline-flex min-h-11 items-center gap-1.5 font-semibold text-link">Get directions<x-icon name="external" class="h-4 w-4" /><span class="sr-only">(opens Google Maps)</span></a>
            </div>
        </div>
    </section>
</x-layouts.site>
