<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['project', 'heading' => 'h3']));

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

foreach (array_filter((['project', 'heading' => 'h3']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<article <?php echo e($attributes->merge(['class' => 'card-link sheet flex flex-col'])); ?> data-reveal>
    <div class="card-img relative aspect-[16/10] overflow-hidden border-b-[1.5px] border-ink">
        <?php if (isset($component)) { $__componentOriginalbc843bb087146ea7bf90eaac3fe60783 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbc843bb087146ea7bf90eaac3fe60783 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.photo','data' => ['key' => $project['photo'],'alt' => $project['photo_alt'],'sizes' => '(min-width: 1024px) 400px, (min-width: 640px) 50vw, 100vw','class' => 'h-full w-full']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('photo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['key' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($project['photo']),'alt' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($project['photo_alt']),'sizes' => '(min-width: 1024px) 400px, (min-width: 640px) 50vw, 100vw','class' => 'h-full w-full']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbc843bb087146ea7bf90eaac3fe60783)): ?>
<?php $attributes = $__attributesOriginalbc843bb087146ea7bf90eaac3fe60783; ?>
<?php unset($__attributesOriginalbc843bb087146ea7bf90eaac3fe60783); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbc843bb087146ea7bf90eaac3fe60783)): ?>
<?php $component = $__componentOriginalbc843bb087146ea7bf90eaac3fe60783; ?>
<?php unset($__componentOriginalbc843bb087146ea7bf90eaac3fe60783); ?>
<?php endif; ?>
        <span class="absolute left-3 top-3 bg-sea-900/90 px-2 py-1 text-[0.75rem] font-bold uppercase tracking-[0.12em] text-white"><?php echo e(\App\Support\Portfolio::sectorLabel($project['sector'])); ?></span>
    </div>
    <div class="flex flex-1 flex-col p-5">
        <<?php echo e($heading); ?> class="font-display text-[1.25rem] font-bold leading-snug tracking-tight"><a class="stretch" href="<?php echo e(route('projects.show', $project['slug'])); ?>"><?php echo e($project['title']); ?></a></<?php echo e($heading); ?>>
        <p class="mt-1 text-ink-3"><?php echo e($project['location']); ?><?php if(! empty($project['parish']) && ! str_contains($project['location'], $project['parish'])): ?>, <?php echo e($project['parish']); ?><?php endif; ?></p>
        <dl class="mt-auto grid grid-cols-2 gap-3 border-t border-line pt-4 text-sm">
            <div><dt class="text-ink-3">Value</dt><dd class="num font-display text-base font-bold"><?php echo e(jmd($project['value'] ?? null) ?? 'Not published'); ?></dd></div>
            <div><dt class="text-ink-3">Year</dt><dd class="num font-display text-base font-bold"><?php echo e($project['year'] ?? 'Not published'); ?></dd></div>
        </dl>
    </div>
</article>
<?php /**PATH /Users/keronlewis/yp-seaton/resources/views/components/project-card.blade.php ENDPATH**/ ?>