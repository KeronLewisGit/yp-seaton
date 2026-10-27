@php($about = (array) yps('about'))
@php($principal = (array) yps('principal'))
<x-layouts.site title="About the firm" description="Y.P. Seaton & Associates: founded in 1969 as electrical and mechanical engineering contractors, now a Kingston civil engineering and building contractor.">
    <x-page-header title="Building Jamaica since 1969" kicker="About the firm" sheet="A-01" photo="boj" position="center 30%"
        :lead="$about['intro']" />

    <section class="wrap mt-12 grid gap-12 md:mt-16 lg:grid-cols-[minmax(0,1fr)_20rem]">
        <div class="prose-copy measure min-w-0 text-[1.0625rem]">
            @foreach ($about['paragraphs'] as $p)<p>{{ $p }}</p>@endforeach
            <h2>Our mission</h2>
            <p>{{ $about['mission'] }}</p>
            <p class="hint">Text from the firm's own website, {{ $about['source'] }}.</p>
        </div>
        <aside class="space-y-6">
            <x-titleblock :light="true" :cols="1" :fields="['Company' => yps('name'), 'Founded' => (string) yps('founded'), 'Office' => yps('address.street').', '.yps('address.city'), $principal['title'] => $principal['name']]" />
            <p class="hint">{{ $principal['name'] }} is named as {{ $principal['title'] }} by the {{ $principal['source']['label'] }}, {{ $principal['source']['date'] }}.</p>
        </aside>
    </section>

    <section class="wrap mt-20">
        <x-dim n="01" :left="true">Timeline from the public record</x-dim>
        <ol class="mt-8 border-l-[1.5px] border-ink">
            <li class="relative pb-8 pl-8"><span class="absolute -left-[7px] top-1.5 h-3 w-3 bg-primary"></span><p class="num font-display text-xl font-bold">1969</p><p class="mt-1 text-ink-2">Founded as electrical and mechanical engineering contractors.</p></li>
            @foreach (\App\Support\Portfolio::all()->filter(fn ($p) => ! empty($p['year']))->sortBy('year') as $p)
                <li class="relative pb-8 pl-8 last:pb-0"><span class="absolute -left-[7px] top-1.5 h-3 w-3 bg-primary"></span><p class="num font-display text-xl font-bold">{{ $p['year'] }}</p><p class="mt-1 text-ink-2"><a class="text-link" href="{{ route('projects.show', $p['slug']) }}">{{ $p['title'] }}</a>, {{ $p['parish'] }}. {{ $p['status'] }}.</p></li>
            @endforeach
        </ol>
    </section>

    <section class="wrap mt-16 flex flex-wrap gap-3">
        <a href="{{ route('capability') }}" class="btn btn-primary"><x-icon name="file" class="h-4 w-4" />Capability statement</a>
        <a href="{{ route('contact') }}" class="btn btn-outline">Contact the office</a>
    </section>
    <p class="wrap photo-caption mt-8">Header photo: the Bank of Jamaica tower, Kingston, from the firm's 2022 website.</p>
</x-layouts.site>
