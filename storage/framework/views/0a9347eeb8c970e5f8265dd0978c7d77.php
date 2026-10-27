<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['tone' => 'dark', 'small' => false]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['tone' => 'dark', 'small' => false]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<span <?php echo e($attributes->merge(['class' => 'inline-flex items-center gap-2.5'])); ?>>
    <svg viewBox="0 0 48 48" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['flex-none', 'h-9 w-9' => $small, 'h-11 w-11' => ! $small]); ?>" aria-hidden="true">
        <path d="M24 2 43 13v22L24 46 5 35V13z" fill="#f2c14e" stroke="<?php echo e($tone === 'light' ? '#ffffff' : '#10232a'); ?>" stroke-width="2.5"/>
        <path d="M24 8.5 37.5 16.3v15.4L24 39.5 10.5 31.7V16.3z" fill="none" stroke="#10232a" stroke-width="1.2" opacity=".55"/>
        <text x="24" y="28.6" text-anchor="middle" font-family="Epilogue, ui-sans-serif, sans-serif" font-weight="800" font-size="12.5" letter-spacing="-.4" fill="#10232a">YPS</text>
    </svg>
    <span class="leading-none">
        <span class="<?php echo \Illuminate\Support\Arr::toCssClasses(['block font-display font-extrabold tracking-tight', 'text-[1.05rem]' => $small, 'text-[1.25rem]' => ! $small, 'text-white' => $tone === 'light', 'text-ink' => $tone !== 'light']); ?>">Y.P. Seaton</span>
        <span class="<?php echo \Illuminate\Support\Arr::toCssClasses(['mt-1 block text-[0.6875rem] font-semibold uppercase tracking-[0.16em]', 'text-white/70' => $tone === 'light', 'text-ink-3' => $tone !== 'light']); ?>">&amp; Associates</span>
    </span>
</span>
<?php /**PATH /Users/keronlewis/yp-seaton/resources/views/components/logo.blade.php ENDPATH**/ ?>