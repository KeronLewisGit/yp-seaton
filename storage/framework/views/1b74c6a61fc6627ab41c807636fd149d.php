
<nav class="tag-row" aria-label="Filter by status">
    <a href="<?php echo e(route($route, array_filter($extra ?? []))); ?>" class="tag" <?php if(! $current): ?> aria-current="true" <?php endif; ?>><?php echo e($all ?? 'All'); ?> <span class="count"><?php echo e($counts->sum()); ?></span></a>
    <?php $__currentLoopData = $cases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $case): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e(route($route, array_filter(($extra ?? []) + ['status' => $case->value]))); ?>" class="tag" <?php if($current === $case->value): ?> aria-current="true" <?php endif; ?>><?php echo e($case->label()); ?> <span class="count"><?php echo e($counts[$case->value] ?? 0); ?></span></a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</nav>
<?php /**PATH /Users/keronlewis/yp-seaton/resources/views/admin/partials/status-tabs.blade.php ENDPATH**/ ?>