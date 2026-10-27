@props(['tone' => 'dark', 'small' => false])
{{--
    Redrawn from the firm's own logo (a gold hexagon badge with a "YPS" monogram, 2014–2019 site)
    as vector, until the firm supplies the artwork. Name set in Epilogue.
--}}
<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-2.5']) }}>
    <svg viewBox="0 0 48 48" @class(['flex-none', 'h-9 w-9' => $small, 'h-11 w-11' => ! $small]) aria-hidden="true">
        <path d="M24 2 43 13v22L24 46 5 35V13z" fill="#f2c14e" stroke="{{ $tone === 'light' ? '#ffffff' : '#10232a' }}" stroke-width="2.5"/>
        <path d="M24 8.5 37.5 16.3v15.4L24 39.5 10.5 31.7V16.3z" fill="none" stroke="#10232a" stroke-width="1.2" opacity=".55"/>
        <text x="24" y="28.6" text-anchor="middle" font-family="Epilogue, ui-sans-serif, sans-serif" font-weight="800" font-size="12.5" letter-spacing="-.4" fill="#10232a">YPS</text>
    </svg>
    <span class="leading-none">
        <span @class(['block font-display font-extrabold tracking-tight', 'text-[1.05rem]' => $small, 'text-[1.25rem]' => ! $small, 'text-white' => $tone === 'light', 'text-ink' => $tone !== 'light'])>Y.P. Seaton</span>
        <span @class(['mt-1 block text-[0.6875rem] font-semibold uppercase tracking-[0.16em]', 'text-white/70' => $tone === 'light', 'text-ink-3' => $tone !== 'light'])>&amp; Associates</span>
    </span>
</span>
