<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['fields' => [], 'cols' => 2, 'light' => false]));

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

foreach (array_filter((['fields' => [], 'cols' => 2, 'light' => false]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<dl <?php echo e($attributes->class(['titleblock', 'light' => $light])); ?> style="--cols: <?php echo e($cols); ?>">
    <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($value === null || $value === '') continue; ?>
        <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(['wide' => str_starts_with($label, '*')]); ?>"><dt><?php echo e(ltrim($label, '*')); ?></dt><dd><?php echo e($value); ?></dd></div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</dl>
<?php /**PATH /Users/keronlewis/yp-seaton/resources/views/components/titleblock.blade.php ENDPATH**/ ?>