<?php
    $sources = $project['sources'] ?? [];
    $block = ['Client' => $project['client'] ?? 'Not published', 'Parish' => $project['parish'] ?? null, '*Value' => jmd($project['value'] ?? null) ?? 'Not published', '*Year' => $project['year_label'] ?? 'Not published'];
?>
<?php if (isset($component)) { $__componentOriginalfefb4fd9b7004fa65f70c415ac76903e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfefb4fd9b7004fa65f70c415ac76903e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.site','data' => ['title' => $project['title'],'description' => $project['summary']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.site'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($project['title']),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($project['summary'])]); ?>
    <?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['title' => $project['title'],'kicker' => \App\Support\Portfolio::sectorLabel($project['sector']),'sheet' => 'P-'.e(str_pad((string) (\App\Support\Portfolio::all()->keys()->search($project['slug']) + 1), 2, '0', STR_PAD_LEFT)).'','lead' => $project['summary'],'block' => $block]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($project['title']),'kicker' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(\App\Support\Portfolio::sectorLabel($project['sector'])),'sheet' => 'P-'.e(str_pad((string) (\App\Support\Portfolio::all()->keys()->search($project['slug']) + 1), 2, '0', STR_PAD_LEFT)).'','lead' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($project['summary']),'block' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($block)]); ?>
        <p class="mt-6"><a href="<?php echo e(route('projects.index')); ?>" class="inline-flex min-h-11 items-center gap-2 font-semibold text-white/85 hover:text-white"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
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
<?php endif; ?>All projects</a></p>
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

    <section class="wrap mt-12 grid gap-12 md:mt-16 lg:grid-cols-[minmax(0,1fr)_22rem]">
        <div class="min-w-0">
            <figure>
                <?php if (isset($component)) { $__componentOriginalbc843bb087146ea7bf90eaac3fe60783 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbc843bb087146ea7bf90eaac3fe60783 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.photo','data' => ['key' => $project['photo'],'alt' => $project['photo_alt'],'sizes' => '(min-width: 1024px) 760px, 100vw','class' => 'aspect-[16/9] border-[1.5px] border-ink']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('photo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['key' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($project['photo']),'alt' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($project['photo_alt']),'sizes' => '(min-width: 1024px) 760px, 100vw','class' => 'aspect-[16/9] border-[1.5px] border-ink']); ?>
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
                <figcaption class="photo-caption">Illustrative photo: <?php echo e(lcfirst($project['photo_alt'])); ?>. It does not show this project. <a class="text-link" href="<?php echo e(route('credits')); ?>">Credit</a></figcaption>
            </figure>

            <?php if(! empty($project['scope'])): ?>
                <?php if (isset($component)) { $__componentOriginala53af10838414bdf9be8a5f6cb1173cd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala53af10838414bdf9be8a5f6cb1173cd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dim','data' => ['n' => '01','left' => true,'class' => 'mt-12']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dim'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['n' => '01','left' => true,'class' => 'mt-12']); ?>Scope of works <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala53af10838414bdf9be8a5f6cb1173cd)): ?>
<?php $attributes = $__attributesOriginala53af10838414bdf9be8a5f6cb1173cd; ?>
<?php unset($__attributesOriginala53af10838414bdf9be8a5f6cb1173cd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala53af10838414bdf9be8a5f6cb1173cd)): ?>
<?php $component = $__componentOriginala53af10838414bdf9be8a5f6cb1173cd; ?>
<?php unset($__componentOriginala53af10838414bdf9be8a5f6cb1173cd); ?>
<?php endif; ?>
                <ul class="ticked mt-5 space-y-2.5"><?php $__currentLoopData = $project['scope']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $line): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($line); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
            <?php endif; ?>

            <?php if (isset($component)) { $__componentOriginala53af10838414bdf9be8a5f6cb1173cd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala53af10838414bdf9be8a5f6cb1173cd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dim','data' => ['n' => '02','left' => true,'class' => 'mt-12']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dim'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['n' => '02','left' => true,'class' => 'mt-12']); ?>Sources <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala53af10838414bdf9be8a5f6cb1173cd)): ?>
