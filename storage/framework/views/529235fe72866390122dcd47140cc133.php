<?php if (isset($component)) { $__componentOriginalc8c9fd5d7827a77a31381de67195f0c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.admin','data' => ['title' => $job->exists ? 'Edit posting' : 'New posting']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($job->exists ? 'Edit posting' : 'New posting')]); ?>
     <?php $__env->slot('actions', null, []); ?> 
        <a href="<?php echo e(route('admin.jobs.index')); ?>" class="a-btn a-btn-ghost"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'arrow-left','class' => 'h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'arrow-left','class' => 'h-4 w-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>Postings</a>
        <?php if($job->exists && $job->isOpen()): ?><a href="<?php echo e(route('careers.show', $job)); ?>" class="a-btn a-btn-ghost" target="_blank" rel="noopener"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'external','class' => 'h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'external','class' => 'h-4 w-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>View</a><?php endif; ?>
     <?php $__env->endSlot(); ?>
    <form method="POST" action="<?php echo e($job->exists ? route('admin.jobs.update', $job) : route('admin.jobs.store')); ?>" class="a-card max-w-3xl space-y-5 p-5 md:p-6">
        <?php echo csrf_field(); ?>
        <?php if($job->exists): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>
        <div><label for="j-title" class="mb-1 block font-semibold">Title</label><input id="j-title" name="title" value="<?php echo e(old('title', $job->title)); ?>" class="a-input w-full" required maxlength="160"></div>
        <div class="grid gap-4 sm:grid-cols-2">
            <div><label for="j-cat" class="mb-1 block font-semibold">Type of work</label><select id="j-cat" name="category" class="a-input w-full"><?php $__currentLoopData = \App\Enums\JobCategory::cases(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($c->value); ?>" <?php if(old('category', $job->category?->value) === $c->value): echo 'selected'; endif; ?>><?php echo e($c->label()); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div>
            <div><label for="j-type" class="mb-1 block font-semibold">Employment</label><select id="j-type" name="employment_type" class="a-input w-full"><?php $__currentLoopData = \App\Enums\EmploymentType::cases(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($c->value); ?>" <?php if(old('employment_type', $job->employment_type?->value) === $c->value): echo 'selected'; endif; ?>><?php echo e($c->label()); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div>
            <div><label for="j-loc" class="mb-1 block font-semibold">Location</label><input id="j-loc" name="location" value="<?php echo e(old('location', $job->location)); ?>" class="a-input w-full" required maxlength="160"></div>
            <div><label for="j-open" class="mb-1 block font-semibold">Openings</label><input id="j-open" type="number" min="1" max="500" name="openings" value="<?php echo e(old('openings', $job->openings)); ?>" class="a-input w-full" required></div>
            <div><label for="j-status" class="mb-1 block font-semibold">Status</label><select id="j-status" name="status" class="a-input w-full"><?php $__currentLoopData = \App\Enums\JobStatus::cases(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($c->value); ?>" <?php if(old('status', $job->status?->value) === $c->value): echo 'selected'; endif; ?>><?php echo e($c->label()); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div>
            <div><label for="j-close" class="mb-1 block font-semibold">Closes on <span class="font-normal text-ink-3">(optional)</span></label><input id="j-close" type="date" name="closes_on" value="<?php echo e(old('closes_on', $job->closes_on?->format('Y-m-d'))); ?>" class="a-input w-full"></div>
        </div>
        <div><label for="j-sum" class="mb-1 block font-semibold">Summary</label><textarea id="j-sum" name="summary" class="a-input" required maxlength="1000"><?php echo e(old('summary', $job->summary)); ?></textarea></div>
        <div><label for="j-duties" class="mb-1 block font-semibold">Duties <span class="font-normal text-ink-3">(one per line)</span></label><textarea id="j-duties" name="duties" class="a-input" rows="6"><?php echo e(old('duties', $job->duties)); ?></textarea></div>
        <div><label for="j-req" class="mb-1 block font-semibold">Requirements <span class="font-normal text-ink-3">(one per line)</span></label><textarea id="j-req" name="requirements" class="a-input" rows="6"><?php echo e(old('requirements', $job->requirements)); ?></textarea></div>
        <button class="a-btn a-btn-primary">Save posting</button>
    </form>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3)): ?>
<?php $attributes = $__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3; ?>
<?php unset($__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc8c9fd5d7827a77a31381de67195f0c3)): ?>
<?php $component = $__componentOriginalc8c9fd5d7827a77a31381de67195f0c3; ?>
<?php unset($__componentOriginalc8c9fd5d7827a77a31381de67195f0c3); ?>
<?php endif; ?>
<?php /**PATH /Users/keronlewis/yp-seaton/resources/views/admin/jobs/form.blade.php ENDPATH**/ ?>