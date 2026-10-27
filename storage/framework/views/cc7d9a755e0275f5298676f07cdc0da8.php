<?php
    use App\Support\Portfolio;
    $nmia = Portfolio::find('nmia-shoreline-protection');
    $services = (array) yps('services');
?>
<?php if (isset($component)) { $__componentOriginalfefb4fd9b7004fa65f70c415ac76903e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfefb4fd9b7004fa65f70c415ac76903e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.site','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.site'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    
    <section class="contours relative isolate overflow-hidden bg-sea-900 text-white on-dark">
        <div class="hero-photo absolute inset-0 -z-10">
            <?php if (isset($component)) { $__componentOriginalbc843bb087146ea7bf90eaac3fe60783 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbc843bb087146ea7bf90eaac3fe60783 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.photo','data' => ['key' => 'revetment','alt' => '','eager' => true,'sizes' => '100vw','class' => 'h-full w-full','position' => 'center 60%']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('photo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['key' => 'revetment','alt' => '','eager' => true,'sizes' => '100vw','class' => 'h-full w-full','position' => 'center 60%']); ?>
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
        <div class="wrap grid gap-10 pb-12 pt-12 md:pb-20 md:pt-24 lg:grid-cols-[minmax(0,1fr)_20rem] lg:items-end">
            <div class="min-w-0">
                <?php if (isset($component)) { $__componentOriginala53af10838414bdf9be8a5f6cb1173cd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala53af10838414bdf9be8a5f6cb1173cd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dim','data' => ['n' => 'YPS','left' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dim'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['n' => 'YPS','left' => true]); ?>Civil engineering contractors · Kingston · since <?php echo e(yps('founded')); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala53af10838414bdf9be8a5f6cb1173cd)): ?>
<?php $attributes = $__attributesOriginala53af10838414bdf9be8a5f6cb1173cd; ?>
<?php unset($__attributesOriginala53af10838414bdf9be8a5f6cb1173cd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala53af10838414bdf9be8a5f6cb1173cd)): ?>
<?php $component = $__componentOriginala53af10838414bdf9be8a5f6cb1173cd; ?>
<?php unset($__componentOriginala53af10838414bdf9be8a5f6cb1173cd); ?>
<?php endif; ?>
                <h1 class="display-1 mt-6 max-w-[15ch]">Shorelines, sewers and housing infrastructure for Jamaica.</h1>
                <p class="lead mt-6 max-w-[56ch] text-white/85">Y.P. Seaton &amp; Associates builds the public works that keep roads open, runways dry and new communities serviced, for government agencies and private developers across the island.</p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="<?php echo e(route('tenders.create')); ?>" class="btn btn-light">Invite us to tender<?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'arrow-right','class' => 'nudge h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'arrow-right','class' => 'nudge h-4 w-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?></a>
                    <a href="<?php echo e(route('capability.pdf')); ?>" class="btn btn-on-dark"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'download','class' => 'h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'download','class' => 'h-4 w-4']); ?>
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
                </div>
            </div>
            <?php if (isset($component)) { $__componentOriginal3f328dc1eb04e6bac058b75b5bbb8af2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3f328dc1eb04e6bac058b75b5bbb8af2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.titleblock','data' => ['class' => 'hidden lg:grid','fields' => ['Founded' => (string) yps('founded'), 'Office' => 'Kingston 10', '*Contractor' => yps('name'), '*Telephone' => format_phone(yps('phone'))]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('titleblock'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'hidden lg:grid','fields' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['Founded' => (string) yps('founded'), 'Office' => 'Kingston 10', '*Contractor' => yps('name'), '*Telephone' => format_phone(yps('phone'))])]); ?>
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
        <div class="armour tall on-sea" aria-hidden="true"></div>
    </section>

    
    <section class="wrap mt-14 md:mt-20" aria-labelledby="record-title">
        <h2 id="record-title" class="sr-only">On the public record</h2>
        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
            <div class="figure-stamp"><b><?php echo e(yps('founded')); ?></b><span class="mt-2 block text-ink-2">Founded as electrical and mechanical engineering contractors</span></div>
            <div class="figure-stamp"><b><?php echo e(jmd($nmia['value'] ?? null)); ?></b><span class="mt-2 block text-ink-2">Shoreline protection at Norman Manley airport, approved by Cabinet in 2021</span></div>
            <div class="figure-stamp"><b>7.4 km</b><span class="mt-2 block text-ink-2">Sewage force main for the UDC at Caymanas Estate, 2015</span></div>
            <div class="figure-stamp"><b>800</b><span class="mt-2 block text-ink-2">Housing solutions served by the Whitehall Phase 2 infrastructure contract</span></div>
        </div>
        <p class="hint mt-6">Figures as published by the Jamaica Observer, the UDC and JIS. <a class="text-link" href="<?php echo e(route('projects.index')); ?>">See the sources on each project.</a></p>
    </section>

    
    <section class="wrap mt-20 md:mt-28" aria-labelledby="services-title">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <?php if (isset($component)) { $__componentOriginala53af10838414bdf9be8a5f6cb1173cd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala53af10838414bdf9be8a5f6cb1173cd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dim','data' => ['n' => '01','left' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dim'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['n' => '01','left' => true]); ?>What we build <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala53af10838414bdf9be8a5f6cb1173cd)): ?>