<?php $attributes = $__attributesOriginala53af10838414bdf9be8a5f6cb1173cd; ?>
<?php unset($__attributesOriginala53af10838414bdf9be8a5f6cb1173cd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala53af10838414bdf9be8a5f6cb1173cd)): ?>
<?php $component = $__componentOriginala53af10838414bdf9be8a5f6cb1173cd; ?>
<?php unset($__componentOriginala53af10838414bdf9be8a5f6cb1173cd); ?>
<?php endif; ?>
            <ul class="mt-5 divide-y divide-line border-y border-line">
                <?php $__currentLoopData = $sources; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><a href="<?php echo e($s['url']); ?>" target="_blank" rel="noopener" class="flex min-h-14 items-center gap-4 py-3 hover:text-link"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'file','class' => 'h-5 w-5 flex-none text-ink-3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'file','class' => 'h-5 w-5 flex-none text-ink-3']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?><span class="flex-1"><span class="block font-semibold"><?php echo e($s['label']); ?></span><?php if(! empty($s['date'])): ?><span class="block text-sm text-ink-3"><?php echo e($s['date']); ?></span><?php endif; ?></span><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'external','class' => 'h-4 w-4 flex-none']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'external','class' => 'h-4 w-4 flex-none']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?><span class="sr-only">(opens in a new tab)</span></a></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>

        <aside class="space-y-6">
            <?php if (isset($component)) { $__componentOriginal3f328dc1eb04e6bac058b75b5bbb8af2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3f328dc1eb04e6bac058b75b5bbb8af2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.titleblock','data' => ['light' => true,'cols' => 1,'fields' => ['Client' => $project['client'] ?? 'Not published', 'Location' => $project['location'].(! empty($project['parish']) && ! str_contains($project['location'], $project['parish']) ? ', '.$project['parish'] : ''), 'Value' => jmd($project['value'] ?? null) ? jmd($project['value']).(! empty($project['value_label']) ? ' · '.$project['value_label'] : '') : 'Not published', 'Year' => $project['year_label'] ?? 'Not published', 'Status' => $project['status'] ?? null]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('titleblock'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['light' => true,'cols' => 1,'fields' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['Client' => $project['client'] ?? 'Not published', 'Location' => $project['location'].(! empty($project['parish']) && ! str_contains($project['location'], $project['parish']) ? ', '.$project['parish'] : ''), 'Value' => jmd($project['value'] ?? null) ? jmd($project['value']).(! empty($project['value_label']) ? ' · '.$project['value_label'] : '') : 'Not published', 'Year' => $project['year_label'] ?? 'Not published', 'Status' => $project['status'] ?? null])]); ?>
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
            <div class="panel p-5">
                <h2 class="font-display text-lg font-bold">Similar works out to tender?</h2>
                <p class="mt-2 text-ink-2">Send us the invitation and documents.</p>
                <a href="<?php echo e(route('tenders.create')); ?>" class="btn btn-primary mt-4 w-full">Invite us to tender</a>
            </div>
        </aside>
    </section>

    <?php if($related->isNotEmpty()): ?>
        <section class="wrap mt-20">
            <?php if (isset($component)) { $__componentOriginala53af10838414bdf9be8a5f6cb1173cd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala53af10838414bdf9be8a5f6cb1173cd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dim','data' => ['n' => '03','left' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dim'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['n' => '03','left' => true]); ?>More projects <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala53af10838414bdf9be8a5f6cb1173cd)): ?>
<?php $attributes = $__attributesOriginala53af10838414bdf9be8a5f6cb1173cd; ?>
<?php unset($__attributesOriginala53af10838414bdf9be8a5f6cb1173cd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala53af10838414bdf9be8a5f6cb1173cd)): ?>
<?php $component = $__componentOriginala53af10838414bdf9be8a5f6cb1173cd; ?>
<?php unset($__componentOriginala53af10838414bdf9be8a5f6cb1173cd); ?>
<?php endif; ?>
            <div class="mt-6 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                <?php $__currentLoopData = $related; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if (isset($component)) { $__componentOriginaldbcceabf4a99a34f9999233ae1fef693 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldbcceabf4a99a34f9999233ae1fef693 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.project-card','data' => ['project' => $p]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('project-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['project' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($p)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldbcceabf4a99a34f9999233ae1fef693)): ?>
<?php $attributes = $__attributesOriginaldbcceabf4a99a34f9999233ae1fef693; ?>
<?php unset($__attributesOriginaldbcceabf4a99a34f9999233ae1fef693); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldbcceabf4a99a34f9999233ae1fef693)): ?>
<?php $component = $__componentOriginaldbcceabf4a99a34f9999233ae1fef693; ?>
<?php unset($__componentOriginaldbcceabf4a99a34f9999233ae1fef693); ?>
<?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </section>
    <?php endif; ?>
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
<?php /**PATH /Users/keronlewis/yp-seaton/resources/views/pages/projects/show.blade.php ENDPATH**/ ?>