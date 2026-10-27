<x-layouts.site title="Thank you" :mobile-bar="false">
    <x-page-header photo="revetment" title="Thank you. We have it." :kicker="$kind" sheet="OK" lead="Your reference number is below. We have emailed it to you as well." />
    <section class="wrap mt-12 md:mt-16">
        <div class="max-w-xl">
            <x-titleblock :light="true" :cols="2" :fields="['Reference' => $reference, 'Received' => now()->format('j M Y, g:i a'), '*Submission' => $kind, '*Received by' => 'Y.P. Seaton & Associates, '.yps('address.street')]" />
            <p class="mt-6 text-ink-2">Quote the reference if you call or email, and we will find your submission straight away.</p>
        </div>
        <div class="mt-8 flex flex-wrap gap-3">
            <a href="{{ tel_href(yps('phone')) }}" class="btn btn-outline"><x-icon name="phone" class="h-4 w-4" />{{ format_phone(yps('phone')) }}</a>
            <a href="{{ route('projects.index') }}" class="btn btn-outline">See our projects</a>
            <a href="{{ route('home') }}" class="btn btn-primary">Back to the home page</a>
        </div>
    </section>
</x-layouts.site>
