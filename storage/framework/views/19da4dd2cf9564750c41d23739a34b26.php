<?php if (isset($component)) { $__componentOriginalfefb4fd9b7004fa65f70c415ac76903e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfefb4fd9b7004fa65f70c415ac76903e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.site','data' => ['title' => 'Site map','description' => 'Every page on the Y.P. Seaton & Associates website.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.site'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Site map','description' => 'Every page on the Y.P. Seaton & Associates website.']); ?>
    <?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['title' => 'Site map','kicker' => 'Site map','sheet' => 'L-03','lead' => 'Every public page on this website.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Site map','kicker' => 'Site map','sheet' => 'L-03','lead' => 'Every public page on this website.']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e)): ?>
<?php $attributes = $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e; ?>
<?php unset($__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e)): ?>
<?php $component = $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e; ?>
<?php unset($__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e); ?>
<?php endif; ?>
    <section class="wrap mt-12 grid gap-10 md:mt-16 md:grid-cols-3">
        <div><h2 class="font-display text-lg font-bold">The firm</h2><ul class="mt-3 space-y-1">
            <?php $__currentLoopData = ['home' => 'Home', 'services' => 'Services', 'about' => 'About the firm', 'capability' => 'Capability statement', 'contact' => 'Contact', 'privacy' => 'Privacy notice', 'credits' => 'Photo credits']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r => $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><a class="inline-flex min-h-11 items-center text-link" href="<?php echo e(route($r)); ?>"><?php echo e($l); ?></a></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul></div>
        <div><h2 class="font-display text-lg font-bold">Projects</h2><ul class="mt-3 space-y-1">
            <li><a class="inline-flex min-h-11 items-center text-link" href="<?php echo e(route('projects.index')); ?>">All projects</a></li>
            <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><a class="inline-flex min-h-11 items-center text-link" href="<?php echo e(route('projects.show', $p['slug'])); ?>"><?php echo e($p['title']); ?></a></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul></div>
        <div><h2 class="font-display text-lg font-bold">Work with us</h2><ul class="mt-3 space-y-1">
            <li><a class="inline-flex min-h-11 items-center text-link" href="<?php echo e(route('tenders.create')); ?>">Invite us to tender</a></li>
            <li><a class="inline-flex min-h-11 items-center text-link" href="<?php echo e(route('prequal.create')); ?>">Prequalification</a></li>
            <li><a class="inline-flex min-h-11 items-center text-link" href="<?php echo e(route('careers.index')); ?>">Careers</a></li>
            <li><a class="inline-flex min-h-11 items-center text-link" href="<?php echo e(route('careers.apply')); ?>">Apply</a></li>
            <?php $__currentLoopData = $jobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $j): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><a class="inline-flex min-h-11 items-center text-link" href="<?php echo e(route('careers.show', $j->slug)); ?>"><?php echo e($j->title); ?></a></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul></div>
    </section>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfefb4fd9b7004fa65f70c415ac76903e)): ?>
<?php $attributes = $__attributesOriginalfefb4fd9b7004fa65f70c415ac76903e; ?>
<?php unset($__attributesOriginalfefb4fd9b7004fa65f70c415ac76903e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfefb4fd9b7004fa65f70c415ac76903e)): ?>
<?php $component = $__componentOriginalfefb4fd9b7004fa65f70c415ac76903e; ?>
<?php unset($__componentOriginalfefb4fd9b7004fa65f70c415ac76903e); ?>
<?php endif; ?>
<?php /**PATH /Users/keronlewis/yp-seaton/resources/views/pages/sitemap.blade.php ENDPATH**/ ?>