<?php $attributes = $__attributesOriginala53af10838414bdf9be8a5f6cb1173cd; ?>
<?php unset($__attributesOriginala53af10838414bdf9be8a5f6cb1173cd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala53af10838414bdf9be8a5f6cb1173cd)): ?>
<?php $component = $__componentOriginala53af10838414bdf9be8a5f6cb1173cd; ?>
<?php unset($__componentOriginala53af10838414bdf9be8a5f6cb1173cd); ?>
<?php endif; ?>
                <h2 id="services-title" class="display-2 mt-4 max-w-[20ch]">Six lines of work, one contractor.</h2>
            </div>
            <a href="<?php echo e(route('services')); ?>" class="btn btn-outline">All services<?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'arrow-right','class' => 'nudge h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'arrow-right','class' => 'nudge h-4 w-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?></a>
        </div>
        <div class="mt-10 grid border-l-[1.5px] border-t-[1.5px] border-ink sm:grid-cols-2 lg:grid-cols-3">
            <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('services')); ?>#<?php echo e($key); ?>" class="group flex flex-col gap-3 border-b-[1.5px] border-r-[1.5px] border-ink bg-surface p-6 hover:bg-surface-2" data-reveal>
                    <span class="flex items-center justify-between"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => $s['icon'],'class' => 'h-7 w-7 text-primary']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($s['icon']),'class' => 'h-7 w-7 text-primary']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?><?php if (isset($component)) { $__componentOriginalfa1c46b4de47764b2535e866609946dd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfa1c46b4de47764b2535e866609946dd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.callout','data' => ['n' => $loop->iteration,'class' => 'text-ink-3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('callout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['n' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($loop->iteration),'class' => 'text-ink-3']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfa1c46b4de47764b2535e866609946dd)): ?>
<?php $attributes = $__attributesOriginalfa1c46b4de47764b2535e866609946dd; ?>
<?php unset($__attributesOriginalfa1c46b4de47764b2535e866609946dd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfa1c46b4de47764b2535e866609946dd)): ?>
<?php $component = $__componentOriginalfa1c46b4de47764b2535e866609946dd; ?>
<?php unset($__componentOriginalfa1c46b4de47764b2535e866609946dd); ?>
<?php endif; ?></span>
                    <span class="font-display text-[1.25rem] font-bold leading-snug tracking-tight"><?php echo e($s['title']); ?></span>
                    <span class="text-ink-2"><?php echo e($s['summary']); ?></span>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </section>

    
    <section class="drawing-grid mt-20 border-y-[1.5px] border-ink py-16 md:mt-28 md:py-24" aria-labelledby="projects-title">
        <div class="wrap">
            <div class="flex flex-wrap items-end justify-between gap-4">
                <div>
                    <?php if (isset($component)) { $__componentOriginala53af10838414bdf9be8a5f6cb1173cd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala53af10838414bdf9be8a5f6cb1173cd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dim','data' => ['n' => '02','left' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dim'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['n' => '02','left' => true]); ?>Project portfolio <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala53af10838414bdf9be8a5f6cb1173cd)): ?>
