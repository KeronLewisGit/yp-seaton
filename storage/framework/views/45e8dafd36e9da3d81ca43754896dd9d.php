<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['title', 'lead' => null, 'kicker' => null, 'sheet' => null, 'photo' => null, 'position' => 'center', 'block' => null]));

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

foreach (array_filter((['title', 'lead' => null, 'kicker' => null, 'sheet' => null, 'photo' => null, 'position' => 'center', 'block' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $fields = $block ?? [
        'Sheet' => $sheet ?? 'YPS',
        'Rev.' => 'A · '.now()->format('M Y'),
        '*Drawing' => $kicker ?? $title,
        '*Contractor' => 'Y.P. Seaton & Associates · Kingston 10',
    ];
?>
<section <?php echo e($attributes->merge(['class' => 'contours relative isolate overflow-hidden bg-sea-900 text-white on-dark'])); ?>>
    <?php if($photo): ?>
        <div class="hero-photo absolute inset-0 -z-10">
            <?php if (isset($component)) { $__componentOriginalbc843bb087146ea7bf90eaac3fe60783 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbc843bb087146ea7bf90eaac3fe60783 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.photo','data' => ['key' => $photo,'alt' => '','eager' => true,'sizes' => '100vw','class' => 'h-full w-full','position' => $position]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('photo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['key' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($photo),'alt' => '','eager' => true,'sizes' => '100vw','class' => 'h-full w-full','position' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($position)]); ?>
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
            <div class="hero-scrim absolute inset-0"></div>
        </div>
    <?php endif; ?>
    <div class="wrap grid gap-8 pb-10 pt-10 md:pb-14 md:pt-16 lg:grid-cols-[minmax(0,1fr)_19rem] lg:items-end lg:gap-12">
        <div class="min-w-0">
            <?php if($kicker): ?><?php if (isset($component)) { $__componentOriginala53af10838414bdf9be8a5f6cb1173cd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala53af10838414bdf9be8a5f6cb1173cd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dim','data' => ['n' => $sheet,'left' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dim'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['n' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($sheet),'left' => true]); ?><?php echo e($kicker); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala53af10838414bdf9be8a5f6cb1173cd)): ?>
<?php $attributes = $__attributesOriginala53af10838414bdf9be8a5f6cb1173cd; ?>
<?php unset($__attributesOriginala53af10838414bdf9be8a5f6cb1173cd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala53af10838414bdf9be8a5f6cb1173cd)): ?>
<?php $component = $__componentOriginala53af10838414bdf9be8a5f6cb1173cd; ?>
<?php unset($__componentOriginala53af10838414bdf9be8a5f6cb1173cd); ?>
<?php endif; ?><?php endif; ?>
            <h1 class="display-2 mt-5 max-w-4xl"><?php echo e($title); ?></h1>
            <?php if($lead): ?><p class="lead mt-4 text-white/85 md:mt-5"><?php echo e($lead); ?></p><?php endif; ?>
            <?php echo e($slot); ?>

        </div>
        <?php if (isset($component)) { $__componentOriginal3f328dc1eb04e6bac058b75b5bbb8af2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3f328dc1eb04e6bac058b75b5bbb8af2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.titleblock','data' => ['fields' => $fields,'class' => 'hidden lg:grid']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('titleblock'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['fields' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($fields),'class' => 'hidden lg:grid']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3f328dc1eb04e6bac058b75b5bbb8af2)): ?>
<?php $attributes = $__attributesOriginal3f328dc1eb04e6bac058b75b5bbb8af2; ?>
<?php unset($__attributesOriginal3f328dc1eb04e6bac058b75b5bbb8af2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3f328dc1eb04e6bac058b75b5bbb8af2)): ?>
<?php $component = $__componentOriginal3f328dc1eb04e6bac058b75b5bbb8af2; ?>
<?php unset($__componentOriginal3f328dc1eb04e6bac058b75b5bbb8af2); ?>
<?php endif; ?>
    </div>
    <div class="armour on-sea" aria-hidden="true"></div>
</section>
<?php /**PATH /Users/keronlewis/yp-seaton/resources/views/components/page-header.blade.php ENDPATH**/ ?>