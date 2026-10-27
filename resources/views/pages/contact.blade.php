<x-layouts.site title="Contact" description="Contact Y.P. Seaton & Associates at 52c Molynes Road, Kingston 10: telephone, email, office hours and an enquiry form.">
    <x-page-header title="Contact the office" kicker="Contact" sheet="K-01" photo="kingston-aerial"
        lead="For tenders, use the tender form so the documents reach our estimating team. For anything else, call, email or send a message below." />

    <section class="wrap mt-12 grid gap-12 md:mt-16 lg:grid-cols-[20rem_minmax(0,1fr)]">
        <aside class="space-y-8">
            <div>
                <p class="kicker text-ink-3">Telephone</p>
                <a href="{{ tel_href(yps('phone')) }}" class="mt-1 inline-flex min-h-11 items-center font-display text-2xl font-bold text-link">{{ format_phone(yps('phone')) }}</a>
                <p class="hint">{{ yps('phone_note') }}. Fax {{ format_phone(yps('fax')) }}.</p>
            </div>
            <div>
                <p class="kicker text-ink-3">Email</p>
                <a href="mailto:{{ yps('email') }}" class="mt-1 inline-flex min-h-11 items-center text-lg font-semibold text-link">{{ yps('email') }}</a>
            </div>
            <div>
                <p class="kicker text-ink-3">Office</p>
                <p class="mt-1 text-lg">{{ yps('name') }}<br>{{ yps('address.street') }}<br>{{ yps('address.city') }}, {{ yps('address.country') }}</p>
                <a href="{{ yps('map_url') }}" target="_blank" rel="noopener" class="mt-1 inline-flex min-h-11 items-center gap-1.5 font-semibold text-link">Get directions<x-icon name="external" class="h-4 w-4" /><span class="sr-only">(opens Google Maps)</span></a>
            </div>
            <div>
                <p class="kicker text-ink-3">Office hours</p>
                <dl class="mt-2 space-y-1.5">@foreach (yps('hours') as [$d, $h])<div class="flex justify-between gap-4 border-b border-line pb-1.5"><dt>{{ $d }}</dt><dd class="num text-right font-semibold">{{ $h }}</dd></div>@endforeach</dl>
            </div>
            <div class="panel p-5">
                <p class="font-semibold">Sending a tender or RFQ?</p>
                <a href="{{ route('tenders.create') }}" class="btn btn-primary mt-3 w-full">Invite us to tender</a>
            </div>
        </aside>

        <form method="POST" action="{{ route('contact.store') }}" class="min-w-0 space-y-8" x-data="sendForm" @submit="submit">
            @csrf
            <x-form-errors />
            <x-honeypot />
            <x-fieldset n="1" title="Send a message">
                <x-radios name="topic" label="What is it about?" :options="collect(\App\Enums\EnquiryTopic::cases())->mapWithKeys(fn ($t) => [$t->value => $t->label()])->all()" :required="true" cols="sm:grid-cols-2" />
                <div class="grid gap-5 sm:grid-cols-2">
                    <x-field name="name" label="Your name" :required="true" maxlength="120" autocomplete="name" />
                    <x-field name="organisation" label="Organisation" :optional="true" maxlength="160" autocomplete="organization" />
                    <x-field name="email" label="Email" type="email" :required="true" maxlength="255" autocomplete="email" />
                    <x-field name="phone" label="Phone" type="tel" :optional="true" maxlength="30" autocomplete="tel" inputmode="tel" />
                </div>
                <x-field name="message" label="Message" type="textarea" :required="true" maxlength="3000" rows="6" />
            </x-fieldset>
            <div class="border-t-[1.5px] border-ink pt-6">
                <x-submit label="Send message" />
                <p class="hint mt-3">We keep these details only to reply. <a class="text-link" href="{{ route('privacy') }}">Privacy notice</a>.</p>
            </div>
        </form>
    </section>
</x-layouts.site>