<?php $attributes = $__attributesOriginala53af10838414bdf9be8a5f6cb1173cd; ?>
<?php unset($__attributesOriginala53af10838414bdf9be8a5f6cb1173cd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala53af10838414bdf9be8a5f6cb1173cd)): ?>
<?php $component = $__componentOriginala53af10838414bdf9be8a5f6cb1173cd; ?>
<?php unset($__componentOriginala53af10838414bdf9be8a5f6cb1173cd); ?>
<?php endif; ?>
                    <h2 id="projects-title" class="display-2 mt-4 max-w-[22ch]">Public contracts, with the sources to prove them.</h2>
                </div>
                <a href="<?php echo e(route('projects.index')); ?>" class="btn btn-outline">All <?php echo e($projectCount); ?> projects<?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'arrow-right','class' => 'nudge h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'arrow-right','class' => 'nudge h-4 w-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?></a>
            </div>
            <div class="mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                <?php $__currentLoopData = $featured; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if (isset($component)) { $__componentOriginaldbcceabf4a99a34f9999233ae1fef693 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldbcceabf4a99a34f9999233ae1fef693 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.project-card','data' => ['project' => $project]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('project-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['project' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($project)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldbcceabf4a99a34f9999233ae1fef693)): ?>
<?php $attributes = $__attributesOriginaldbcceabf4a99a34f9999233ae1fef693; ?>
<?php unset($__attributesOriginaldbcceabf4a99a34f9999233ae1fef693); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldbcceabf4a99a34f9999233ae1fef693)): ?>
<?php $component = $__componentOriginaldbcceabf4a99a34f9999233ae1fef693; ?>
<?php unset($__componentOriginaldbcceabf4a99a34f9999233ae1fef693); ?>
<?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>

    
    <section class="wrap mt-20 md:mt-28" aria-labelledby="proc-title">
        <?php if (isset($component)) { $__componentOriginala53af10838414bdf9be8a5f6cb1173cd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala53af10838414bdf9be8a5f6cb1173cd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dim','data' => ['n' => '03','left' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dim'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['n' => '03','left' => true]); ?>For procuring entities <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala53af10838414bdf9be8a5f6cb1173cd)): ?>
<?php $attributes = $__attributesOriginala53af10838414bdf9be8a5f6cb1173cd; ?>
<?php unset($__attributesOriginala53af10838414bdf9be8a5f6cb1173cd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala53af10838414bdf9be8a5f6cb1173cd)): ?>
<?php $component = $__componentOriginala53af10838414bdf9be8a5f6cb1173cd; ?>
<?php unset($__componentOriginala53af10838414bdf9be8a5f6cb1173cd); ?>
<?php endif; ?>
        <h2 id="proc-title" class="display-2 mt-4 max-w-[22ch]">Everything a tender panel asks for, in one place.</h2>
        <ol class="mt-10 grid gap-6 lg:grid-cols-3">
            <li class="sheet p-6">
                <?php if (isset($component)) { $__componentOriginalfa1c46b4de47764b2535e866609946dd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfa1c46b4de47764b2535e866609946dd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.callout','data' => ['n' => '1','class' => 'text-primary']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('callout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['n' => '1','class' => 'text-primary']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfa1c46b4de47764b2535e866609946dd)): ?>
