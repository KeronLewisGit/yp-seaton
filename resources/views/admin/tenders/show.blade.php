<x-layouts.admin :title="$tender->reference">
    <x-slot:actions>
        <a href="{{ route('admin.tenders.index') }}" class="a-btn a-btn-ghost"><x-icon name="arrow-left" class="h-4 w-4" />Register</a>
        <a href="mailto:{{ $tender->email }}?subject={{ rawurlencode('Re: '.$tender->title.' ('.$tender->reference.')') }}" class="a-btn a-btn-ghost"><x-icon name="mail" class="h-4 w-4" />Email</a>
        <a href="{{ tel_href($tender->phone) }}" class="a-btn a-btn-primary"><x-icon name="phone" class="h-4 w-4" />Call {{ $tender->contact_name }}</a>
    </x-slot:actions>

    <div class="grid gap-6 xl:grid-cols-[minmax(0,1.5fr)_minmax(0,1fr)]">
        <div class="min-w-0 space-y-6">
            <section class="a-card p-5 md:p-6">
                <div class="flex flex-wrap items-center gap-2"><x-status :status="$tender->status" /><x-chip :tone="$tender->dueTone()" icon="clock">{{ $tender->dueLabel() }}</x-chip>@if($tender->bid_security)<x-chip tone="neutral" icon="shield">Bid security required</x-chip>@endif</div>
                <h2 class="mt-3 text-xl font-bold">{{ $tender->title }}</h2>
                <p class="text-ink-2">{{ $tender->entity_name }} · {{ \App\Models\Tender::SECTORS[$tender->sector] ?? $tender->sector }}</p>
                <dl class="dl-grid mt-5">
                    <dt>Submission deadline</dt><dd class="font-semibold">{{ $tender->submission_due_at->format('l j F Y, g:i a') }}</dd>
                    <dt>Method</dt><dd>{{ $tender->method->label() }}</dd>
                    @if ($tender->their_reference)<dt>Their reference</dt><dd class="num">{{ $tender->their_reference }}</dd>@endif
                    <dt>Location</dt><dd>{{ trim(($tender->location ?? '').($tender->parish ? ', '.$tender->parish : ''), ', ') ?: '—' }}</dd>
                    @if ($tender->estimated_value)<dt>Estimated value</dt><dd>{{ $tender->estimated_value }} <span class="text-ink-3">(as stated by the entity)</span></dd>@endif
                    @if ($tender->clarification_due_on)<dt>Clarifications by</dt><dd>{{ $tender->clarification_due_on->format('j F Y') }}</dd>@endif
                    @if ($tender->site_visit_at)<dt>Site visit / pre-bid</dt><dd>{{ $tender->site_visit_at->format('l j F Y, g:i a') }}</dd>@endif
                    @if ($tender->documents_url)<dt>Documents online</dt><dd><a class="text-link underline" href="{{ $tender->documents_url }}" rel="noopener noreferrer" target="_blank">{{ \Illuminate\Support\Str::limit($tender->documents_url, 60) }}</a></dd>@endif
                    <dt>Received</dt><dd>{{ $tender->created_at->format('j M Y, g:i a') }}</dd>
                    @if ($tender->submitted_at)<dt>Bid submitted</dt><dd>{{ $tender->submitted_at->format('j M Y, g:i a') }}</dd>@endif
                </dl>
                <h3 class="mt-6 font-semibold">Scope of works</h3>
                <p class="measure mt-1 whitespace-pre-line text-ink-2">{{ $tender->scope }}</p>
                @if ($tender->message)<h3 class="mt-5 font-semibold">Message</h3><p class="measure mt-1 whitespace-pre-line text-ink-2">{{ $tender->message }}</p>@endif
            </section>

            <section class="a-card" aria-labelledby="files-title">
                <h2 id="files-title" class="px-5 pt-4 font-semibold">Tender documents</h2>
                @forelse ($tender->files as $f)
                    <a href="{{ route('admin.tenders.file', [$tender, $f]) }}" class="mt-3 flex items-center gap-3 border-t border-line px-5 py-3 hover:bg-surface-2">
                        <x-icon name="file" class="h-5 w-5 flex-none text-ink-3" /><span class="min-w-0 flex-1 truncate font-medium">{{ $f->original_name }}</span><span class="num text-sm text-ink-3">{{ file_size($f->size) }}</span><x-icon name="download" class="h-4 w-4 text-ink-3" />
                    </a>
                @empty
                    <p class="px-5 py-4 text-ink-3">No files attached{{ $tender->documents_url ? '; see the link above' : '' }}.</p>
                @endforelse
                <p class="border-t border-line px-5 py-3 text-xs text-ink-3"><x-icon name="lock" class="inline h-3.5 w-3.5" /> Stored privately; each opening is logged on the timeline.</p>
            </section>
        </div>

        <div class="min-w-0 space-y-6">
            <section class="a-card p-5">
                <h2 class="font-semibold">Bid / no-bid</h2>
                <form method="POST" action="{{ route('admin.tenders.update', $tender) }}" class="mt-3 space-y-4">
                    @csrf @method('PATCH')
                    <div><label for="t-status" class="mb-1 block text-sm text-ink-2">Status</label>
                        <select id="t-status" name="status" class="a-input w-full">@foreach (\App\Enums\TenderStatus::cases() as $s)<option value="{{ $s->value }}" @selected($tender->status === $s)>{{ $s->label() }}</option>@endforeach</select></div>
                    <div><label for="t-assignee" class="mb-1 block text-sm text-ink-2">Estimator</label>
                        <select id="t-assignee" name="assigned_to" class="a-input w-full"><option value="">Unassigned</option>@foreach ($staff as $s)<option value="{{ $s->id }}" @selected($tender->assigned_to === $s->id)>{{ $s->name }}</option>@endforeach</select></div>
                    <button class="a-btn a-btn-primary">Save</button>
                </form>
            </section>
            <section class="a-card p-5">
                <h2 class="font-semibold">Procuring entity contact</h2>
                <dl class="dl-grid mt-3">
                    <dt>Name</dt><dd>{{ $tender->contact_name }}@if($tender->contact_role)<span class="text-ink-3">, {{ $tender->contact_role }}</span>@endif</dd>
                    <dt>Phone</dt><dd><a class="text-link underline" href="{{ tel_href($tender->phone) }}">{{ format_phone($tender->phone) }}</a></dd>
                    <dt>Email</dt><dd><a class="text-link underline" href="mailto:{{ $tender->email }}">{{ $tender->email }}</a></dd>
                </dl>
            </section>
            @include('admin.partials.timeline', ['notes' => $tender->notes, 'action' => route('admin.tenders.note', $tender)])
        </div>
    </div>
</x-layouts.admin>
