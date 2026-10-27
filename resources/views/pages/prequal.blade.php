@php($types = collect(\App\Enums\VendorType::cases())->mapWithKeys(fn ($t) => [$t->value => $t->label()])->all())
<x-layouts.site title="Subcontractor and supplier prequalification" description="Prequalify as a subcontractor, supplier, plant-hire firm or consultant to Y.P. Seaton & Associates. Upload your TCC, NCC/PPC registration and insurance once; we remind you before they expire.">
    <x-page-header title="Work with us as a subcontractor or supplier" kicker="Prequalification" sheet="P-01" photo="paving"
        lead="Register once with your company details, trades and current certificates. Our procurement team checks them, and we email you a renewal link before any certificate expires." />

    <section class="wrap mt-12 grid gap-12 md:mt-16 lg:grid-cols-[minmax(0,1fr)_20rem]">
        <form method="POST" action="{{ route('prequal.store') }}" enctype="multipart/form-data" class="min-w-0 space-y-10" x-data="prequalForm(@js((string) old('type', 'subcontractor')))" @submit="submit">
            @csrf
            <x-form-errors />
            <x-honeypot />

            <x-fieldset n="1" title="Your company">
                <fieldset>
                    <legend class="label">What do you provide?</legend>
                    <div class="grid gap-2 sm:grid-cols-2">
                        @foreach ($types as $v => $t)
                            <label class="choice"><input type="radio" name="type" value="{{ $v }}" x-model="type" @checked(old('type', 'subcontractor') === $v) required>{{ $t }}</label>
                        @endforeach
                    </div>
                    <x-error for="type" />
                </fieldset>
                <div class="grid gap-5 sm:grid-cols-2">
                    <x-field name="company_name" label="Registered company name" :required="true" maxlength="160" autocomplete="organization" />
                    <x-field name="trading_as" label="Trading as" :optional="true" maxlength="160" />
                    <x-field name="trn" label="Taxpayer Registration Number (TRN)" :required="true" maxlength="11" inputmode="numeric" hint="9 digits, e.g. 123-456-789" />
                    <x-field name="company_number" label="Companies Office registration no." :optional="true" maxlength="40" />
                    <x-field name="year_established" label="Year established" type="number" :optional="true" min="1900" :max="now()->year" inputmode="numeric" />
                    <x-select name="employees" label="Number of employees" :optional="true" :options="\App\Models\Vendor::EMPLOYEE_BANDS" />
                </div>
                <x-field name="address" label="Business address" :required="true" maxlength="240" autocomplete="street-address" />
                <x-select name="parish" label="Parish" :required="true" :options="array_combine(yps('parishes'), yps('parishes'))" />
            </x-fieldset>

            <x-fieldset n="2" title="Contact person">
                <div class="grid gap-5 sm:grid-cols-2">
                    <x-field name="contact_name" label="Name" :required="true" maxlength="120" autocomplete="name" />
                    <x-field name="contact_role" label="Position" :optional="true" maxlength="120" autocomplete="organization-title" />
                    <x-field name="email" label="Email" type="email" :required="true" maxlength="255" autocomplete="email" hint="Renewal reminders are sent here." />
                    <x-field name="phone" label="Phone" type="tel" :required="true" maxlength="30" autocomplete="tel" inputmode="tel" hint="e.g. (876) 555-0123" />
                </div>
            </x-fieldset>

            <x-fieldset n="3" title="What you do">
                <x-checks name="trades" label="Trades and supply categories" :options="yps('trades')" hint="Choose all that apply." cols="sm:grid-cols-2" />
                <x-checks name="parishes_served" label="Parishes you work in" :options="array_combine(yps('parishes'), yps('parishes'))" :optional="true" cols="grid-cols-2 sm:grid-cols-3" />
                <div x-show="type === 'subcontractor'">
                    <x-field name="registration_grade" label="NCC/PPC works category and grade" :optional="true" maxlength="120" hint="As shown on your registration certificate." />
                </div>
                <x-field name="experience" label="Comparable work in the last five years" type="textarea" :optional="true" maxlength="3000" hint="Projects, clients and approximate contract sizes." />
            </x-fieldset>

            <x-fieldset n="4" title="Certificates" intro="PDF, JPG or PNG, 5 MB each. Certificates are stored privately and seen only by our procurement team.">
                @foreach (\App\Enums\DocumentKind::cases() as $kind)
                    @php($k = 'docs.'.$kind->value)
                    @php($forAll = $kind !== \App\Enums\DocumentKind::Registration && $kind !== \App\Enums\DocumentKind::Other)
                    <div class="panel space-y-4 p-5" @if($kind === \App\Enums\DocumentKind::Registration) x-show="type === 'subcontractor'" @endif>
                        <div>
                            <h3 class="font-display text-lg font-bold">{{ $kind->label() }}@if($kind === \App\Enums\DocumentKind::Other) <span class="font-sans text-base font-normal text-ink-3">(optional)</span>@elseif($kind === \App\Enums\DocumentKind::Registration) <span class="font-sans text-base font-normal text-ink-3">(required for subcontractors)</span>@endif</h3>
                            <p class="hint">{{ $kind->hint() }}</p>
                        </div>
                        <div>
                            <label for="doc-{{ $kind->value }}" class="label">File</label>
                            <input id="doc-{{ $kind->value }}" type="file" name="docs[{{ $kind->value }}][file]" class="input" accept=".pdf,.jpg,.jpeg,.png" @if($forAll) required @endif @error($k.'.file') aria-invalid="true" @enderror>
                            <x-error :for="$k.'.file'" />
                        </div>
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label for="num-{{ $kind->value }}" class="label">{{ $kind->numberLabel() }} <span class="opt">(optional)</span></label>
                                <input id="num-{{ $kind->value }}" name="docs[{{ $kind->value }}][number]" value="{{ old($k.'.number') }}" class="input" maxlength="80">
                            </div>
                            @if ($kind->expires())
                                <div>
                                    <label for="exp-{{ $kind->value }}" class="label">Expiry date</label>
                                    <input id="exp-{{ $kind->value }}" type="date" name="docs[{{ $kind->value }}][expires_on]" value="{{ old($k.'.expires_on') }}" class="input" min="{{ today()->addDay()->format('Y-m-d') }}" @if($forAll) required @endif @error($k.'.expires_on') aria-invalid="true" @enderror>
                                    <x-error :for="$k.'.expires_on'" />
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </x-fieldset>

            <x-fieldset n="5" title="Declaration">
                <x-field name="message" label="Anything else we should know" type="textarea" :optional="true" maxlength="2000" />
                <label class="choice items-start"><input type="checkbox" name="consent" value="1" class="mt-0.5" @checked(old('consent')) required><span>I confirm the information and certificates are accurate and current, and I agree to Y.P. Seaton &amp; Associates keeping them to assess and manage our prequalification (<a class="text-link" href="{{ route('privacy') }}">privacy notice</a>).</span></label>
                <x-error for="consent" />
            </x-fieldset>

            <div class="border-t-[1.5px] border-ink pt-6"><x-submit label="Send for prequalification" /></div>
        </form>

        <aside class="space-y-6 lg:pt-6">
            <div class="panel p-5">
                <h2 class="font-display text-lg font-bold">What you need</h2>
                <ul class="ticked mt-3 space-y-2 text-ink-2">
                    <li>Your TRN and a current Tax Compliance Certificate</li>
                    <li>Subcontractors: NCC/PPC registration certificate showing your works category and grade</li>
                    <li>Public liability insurance certificate</li>
                    <li>The expiry date of each</li>
                </ul>
                <p class="hint mt-4">This list is a starting point; the firm will confirm its own requirements.</p>
            </div>
            <x-titleblock :light="true" :cols="1" :fields="['Reference' => 'PQ-yy-00000', '*Renewals' => 'Emailed link, 30 days before expiry', '*Who sees it' => 'Procurement team only']" />
        </aside>
    </section>
</x-layouts.site>