<?php $attributes = $__attributesOriginalfa1c46b4de47764b2535e866609946dd; ?>
<?php unset($__attributesOriginalfa1c46b4de47764b2535e866609946dd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfa1c46b4de47764b2535e866609946dd)): ?>
<?php $component = $__componentOriginalfa1c46b4de47764b2535e866609946dd; ?>
<?php unset($__componentOriginalfa1c46b4de47764b2535e866609946dd); ?>
<?php endif; ?>
                <h3 class="mt-4 font-display text-xl font-bold">Read the capability statement</h3>
                <p class="mt-2 text-ink-2">Services, contracts, values and sources on one printable page.</p>
                <a href="<?php echo e(route('capability')); ?>" class="btn btn-outline btn-sm mt-5">Open it</a>
            </li>
            <li class="sheet p-6">
                <?php if (isset($component)) { $__componentOriginalfa1c46b4de47764b2535e866609946dd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfa1c46b4de47764b2535e866609946dd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.callout','data' => ['n' => '2','class' => 'text-primary']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('callout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['n' => '2','class' => 'text-primary']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfa1c46b4de47764b2535e866609946dd)): ?>
<?php $attributes = $__attributesOriginalfa1c46b4de47764b2535e866609946dd; ?>
<?php unset($__attributesOriginalfa1c46b4de47764b2535e866609946dd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfa1c46b4de47764b2535e866609946dd)): ?>
<?php $component = $__componentOriginalfa1c46b4de47764b2535e866609946dd; ?>
<?php unset($__componentOriginalfa1c46b4de47764b2535e866609946dd); ?>
<?php endif; ?>
                <h3 class="mt-4 font-display text-xl font-bold">Send the invitation</h3>
                <p class="mt-2 text-ink-2">Upload the bidding documents or link to GOJEP. You get a reference number straight away.</p>
                <a href="<?php echo e(route('tenders.create')); ?>" class="btn btn-primary btn-sm mt-5">Invite us to tender</a>
            </li>
            <li class="sheet p-6">
                <?php if (isset($component)) { $__componentOriginalfa1c46b4de47764b2535e866609946dd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfa1c46b4de47764b2535e866609946dd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.callout','data' => ['n' => '3','class' => 'text-primary']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('callout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['n' => '3','class' => 'text-primary']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfa1c46b4de47764b2535e866609946dd)): ?>
<?php $attributes = $__attributesOriginalfa1c46b4de47764b2535e866609946dd; ?>
<?php unset($__attributesOriginalfa1c46b4de47764b2535e866609946dd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfa1c46b4de47764b2535e866609946dd)): ?>
<?php $component = $__componentOriginalfa1c46b4de47764b2535e866609946dd; ?>
<?php unset($__componentOriginalfa1c46b4de47764b2535e866609946dd); ?>
<?php endif; ?>
                <h3 class="mt-4 font-display text-xl font-bold">Share project documents</h3>
                <p class="mt-2 text-ink-2">On contract, we give your project team a private link to drawings, reports and certificates.</p>
                <a href="<?php echo e(route('contact')); ?>" class="btn btn-outline btn-sm mt-5">Ask about it</a>
            </li>
        </ol>
    </section>

    
    <section class="wrap mt-20 grid gap-6 md:mt-28 lg:grid-cols-2">
        <div class="contours relative isolate overflow-hidden bg-sea-900 p-8 text-white on-dark md:p-10">
            <?php if (isset($component)) { $__componentOriginala53af10838414bdf9be8a5f6cb1173cd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala53af10838414bdf9be8a5f6cb1173cd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dim','data' => ['left' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dim'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['left' => true]); ?>Subcontractors and suppliers <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala53af10838414bdf9be8a5f6cb1173cd)): ?>
