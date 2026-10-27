<x-layouts.site title="Invite us to tender" description="Procuring entities and private clients: send Y.P. Seaton & Associates an invitation to tender or a request for quotation. You get a reference number by email.">
    <x-page-header title="Invite us to tender" kicker="Tenders & RFQs" sheet="T-01" photo="clarifiers"
        lead="Ministries, agencies, parish councils and private developers: send your invitation to tender or request for quotation straight to our estimating team. You get a reference number on screen and by email." />

    <section class="wrap mt-12 grid gap-12 md:mt-16 lg:grid-cols-[minmax(0,1fr)_20rem]">
        <form method="POST" action="{{ route('tenders.store') }}" enctype="multipart/form-data" class="min-w-0 space-y-10" x-data="sendForm" @submit="submit">
            @csrf
            <x-form-errors />
            <x-honeypot />

            <x-fieldset n="1" title="Procuring entity">
                <x-radios name="sector" label="Who is inviting the tender?" :options="\App\Models\Tender::SECTORS" :required="true" cols="sm:grid-cols-2" />
                <x-field name="entity_name" label="Ministry, agency or company" :required="true" maxlength="160" autocomplete="organization" hint="For example a ministry, the NWA, the UDC, a parish municipal corporation or a developer." />
                <div class="grid gap-5 sm:grid-cols-2">
                    <x-field name="contact_name" label="Contact name" :required="true" maxlength="120" autocomplete="name" />
                    <x-field name="contact_role" label="Position" :optional="true" maxlength="120" autocomplete="organization-title" hint="e.g. Procurement Officer" />
                    <x-field name="email" label="Email" type="email" :required="true" maxlength="255" autocomplete="email" hint="We email your reference number and our bid decision here." />
                    <x-field name="phone" label="Phone" type="tel" :required="true" maxlength="30" autocomplete="tel" inputmode="tel" hint="e.g. (876) 555-0123" />
                </div>
            </x-fieldset>

            <x-fieldset n="2" title="The tender">
                <x-field name="title" label="Tender or project title" :required="true" maxlength="200" />
                <div class="grid gap-5 sm:grid-cols-2">
                    <x-field name="their_reference" label="Your tender reference" :optional="true" maxlength="80" hint="As printed on the invitation." />
                    <x-select name="method" label="Procurement method" :required="true" :options="collect(\App\Enums\ProcurementMethod::cases())->mapWithKeys(fn ($m) => [$m->value => $m->label()])->all()" />
                    <x-select name="parish" label="Parish" :optional="true" :options="array_combine(yps('parishes'), yps('parishes'))" />
                    <x-field name="location" label="Site or community" :optional="true" maxlength="160" />
                </div>
                <x-field name="scope" label="Scope of works" type="textarea" :required="true" maxlength="5000" rows="6" hint="A short description is enough; attach the documents below." />
                <x-field name="estimated_value" label="Estimated value or budget" :optional="true" maxlength="80" hint="Only if it is published in the invitation." />
            </x-fieldset>

            <x-fieldset n="3" title="Key dates">
                <div class="grid gap-5 sm:grid-cols-2">
                    <x-field name="due_date" label="Submission deadline: date" type="date" :required="true" :min="today()->format('Y-m-d')" />
                    <x-field name="due_time" label="Submission deadline: time" type="time" :required="true" value="14:00" hint="Jamaica time" />
                    <x-field name="site_visit_date" label="Site visit or pre-bid meeting" type="date" :optional="true" />
                    <x-field name="site_visit_time" label="Site visit time" type="time" :optional="true" />
                    <x-field name="clarification_due_on" label="Deadline for clarifications" type="date" :optional="true" />
                </div>
                <label class="choice"><input type="checkbox" name="bid_security" value="1" @checked(old('bid_security'))>A bid security or tender bond is required</label>
            </x-fieldset>

            <x-fieldset n="4" title="Tender documents" intro="Attach the invitation, bill of quantities and drawings, or paste a link to them (for example on GOJEP). Up to {{ \App\Models\Tender::MAX_FILES }} files, 10 MB each.">
                <div>
                    <label for="f-files" class="label">Documents <span class="opt">(optional)</span></label>
                    <input id="f-files" type="file" name="files[]" multiple class="input" accept=".{{ implode(',.', \App\Models\Tender::FILE_TYPES) }}" aria-describedby="f-files-hint">
                    <span id="f-files-hint" class="hint">PDF, Word, Excel or ZIP. Stored privately for our estimating team.</span>
                    <x-held-upload form="tender" field="files" />
                    <x-error for="files" /><x-error for="files.0" /><x-error for="files.1" /><x-error for="files.2" /><x-error for="files.3" /><x-error for="files.4" />
                </div>
                <x-field name="documents_url" label="Link to the documents" type="url" :optional="true" maxlength="300" placeholder="https://" />
                <x-field name="message" label="Anything else" type="textarea" :optional="true" maxlength="3000" />
            </x-fieldset>

            <div class="border-t-[1.5px] border-ink pt-6">
                <x-submit label="Send the invitation" />
                <p class="hint mt-3">By sending, you agree that we keep these details to respond to your tender. See our <a class="text-link" href="{{ route('privacy') }}">privacy notice</a>.</p>
            </div>
        </form>

        <aside class="space-y-6 lg:pt-6">
            <x-titleblock :light="true" :cols="1" :fields="['What happens next' => 'Bid / no-bid decision', '*Reply' => 'By email, well before your deadline', '*Reference' => 'TI-yy-00000']" />
            <div class="panel p-5">
                <h2 class="display-3 text-[1.25rem]">Need our credentials?</h2>
                <p class="mt-2 text-ink-2">Our one-page capability statement lists our services and the public contracts we have carried out.</p>
                <a href="{{ route('capability') }}" class="btn btn-outline mt-4 w-full"><x-icon name="file" class="h-4 w-4" />Capability statement</a>
            </div>
            <div class="panel p-5">
                <h2 class="font-display text-lg font-bold">Prefer to call?</h2>
                <a href="{{ tel_href(yps('phone')) }}" class="mt-2 inline-flex min-h-11 items-center gap-2 font-semibold text-link"><x-icon name="phone" class="h-4 w-4" />{{ format_phone(yps('phone')) }}</a>
                <a href="mailto:{{ yps('email') }}" class="flex min-h-11 items-center gap-2 font-semibold text-link"><x-icon name="mail" class="h-4 w-4" />{{ yps('email') }}</a>
            </div>
        </aside>
    </section>
</x-layouts.site>
