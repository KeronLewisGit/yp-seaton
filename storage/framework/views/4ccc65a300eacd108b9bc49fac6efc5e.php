
<section class="a-card min-w-0" id="timeline" aria-labelledby="timeline-title">
    <h2 id="timeline-title" class="px-5 pt-4 font-semibold">Timeline</h2>
    <?php if($action ?? null): ?>
        <form method="POST" action="<?php echo e($action); ?>" class="space-y-3 px-5 pt-3">
            <?php echo csrf_field(); ?>
            <label for="note-body" class="sr-only">Add a note</label>
            <textarea id="note-body" name="body" class="a-input" required maxlength="3000" placeholder="Add a note: a call, a clarification, a decision"></textarea>
            <button class="a-btn a-btn-primary">Add note</button>
        </form>
    <?php endif; ?>
    <ol class="mt-4">
        <?php $__empty_1 = true; $__currentLoopData = $notes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $note): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <li class="flex gap-3 border-t border-line px-5 py-3">
                <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => match ($note->kind) { 'note' => 'message', 'status' => 'check-circle', 'assign' => 'users', 'file' => 'file', default => 'dot' },'class' => 'mt-0.5 h-4 w-4 flex-none text-ink-3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(match ($note->kind) { 'note' => 'message', 'status' => 'check-circle', 'assign' => 'users', 'file' => 'file', default => 'dot' }),'class' => 'mt-0.5 h-4 w-4 flex-none text-ink-3']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
                <div class="min-w-0">
                    <p class="whitespace-pre-line break-words"><?php echo e($note->body); ?></p>
                    <p class="mt-0.5 text-xs text-ink-3"><?php echo e($note->user->name ?? 'System'); ?> · <time datetime="<?php echo e($note->created_at->toIso8601String()); ?>"><?php echo e($note->created_at->format('j M Y, g:i a')); ?></time></p>
                </div>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <li class="border-t border-line px-5 py-4 text-ink-3">Nothing yet.</li>
        <?php endif; ?>
    </ol>
</section>
<?php /**PATH /Users/keronlewis/yp-seaton/resources/views/admin/partials/timeline.blade.php ENDPATH**/ ?>