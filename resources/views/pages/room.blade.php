<x-layouts.site :title="'Project documents: '.$room->name" :mobile-bar="false">
    <x-page-header :title="$room->name" kicker="Project documents" sheet="D-01" :lead="'Shared with '.$room->client_name.' by Y.P. Seaton & Associates.'"
        :block="['Client' => $room->client_name, 'Documents' => (string) $room->documents->count(), '*Link valid until' => (isset($until) && $room->link_expires_at && $until->lt($room->link_expires_at) ? $until : $room->link_expires_at)?->format('j F Y')]" />
    <section class="wrap mt-12 md:mt-16">
        @if ($room->description)<p class="measure mb-8 whitespace-pre-line text-ink-2">{{ $room->description }}</p>@endif
        @forelse ($room->documents->groupBy(fn ($d) => $d->category->value) as $category => $docs)
            <div class="mb-10">
                <x-dim :left="true">{{ \App\Enums\RoomCategory::from($category)->label() }}</x-dim>
                <ul class="mt-4 divide-y divide-line border-y border-line">
                    @foreach ($docs as $d)
                        <li><a href="{{ $room->documentUrl($d, $until ?? null) }}" class="flex min-h-14 items-center gap-4 px-1 py-3 hover:bg-surface-2">
                            <span class="grid h-10 w-12 flex-none place-items-center border-[1.5px] border-ink font-display text-xs font-bold">{{ $d->extension() }}</span>
                            <span class="min-w-0 flex-1"><span class="block font-semibold">{{ $d->title }}</span><span class="block text-sm text-ink-3">{{ file_size($d->size) }} · added {{ $d->created_at->format('j M Y') }}</span></span>
                            <x-icon name="download" class="h-5 w-5 flex-none text-link" /><span class="sr-only">Download</span>
                        </a></li>
                    @endforeach
                </ul>
            </div>
        @empty
            <p class="panel p-6 text-ink-2">No documents have been added yet.</p>
        @endforelse
        <p class="hint mt-6"><x-icon name="lock" class="inline h-4 w-4" /> This private link was sent to {{ $room->client_name }}. Please do not forward it outside your organisation. Questions: {{ format_phone(yps('phone')) }} or {{ yps('email') }}.</p>
    </section>
</x-layouts.site>
