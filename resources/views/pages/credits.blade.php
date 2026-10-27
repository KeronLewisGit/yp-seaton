<x-layouts.site title="Photo credits" description="Sources and licences for the photographs on this website.">
    <x-page-header photo="palisadoes" title="Photo credits" kicker="Credits" sheet="L-02" lead="One photo is the firm's own. The others come from Wikimedia Commons and show the kind of work, not Y.P. Seaton projects." />
    <section class="wrap mt-12 md:mt-16">
        <ul class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach (config('photo-credits') as $key => $c)
                <li class="sheet flex flex-col">
                    <x-photo :key="$key" alt="" sizes="(min-width: 1024px) 400px, 100vw" class="aspect-[16/10] border-b-[1.5px] border-ink" />
                    <div class="p-5 text-[0.9375rem]">
                        <p class="font-semibold">{{ $c['title'] }}</p>
                        <p class="mt-1 text-ink-2">{{ $c['author'] }} · @if($c['licence_url'])<a class="text-link" href="{{ $c['licence_url'] }}" rel="noopener license" target="_blank">{{ $c['licence'] }}</a>@else{{ $c['licence'] }}@endif</p>
                        <p class="mt-1 text-ink-2"><a class="text-link" href="{{ $c['url'] }}" rel="noopener" target="_blank">{{ $c['source'] }}</a></p>
                        <p class="hint mt-2">{{ $c['changes'] }} Used on: {{ $c['used_for'] }}.</p>
                    </div>
                </li>
            @endforeach
        </ul>
    </section>
</x-layouts.site>