<?php $attributes = $__attributesOriginala53af10838414bdf9be8a5f6cb1173cd; ?>
<?php unset($__attributesOriginala53af10838414bdf9be8a5f6cb1173cd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala53af10838414bdf9be8a5f6cb1173cd)): ?>
<?php $component = $__componentOriginala53af10838414bdf9be8a5f6cb1173cd; ?>
<?php unset($__componentOriginala53af10838414bdf9be8a5f6cb1173cd); ?>
<?php endif; ?>
            <h2 class="display-3 mt-4">Prequalify once. We remind you before your certificates expire.</h2>
            <p class="mt-3 text-white/80">Upload your TCC, NCC/PPC registration and insurance with their expiry dates.</p>
            <a href="<?php echo e(route('prequal.create')); ?>" class="btn btn-light mt-6">Start prequalification<?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'arrow-right','class' => 'nudge h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'arrow-right','class' => 'nudge h-4 w-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?></a>
        </div>
        <div class="sheet p-8 md:p-10">
            <?php if (isset($component)) { $__componentOriginala53af10838414bdf9be8a5f6cb1173cd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala53af10838414bdf9be8a5f6cb1173cd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dim','data' => ['left' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dim'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['left' => true]); ?>Careers <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala53af10838414bdf9be8a5f6cb1173cd)): ?>
<?php $attributes = $__attributesOriginala53af10838414bdf9be8a5f6cb1173cd; ?>
<?php unset($__attributesOriginala53af10838414bdf9be8a5f6cb1173cd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala53af10838414bdf9be8a5f6cb1173cd)): ?>
<?php $component = $__componentOriginala53af10838414bdf9be8a5f6cb1173cd; ?>
<?php unset($__componentOriginala53af10838414bdf9be8a5f6cb1173cd); ?>
<?php endif; ?>
            <h2 class="display-3 mt-4">Tradesmen, operators, foremen, engineers.</h2>
            <p class="mt-3 text-ink-2"><?php echo e($openJobs ? $openJobs.' '.\Illuminate\Support\Str::plural('opening', $openJobs).' posted now. ' : ''); ?>Site roles can apply with a phone number; no CV needed.</p>
            <a href="<?php echo e(route('careers.index')); ?>" class="btn btn-primary mt-6">See openings<?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'arrow-right','class' => 'nudge h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'arrow-right','class' => 'nudge h-4 w-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?></a>
        </div>
    </section>

    
    <section class="wrap mt-20 md:mt-28" aria-labelledby="visit-title">
        <div class="grid gap-8 border-t-[1.5px] border-ink pt-10 md:grid-cols-3">
            <div><h2 id="visit-title" class="display-3">Talk to the office</h2><p class="mt-2 text-ink-2"><?php echo e(yps('hours.0.0')); ?>, <?php echo e(yps('hours.0.1')); ?>. <?php echo e(yps('hours.1.0')); ?>, <?php echo e(yps('hours.1.1')); ?>.</p></div>
            <div>
                <p class="kicker text-ink-3">Telephone</p>
                <a href="<?php echo e(tel_href(yps('phone'))); ?>" class="mt-1 inline-flex min-h-11 items-center font-display text-2xl font-bold text-link"><?php echo e(format_phone(yps('phone'))); ?></a>
                <p class="kicker mt-3 text-ink-3">Email</p>
                <a href="mailto:<?php echo e(yps('email')); ?>" class="mt-1 inline-flex min-h-11 items-center text-lg font-semibold text-link"><?php echo e(yps('email')); ?></a>
            </div>
            <div>
                <p class="kicker text-ink-3">Office</p>
                <p class="mt-1 text-lg"><?php echo e(yps('address.street')); ?><br><?php echo e(yps('address.city')); ?>, <?php echo e(yps('address.country')); ?></p>
                <a href="<?php echo e(yps('map_url')); ?>" target="_blank" rel="noopener" class="mt-1 inline-flex min-h-11 items-center gap-1.5 font-semibold text-link">Get directions<?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
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
<?php endif; ?><span class="sr-only">(opens Google Maps)</span></a>
            </div>
        </div>
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
<?php /**PATH /Users/keronlewis/yp-seaton/resources/views/pages/home.blade.php ENDPATH**/ ?>