<?php ($about = (array) yps('about')); ?>
<?php ($principal = (array) yps('principal')); ?>
<?php if (isset($component)) { $__componentOriginalfefb4fd9b7004fa65f70c415ac76903e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfefb4fd9b7004fa65f70c415ac76903e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.site','data' => ['title' => 'About the firm','description' => 'Y.P. Seaton & Associates: founded in 1969 as electrical and mechanical engineering contractors, now a Kingston civil engineering and building contractor.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.site'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'About the firm','description' => 'Y.P. Seaton & Associates: founded in 1969 as electrical and mechanical engineering contractors, now a Kingston civil engineering and building contractor.']); ?>
    <?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['title' => 'Building Jamaica since 1969','kicker' => 'About the firm','sheet' => 'A-01','photo' => 'boj','position' => 'center 30%','lead' => $about['intro']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Building Jamaica since 1969','kicker' => 'About the firm','sheet' => 'A-01','photo' => 'boj','position' => 'center 30%','lead' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($about['intro'])]); ?>
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

    <section class="wrap mt-12 grid gap-12 md:mt-16 lg:grid-cols-[minmax(0,1fr)_20rem]">
        <div class="prose-copy measure min-w-0 text-[1.0625rem]">
            <?php $__currentLoopData = $about['paragraphs']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><p><?php echo e($p); ?></p><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <h2>Our mission</h2>
            <p><?php echo e($about['mission']); ?></p>
            <p class="hint">Text from the firm's own website, <?php echo e($about['source']); ?>.</p>
        </div>
        <aside class="space-y-6">
            <?php if (isset($component)) { $__componentOriginal3f328dc1eb04e6bac058b75b5bbb8af2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3f328dc1eb04e6bac058b75b5bbb8af2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.titleblock','data' => ['light' => true,'cols' => 1,'fields' => ['Company' => yps('name'), 'Founded' => (string) yps('founded'), 'Office' => yps('address.street').', '.yps('address.city'), $principal['title'] => $principal['name'].' ('.$principal['known_as'].')']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('titleblock'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['light' => true,'cols' => 1,'fields' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['Company' => yps('name'), 'Founded' => (string) yps('founded'), 'Office' => yps('address.street').', '.yps('address.city'), $principal['title'] => $principal['name'].' ('.$principal['known_as'].')'])]); ?>
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
            <p class="hint"><?php echo e($principal['name']); ?> is named as <?php echo e($principal['title']); ?> by the <?php echo e($principal['source']['label']); ?>, <?php echo e($principal['source']['date']); ?>.</p>
        </aside>
    </section>

    <section class="wrap mt-20">
        <?php if (isset($component)) { $__componentOriginala53af10838414bdf9be8a5f6cb1173cd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala53af10838414bdf9be8a5f6cb1173cd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dim','data' => ['n' => '01','left' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dim'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['n' => '01','left' => true]); ?>Timeline from the public record <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala53af10838414bdf9be8a5f6cb1173cd)): ?>
<?php $attributes = $__attributesOriginala53af10838414bdf9be8a5f6cb1173cd; ?>
<?php unset($__attributesOriginala53af10838414bdf9be8a5f6cb1173cd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala53af10838414bdf9be8a5f6cb1173cd)): ?>
<?php $component = $__componentOriginala53af10838414bdf9be8a5f6cb1173cd; ?>
<?php unset($__componentOriginala53af10838414bdf9be8a5f6cb1173cd); ?>
<?php endif; ?>
        <ol class="mt-8 border-l-[1.5px] border-ink">
            <li class="relative pb-8 pl-8"><span class="absolute -left-[7px] top-1.5 h-3 w-3 bg-primary"></span><p class="num font-display text-xl font-bold">1969</p><p class="mt-1 text-ink-2">Founded as electrical and mechanical engineering contractors.</p></li>
            <?php $__currentLoopData = \App\Support\Portfolio::all()->filter(fn ($p) => ! empty($p['year']))->sortBy('year'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="relative pb-8 pl-8 last:pb-0"><span class="absolute -left-[7px] top-1.5 h-3 w-3 bg-primary"></span><p class="num font-display text-xl font-bold"><?php echo e($p['year']); ?></p><p class="mt-1 text-ink-2"><a class="text-link" href="<?php echo e(route('projects.show', $p['slug'])); ?>"><?php echo e($p['title']); ?></a>, <?php echo e($p['parish']); ?>. <?php echo e($p['status']); ?>.</p></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ol>
    </section>

    <section class="wrap mt-16 flex flex-wrap gap-3">
        <a href="<?php echo e(route('capability')); ?>" class="btn btn-primary"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'file','class' => 'h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'file','class' => 'h-4 w-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>Capability statement</a>
        <a href="<?php echo e(route('contact')); ?>" class="btn btn-outline">Contact the office</a>
    </section>
    <p class="wrap photo-caption mt-8">Header photo: the Bank of Jamaica tower, Kingston, from the firm's 2022 website.</p>
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
<?php /**PATH /Users/keronlewis/yp-seaton/resources/views/pages/about.blade.php ENDPATH**/ ?>