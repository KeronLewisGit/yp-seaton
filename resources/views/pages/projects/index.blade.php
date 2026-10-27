<x-layouts.site title="Project portfolio" description="Public contracts awarded to Y.P. Seaton & Associates: shoreline protection, sewage conveyance, housing infrastructure, irrigation and road works, each with its published source.">
    <x-page-header title="Project portfolio" kicker="Projects" sheet="P-00" photo="palisadoes"
        lead="Contracts that ministries, agencies and the press have published under the firm's name. A value or year appears only where the source states it, and each page links to that source." />

    <section class="wrap mt-10">
        <nav aria-label="Filter by sector">
            <ul class="tag-row">
                <li class="flex-none"><a class="tag" href="{{ route('projects.index') }}" @if(! $sector) aria-current="true" style="border-color: var(--ink)" @endif>All <span class="count">{{ $counts->sum() }}</span></a></li>
                @foreach ($sectors as $key => $label)
                    <li class="flex-none"><a class="tag" href="{{ route('projects.index', ['sector' => $key]) }}" @if($sector === $key) aria-current="true" style="border-color: var(--ink)" @endif>{{ $label }} <span class="count">{{ $counts[$key] ?? 0 }}</span></a></li>
                @endforeach
            </ul>
        </nav>
        <h2 class="sr-only">{{ $sector ? $sectors[$sector] : 'All projects' }}</h2>
        <div class="mt-8 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($projects as $project)
                <x-project-card :project="$project" />
            @endforeach
        </div>
        <p class="hint mt-8 max-w-[65ch]">Photos are illustrative and do not show these projects; see <a class="text-link" href="{{ route('credits') }}">photo credits</a>. An award or Cabinet approval is listed as such and is not a claim of completion.</p>
    </section>
</x-layouts.site>
