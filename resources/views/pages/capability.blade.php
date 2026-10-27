@php
    $services = (array) yps('services');
    $principal = (array) yps('principal');
    $total = $projects->sum(fn ($p) => (float) ($p['value'] ?? 0));
@endphp
<!DOCTYPE html>
<html lang="en-JM" data-theme="light">
<head>
    @include('partials.head')
    <title>Capability statement · {{ yps('short_name') }}</title>
    <meta name="description" content="One-page capability statement for {{ yps('name') }}: services, public contracts, values and sources.">
    @if (yps('preview'))<meta name="robots" content="noindex">@endif
</head>
<body class="bg-surface-2 text-ink">
    <div class="no-print border-b border-line bg-surface">
        <div class="wrap flex min-h-16 flex-wrap items-center gap-3 py-2">
            <a href="{{ route('home') }}" class="mr-auto inline-flex min-h-11 items-center gap-2 font-semibold text-link"><x-icon name="arrow-left" class="h-4 w-4" />Back to the website</a>
            <button type="button" onclick="window.print()" class="btn btn-outline btn-sm"><x-icon name="print" class="h-4 w-4" />Print</button>
            <a href="{{ route('capability.pdf') }}" class="btn btn-primary btn-sm"><x-icon name="download" class="h-4 w-4" />Download PDF</a>
        </div>
    </div>

    <main class="cs-page my-6 border border-line p-6 shadow-sm sm:p-10 print:my-0 print:p-0">
        <header class="flex flex-wrap items-start justify-between gap-6 border-b-[3px] border-[#10232a] pb-5">
            <div>
                <x-logo />
                <p class="mt-3 text-sm font-semibold uppercase tracking-[0.14em] text-[#3b5158]">Capability statement · {{ now()->format('F Y') }}</p>
            </div>
            <dl class="text-sm leading-relaxed sm:text-right">
                <div>{{ yps('address.street') }}, {{ yps('address.city') }}, {{ yps('address.country') }}</div>
                <div>Tel. {{ format_phone(yps('phone')) }} · {{ yps('email') }}</div>
                <div>{{ parse_url(route('home'), PHP_URL_HOST) }}</div>
            </dl>
        </header>

        <section class="mt-6 grid gap-6 sm:grid-cols-[minmax(0,1.3fr)_minmax(0,1fr)]">
            <div>
                <h1 class="font-display text-[1.75rem] font-extrabold leading-tight tracking-tight">{{ yps('name') }}</h1>
                <p class="mt-2 text-[0.9375rem] leading-relaxed">{{ yps('about.intro') }}</p>
            </div>
            <dl class="titleblock light self-start text-sm" style="--cols: 2">
                <div><dt>Founded</dt><dd>{{ yps('founded') }}</dd></div>
                <div><dt>Office</dt><dd>Kingston 10</dd></div>
                <div class="wide"><dt>{{ $principal['title'] }}</dt><dd>{{ $principal['name'] }}</dd></div>
                <div class="wide"><dt>Contracts listed below</dt><dd class="num">{{ $projects->count() }} · {{ jmd($total) }} combined published value</dd></div>
            </dl>
        </section>

        <section class="mt-7">
            <h2 class="border-b border-[#10232a] pb-1 text-xs font-bold uppercase tracking-[0.16em]">Core services</h2>
            <ul class="mt-3 grid gap-x-6 gap-y-2.5 text-[0.875rem] sm:grid-cols-2">
                @foreach ($services as $s)
                    <li><strong class="font-display">{{ $s['title'] }}.</strong> {{ $s['summary'] }}</li>
                @endforeach
            </ul>
        </section>

        <section class="mt-7">
            <h2 class="border-b border-[#10232a] pb-1 text-xs font-bold uppercase tracking-[0.16em]">Public contracts on record</h2>
            <div class="overflow-x-auto">
                <table class="mt-2 w-full min-w-[36rem] border-collapse text-left text-[0.8125rem]">
                    <thead><tr class="border-b border-[#9fb0b5] text-[0.6875rem] uppercase tracking-wider text-[#3b5158]"><th class="py-1.5 pr-3 font-bold">Project</th><th class="py-1.5 pr-3 font-bold">Client</th><th class="py-1.5 pr-3 font-bold">Year</th><th class="py-1.5 pr-3 text-right font-bold">Value</th><th class="py-1.5 font-bold">Source</th></tr></thead>
                    <tbody>
                        @foreach ($projects->sortByDesc(fn ($p) => $p['year'] ?? 0) as $p)
                            <tr class="border-b border-[#d8dedf] align-top">
                                <td class="py-1.5 pr-3"><span class="font-semibold">{{ $p['title'] }}</span><br><span class="text-[#3b5158]">{{ $p['parish'] }} · {{ $p['status'] }}</span></td>
                                <td class="py-1.5 pr-3">{{ $p['client'] ?? '–' }}</td>
                                <td class="num py-1.5 pr-3">{{ $p['year'] ?? '–' }}</td>
                                <td class="num whitespace-nowrap py-1.5 pr-3 text-right font-semibold">{{ jmd($p['value'] ?? null) ?? '–' }}</td>
                                <td class="py-1.5 text-[#3b5158]">{{ $p['sources'][0]['label'] ?? '' }}@if(! empty($p['sources'][0]['date'])), {{ $p['sources'][0]['date'] }}@endif</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <p class="mt-2 text-[0.75rem] text-[#3b5158]">Values are contract sums as published (Aston Ridge: final cost). Awards and Cabinet approvals are listed as such. Full sources: {{ route('projects.index') }}</p>
        </section>

        <section class="mt-7 grid gap-6 text-[0.875rem] sm:grid-cols-2">
            <div>
                <h2 class="border-b border-[#10232a] pb-1 text-xs font-bold uppercase tracking-[0.16em]">Working with us</h2>
                <ul class="mt-3 space-y-1.5">
                    <li>Tender invitations and RFQs: {{ route('tenders.create') }}</li>
                    <li>Subcontractor and supplier prequalification: {{ route('prequal.create') }}</li>
                    <li>Private document links for client project teams</li>
                </ul>
            </div>
            <div>
                <h2 class="border-b border-[#10232a] pb-1 text-xs font-bold uppercase tracking-[0.16em]">Contact</h2>
                <p class="mt-3">{{ yps('address.street') }}, {{ yps('address.city') }}, {{ yps('address.country') }}<br>Tel. {{ format_phone(yps('phone')) }} · Fax {{ format_phone(yps('fax')) }}<br>{{ yps('email') }}</p>
            </div>
        </section>
        <footer class="mt-8 flex items-center justify-between border-t-[3px] border-[#10232a] pt-2 text-[0.6875rem] uppercase tracking-[0.14em] text-[#3b5158]"><span>{{ yps('tagline') }}</span><span>{{ yps('short_name') }}</span></footer>
    </main>
</body>
</html>
