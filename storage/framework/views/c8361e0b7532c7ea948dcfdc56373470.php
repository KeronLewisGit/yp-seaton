<?php
    $services = (array) yps('services');
    $principal = (array) yps('principal');
    $total = $projects->sum(fn ($p) => (float) ($p['value'] ?? 0));
?>
<!DOCTYPE html>
<html lang="en-JM" data-theme="light">
<head>
    <?php echo $__env->make('partials.head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <title>Capability statement · <?php echo e(yps('short_name')); ?></title>
    <meta name="description" content="One-page capability statement for <?php echo e(yps('name')); ?>: services, public contracts, values and sources.">
    <?php if(yps('preview')): ?><meta name="robots" content="noindex"><?php endif; ?>
</head>
<body class="bg-surface-2 text-ink">
    <div class="no-print border-b border-line bg-surface">
        <div class="wrap flex min-h-16 flex-wrap items-center gap-3 py-2">
            <a href="<?php echo e(route('home')); ?>" class="mr-auto inline-flex min-h-11 items-center gap-2 font-semibold text-link"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
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
<?php endif; ?>Back to the website</a>
            <button type="button" onclick="window.print()" class="btn btn-outline btn-sm"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'print','class' => 'h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'print','class' => 'h-4 w-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>Print</button>
            <a href="<?php echo e(route('capability.pdf')); ?>" class="btn btn-primary btn-sm"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
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
<?php endif; ?>Download PDF</a>
        </div>
    </div>

    <main class="cs-page my-6 border border-line p-6 shadow-sm sm:p-10 print:my-0 print:p-0">
        <header class="flex flex-wrap items-start justify-between gap-6 border-b-[3px] border-[#10232a] pb-5">
            <div>
                <?php if (isset($component)) { $__componentOriginal987d96ec78ed1cf75b349e2e5981978f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal987d96ec78ed1cf75b349e2e5981978f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.logo','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal987d96ec78ed1cf75b349e2e5981978f)): ?>
