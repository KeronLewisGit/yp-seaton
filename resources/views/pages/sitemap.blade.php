<x-layouts.site title="Site map" description="Every page on the Y.P. Seaton & Associates website.">
    <x-page-header title="Site map" kicker="Site map" sheet="L-03" lead="Every public page on this website." />
    <section class="wrap mt-12 grid gap-10 md:mt-16 md:grid-cols-3">
        <div><h2 class="font-display text-lg font-bold">The firm</h2><ul class="mt-3 space-y-1">
            @foreach (['home' => 'Home', 'services' => 'Services', 'about' => 'About the firm', 'capability' => 'Capability statement', 'contact' => 'Contact', 'privacy' => 'Privacy notice', 'credits' => 'Photo credits'] as $r => $l)
                <li><a class="inline-flex min-h-11 items-center text-link" href="{{ route($r) }}">{{ $l }}</a></li>
            @endforeach
        </ul></div>
        <div><h2 class="font-display text-lg font-bold">Projects</h2><ul class="mt-3 space-y-1">
            <li><a class="inline-flex min-h-11 items-center text-link" href="{{ route('projects.index') }}">All projects</a></li>
            @foreach ($projects as $p)<li><a class="inline-flex min-h-11 items-center text-link" href="{{ route('projects.show', $p['slug']) }}">{{ $p['title'] }}</a></li>@endforeach
        </ul></div>
        <div><h2 class="font-display text-lg font-bold">Work with us</h2><ul class="mt-3 space-y-1">
            <li><a class="inline-flex min-h-11 items-center text-link" href="{{ route('tenders.create') }}">Invite us to tender</a></li>
            <li><a class="inline-flex min-h-11 items-center text-link" href="{{ route('prequal.create') }}">Prequalification</a></li>
            <li><a class="inline-flex min-h-11 items-center text-link" href="{{ route('careers.index') }}">Careers</a></li>
            <li><a class="inline-flex min-h-11 items-center text-link" href="{{ route('careers.apply') }}">Apply</a></li>
            @foreach ($jobs as $j)<li><a class="inline-flex min-h-11 items-center text-link" href="{{ route('careers.show', $j->slug) }}">{{ $j->title }}</a></li>@endforeach
        </ul></div>
    </section>
</x-layouts.site>
