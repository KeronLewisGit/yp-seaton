<x-layouts.site title="Apply" description="Apply to work with Y.P. Seaton & Associates.">
    <x-page-header :title="$selected ? 'Apply: '.$selected->title : 'Apply to work with us'" kicker="Careers" sheet="C-03" photo="concrete-pour"
        lead="It takes about three minutes. Site roles can apply without a CV; engineering, quantity surveying and office roles need one." />
    <section class="wrap mt-12 max-w-3xl md:mt-16">
        <form method="POST" action="{{ route('careers.store') }}" enctype="multipart/form-data" class="space-y-10" x-data="sendForm" @submit="submit">
            @csrf
            <x-form-errors />
            <x-honeypot />
            <x-fieldset n="1" title="The work">
                @if ($jobs->isNotEmpty())
                    <x-select name="job_posting_id" label="Opening" :options="$jobs->pluck('title', 'id')->all()" :value="$selected?->id" placeholder="General application (no specific opening)" />
                @endif
                <x-select name="category" label="Type of work" :required="true" :value="$selected?->category->value" :options="collect(\App\Enums\JobCategory::cases())->mapWithKeys(fn ($c) => [$c->value => $c->label()])->all()" hint="If you chose an opening, its type of work is used." />
                <x-select name="experience" label="Construction experience" :required="true" :options="collect(\App\Enums\Experience::cases())->mapWithKeys(fn ($c) => [$c->value => $c->label()])->all()" />
                <x-field name="qualifications" label="Trades, tickets and qualifications" type="textarea" :optional="true" maxlength="2000" hint="e.g. mason, steel fixer, HEART/NSTA Trust certificate, BSc Civil Engineering, plant you can operate." />
                <x-field name="available_from" label="Earliest start date" type="date" :optional="true" :min="today()->format('Y-m-d')" />
            </x-fieldset>
            <x-fieldset n="2" title="About you">
                <div class="grid gap-5 sm:grid-cols-2">
                    <x-field name="first_name" label="First name" :required="true" maxlength="80" autocomplete="given-name" />
                    <x-field name="last_name" label="Last name" :required="true" maxlength="80" autocomplete="family-name" />
                    <x-field name="phone" label="Phone" type="tel" :required="true" maxlength="30" autocomplete="tel" inputmode="tel" hint="We call or text this number." />
                    <x-field name="email" label="Email" type="email" maxlength="255" autocomplete="email" hint="Needed for professional and office roles." />
                </div>
                <x-select name="parish" label="Parish you live in" :optional="true" :options="array_combine(yps('parishes'), yps('parishes'))" />
            </x-fieldset>
            <x-fieldset n="3" title="CV and message">
                <div>
                    <label for="f-cv" class="label">CV</label>
                    <input id="f-cv" type="file" name="cv" class="input" accept=".pdf,.doc,.docx" aria-describedby="f-cv-hint" @error('cv') aria-invalid="true" @enderror>
                    <span id="f-cv-hint" class="hint">PDF or Word, up to 5 MB. Optional for site roles.</span>
                    <x-held-upload form="application" field="cv" />
                    <x-error for="cv" />
                </div>
                <x-field name="message" label="Anything else" type="textarea" :optional="true" maxlength="2000" />
                <label class="choice items-start"><input type="checkbox" name="consent" value="1" class="mt-0.5" @checked(old('consent')) required><span>I agree to Y.P. Seaton &amp; Associates keeping my application for up to 12 months to consider me for work (<a class="text-link" href="{{ route('privacy') }}">privacy notice</a>).</span></label>
                <x-error for="consent" />
            </x-fieldset>
            <div class="border-t-[1.5px] border-ink pt-6"><x-submit label="Send my application" /></div>
        </form>
    </section>
</x-layouts.site>