<?php $attributes = $__attributesOriginal987d96ec78ed1cf75b349e2e5981978f; ?>
<?php unset($__attributesOriginal987d96ec78ed1cf75b349e2e5981978f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal987d96ec78ed1cf75b349e2e5981978f)): ?>
<?php $component = $__componentOriginal987d96ec78ed1cf75b349e2e5981978f; ?>
<?php unset($__componentOriginal987d96ec78ed1cf75b349e2e5981978f); ?>
<?php endif; ?>
                <p class="mt-3 text-sm font-semibold uppercase tracking-[0.14em] text-[#3b5158]">Capability statement · <?php echo e(now()->format('F Y')); ?></p>
            </div>
            <dl class="text-sm leading-relaxed sm:text-right">
                <div><?php echo e(yps('address.street')); ?>, <?php echo e(yps('address.city')); ?>, <?php echo e(yps('address.country')); ?></div>
                <div>Tel. <?php echo e(format_phone(yps('phone'))); ?> · <?php echo e(yps('email')); ?></div>
                <div><?php echo e(parse_url(route('home'), PHP_URL_HOST)); ?></div>
            </dl>
        </header>

        <section class="mt-6 grid gap-6 sm:grid-cols-[minmax(0,1.3fr)_minmax(0,1fr)]">
            <div>
                <h1 class="font-display text-[1.75rem] font-extrabold leading-tight tracking-tight"><?php echo e(yps('name')); ?></h1>
                <p class="mt-2 text-[0.9375rem] leading-relaxed"><?php echo e(yps('about.intro')); ?></p>
            </div>
            <dl class="titleblock light self-start text-sm" style="--cols: 2">
                <div><dt>Founded</dt><dd><?php echo e(yps('founded')); ?></dd></div>
                <div><dt>Office</dt><dd>Kingston 10</dd></div>
                <div class="wide"><dt><?php echo e($principal['title']); ?></dt><dd><?php echo e($principal['name']); ?></dd></div>
                <div class="wide"><dt>Contracts listed below</dt><dd class="num"><?php echo e($projects->count()); ?> · <?php echo e(jmd($total)); ?> combined published value</dd></div>
            </dl>
        </section>

        <section class="mt-7">
            <h2 class="border-b border-[#10232a] pb-1 text-xs font-bold uppercase tracking-[0.16em]">Core services</h2>
            <ul class="mt-3 grid gap-x-6 gap-y-2.5 text-[0.875rem] sm:grid-cols-2">
                <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><strong class="font-display"><?php echo e($s['title']); ?>.</strong> <?php echo e($s['summary']); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </section>

        <section class="mt-7">
            <h2 class="border-b border-[#10232a] pb-1 text-xs font-bold uppercase tracking-[0.16em]">Public contracts on record</h2>
            <div class="overflow-x-auto">
                <table class="mt-2 w-full min-w-[36rem] border-collapse text-left text-[0.8125rem]">
                    <thead><tr class="border-b border-[#9fb0b5] text-[0.6875rem] uppercase tracking-wider text-[#3b5158]"><th class="py-1.5 pr-3 font-bold">Project</th><th class="py-1.5 pr-3 font-bold">Client</th><th class="py-1.5 pr-3 font-bold">Year</th><th class="py-1.5 pr-3 text-right font-bold">Value</th><th class="py-1.5 font-bold">Source</th></tr></thead>
                    <tbody>
                        <?php $__currentLoopData = $projects->sortByDesc(fn ($p) => $p['year'] ?? 0); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="border-b border-[#d8dedf] align-top">
                                <td class="py-1.5 pr-3"><span class="font-semibold"><?php echo e($p['title']); ?></span><br><span class="text-[#3b5158]"><?php echo e($p['parish']); ?> · <?php echo e($p['status']); ?></span></td>
                                <td class="py-1.5 pr-3"><?php echo e($p['client'] ?? '–'); ?></td>
                                <td class="num py-1.5 pr-3"><?php echo e($p['year'] ?? '–'); ?></td>
                                <td class="num whitespace-nowrap py-1.5 pr-3 text-right font-semibold"><?php echo e(jmd($p['value'] ?? null) ?? '–'); ?></td>
                                <td class="py-1.5 text-[#3b5158]"><?php echo e($p['sources'][0]['label'] ?? ''); ?><?php if(! empty($p['sources'][0]['date'])): ?>, <?php echo e($p['sources'][0]['date']); ?><?php endif; ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <p class="mt-2 text-[0.75rem] text-[#3b5158]">Values are contract sums as published (Aston Ridge: final cost). Awards and Cabinet approvals are listed as such. Full sources: <?php echo e(route('projects.index')); ?></p>
        </section>

        <section class="mt-7 grid gap-6 text-[0.875rem] sm:grid-cols-2">
            <div>
                <h2 class="border-b border-[#10232a] pb-1 text-xs font-bold uppercase tracking-[0.16em]">Working with us</h2>
                <ul class="mt-3 space-y-1.5">
                    <li>Tender invitations and RFQs: <?php echo e(route('tenders.create')); ?></li>
                    <li>Subcontractor and supplier prequalification: <?php echo e(route('prequal.create')); ?></li>
                    <li>Private document links for client project teams</li>
                </ul>
            </div>
            <div>
                <h2 class="border-b border-[#10232a] pb-1 text-xs font-bold uppercase tracking-[0.16em]">Contact</h2>
                <p class="mt-3"><?php echo e(yps('address.street')); ?>, <?php echo e(yps('address.city')); ?>, <?php echo e(yps('address.country')); ?><br>Tel. <?php echo e(format_phone(yps('phone'))); ?> · Fax <?php echo e(format_phone(yps('fax'))); ?><br><?php echo e(yps('email')); ?></p>
            </div>
        </section>
        <footer class="mt-8 flex items-center justify-between border-t-[3px] border-[#10232a] pt-2 text-[0.6875rem] uppercase tracking-[0.14em] text-[#3b5158]"><span><?php echo e(yps('tagline')); ?></span><span><?php echo e(yps('short_name')); ?></span></footer>
    </main>
</body>
</html>
<?php /**PATH /Users/keronlewis/yp-seaton/resources/views/pages/capability.blade.php ENDPATH**/ ?>