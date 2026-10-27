<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['n', 'title', 'intro' => null]));

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

foreach (array_filter((['n', 'title', 'intro' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<fieldset <?php echo e($attributes->merge(['class' => 'space-y-5 border-t-[1.5px] border-ink pt-6'])); ?>>
    <legend class="fieldset-title float-left mb-5 w-full"><?php if (isset($component)) { $__componentOriginalfa1c46b4de47764b2535e866609946dd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfa1c46b4de47764b2535e866609946dd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.callout','data' => ['n' => $n]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('callout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['n' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($n)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfa1c46b4de47764b2535e866609946dd)): ?>
<?php $attributes = $__attributesOriginalfa1c46b4de47764b2535e866609946dd; ?>
<?php unset($__attributesOriginalfa1c46b4de47764b2535e866609946dd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfa1c46b4de47764b2535e866609946dd)): ?>
<?php $component = $__componentOriginalfa1c46b4de47764b2535e866609946dd; ?>
<?php unset($__componentOriginalfa1c46b4de47764b2535e866609946dd); ?>
<?php endif; ?><?php echo e($title); ?></legend>
    <?php if($intro): ?><p class="clear-both -mt-2 text-ink-2"><?php echo e($intro); ?></p><?php endif; ?>
    <div class="clear-both space-y-5"><?php echo e($slot); ?></div>
</fieldset>
<?php /**PATH /Users/keronlewis/yp-seaton/resources/views/components/fieldset.blade.php ENDPATH**/ ?>