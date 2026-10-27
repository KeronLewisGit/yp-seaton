<?php if (isset($component)) { $__componentOriginalc8c9fd5d7827a77a31381de67195f0c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.admin','data' => ['title' => $vendor->company_name]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($vendor->company_name)]); ?>
     <?php $__env->slot('actions', null, []); ?> 
        <a href="<?php echo e(route('admin.vendors.index')); ?>" class="a-btn a-btn-ghost"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
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
<?php endif; ?>Register</a>
        <a href="mailto:<?php echo e($vendor->email); ?>?subject=<?php echo e(rawurlencode('Prequalification '.$vendor->reference)); ?>" class="a-btn a-btn-ghost"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'mail','class' => 'h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'mail','class' => 'h-4 w-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>Email</a>
        <a href="<?php echo e(tel_href($vendor->phone)); ?>" class="a-btn a-btn-primary"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'phone','class' => 'h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'phone','class' => 'h-4 w-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>Call</a>
     <?php $__env->endSlot(); ?>

    <div class="grid gap-6 xl:grid-cols-[minmax(0,1.5fr)_minmax(0,1fr)]">
        <div class="min-w-0 space-y-6">
            <section class="a-card" aria-labelledby="certs-title">
                <div class="flex flex-wrap items-center justify-between gap-2 px-5 pt-4"><h2 id="certs-title" class="font-semibold">Required certificates</h2><?php if (isset($component)) { $__componentOriginaldd82ba5f9eb9946fc51d4eca2e40d91a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldd82ba5f9eb9946fc51d4eca2e40d91a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.compliance','data' => ['state' => $vendor->complianceState()]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('compliance'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['state' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($vendor->complianceState())]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldd82ba5f9eb9946fc51d4eca2e40d91a)): ?>
<?php $attributes = $__attributesOriginaldd82ba5f9eb9946fc51d4eca2e40d91a; ?>
<?php unset($__attributesOriginaldd82ba5f9eb9946fc51d4eca2e40d91a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldd82ba5f9eb9946fc51d4eca2e40d91a)): ?>
<?php $component = $__componentOriginaldd82ba5f9eb9946fc51d4eca2e40d91a; ?>
<?php unset($__componentOriginaldd82ba5f9eb9946fc51d4eca2e40d91a); ?>
<?php endif; ?></div>
                <div class="mt-3 divide-y divide-line border-t border-line">
                    <?php $__currentLoopData = $vendor->compliance(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php ($d = $c['document']); ?>
                        <div class="grid gap-3 p-5 md:grid-cols-[minmax(0,1fr)_auto]">
                            <div class="min-w-0">
                                <p class="font-semibold"><?php echo e($c['kind']->label()); ?></p>
                                <?php if($d): ?>
                                    <p class="text-sm text-ink-2"><?php echo e($d->number ?: 'No number given'); ?> · expires <span class="num font-semibold"><?php echo e($d->expires_on?->format('j M Y') ?? '—'); ?></span>
                                        <?php if($d->daysLeft() !== null): ?><span class="text-ink-3">(<?php echo e($d->daysLeft() >= 0 ? $d->daysLeft().' days left' : abs($d->daysLeft()).' days ago'); ?>)</span><?php endif; ?></p>
                                    <p class="mt-1 text-xs text-ink-3">Uploaded <?php echo e($d->created_at->format('j M Y')); ?><?php if($d->verified_at): ?> · checked by <?php echo e($d->verifier->name ?? 'staff'); ?> <?php echo e($d->verified_at->format('j M Y')); ?><?php else: ?> · <strong>not yet checked</strong><?php endif; ?> <?php if($d->reminded_at): ?> · renewal reminder sent <?php echo e($d->reminded_at->format('j M')); ?><?php endif; ?></p>
                                    <div class="mt-3 flex flex-wrap items-center gap-2">
                                        <?php if (isset($component)) { $__componentOriginal3e43da63772e725970863e9067088b49 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3e43da63772e725970863e9067088b49 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.chip','data' => ['tone' => match ($d->state()) { 'valid' => 'good', 'expiring' => 'attention', default => 'critical' },'icon' => $d->state() === 'valid' ? 'check-circle' : 'clock']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('chip'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tone' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(match ($d->state()) { 'valid' => 'good', 'expiring' => 'attention', default => 'critical' }),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($d->state() === 'valid' ? 'check-circle' : 'clock')]); ?><?php echo e(ucfirst($d->state())); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3e43da63772e725970863e9067088b49)): ?>
<?php $attributes = $__attributesOriginal3e43da63772e725970863e9067088b49; ?>
<?php unset($__attributesOriginal3e43da63772e725970863e9067088b49); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3e43da63772e725970863e9067088b49)): ?>
<?php $component = $__componentOriginal3e43da63772e725970863e9067088b49; ?>
<?php unset($__componentOriginal3e43da63772e725970863e9067088b49); ?>
<?php endif; ?>
                                        <a href="<?php echo e(route('admin.vendors.document', [$vendor, $d])); ?>" class="a-btn a-btn-ghost" target="_blank" rel="noopener"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
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
<?php endif; ?>Open <?php echo e($d->kind->short()); ?></a>
                                    </div>
                                <?php else: ?>
                                    <p class="mt-1"><?php if (isset($component)) { $__componentOriginal3e43da63772e725970863e9067088b49 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3e43da63772e725970863e9067088b49 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.chip','data' => ['tone' => 'critical','icon' => 'alert']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('chip'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tone' => 'critical','icon' => 'alert']); ?>Not provided <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3e43da63772e725970863e9067088b49)): ?>
<?php $attributes = $__attributesOriginal3e43da63772e725970863e9067088b49; ?>
<?php unset($__attributesOriginal3e43da63772e725970863e9067088b49); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3e43da63772e725970863e9067088b49)): ?>
<?php $component = $__componentOriginal3e43da63772e725970863e9067088b49; ?>
<?php unset($__componentOriginal3e43da63772e725970863e9067088b49); ?>
<?php endif; ?></p>
                                <?php endif; ?>
                            </div>
                            <?php if($d): ?>
                                <form method="POST" action="<?php echo e(route('admin.vendors.verify', [$vendor, $d])); ?>" class="flex flex-wrap items-end gap-2 md:w-64 md:flex-col md:items-stretch">
                                    <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                    <div><label class="mb-1 block text-xs text-ink-2" for="exp-<?php echo e($d->id); ?>">Expiry on the certificate</label><input id="exp-<?php echo e($d->id); ?>" type="date" name="expires_on" value="<?php echo e($d->expires_on?->format('Y-m-d')); ?>" class="a-input w-full"></div>
                                    <div><label class="mb-1 block text-xs text-ink-2" for="num-<?php echo e($d->id); ?>"><?php echo e($d->kind->numberLabel()); ?></label><input id="num-<?php echo e($d->id); ?>" name="number" value="<?php echo e($d->number); ?>" class="a-input w-full" maxlength="80"></div>
                                    <button class="a-btn a-btn-ghost"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'check','class' => 'h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'check','class' => 'h-4 w-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>Mark checked</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php $__currentLoopData = $vendor->currentDocuments->filter(fn ($d) => $d->kind === \App\Enums\DocumentKind::Other); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-center gap-3 p-5"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'file','class' => 'h-5 w-5 text-ink-3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'file','class' => 'h-5 w-5 text-ink-3']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?><span class="min-w-0 flex-1 truncate">Other: <?php echo e($d->original_name); ?></span><a href="<?php echo e(route('admin.vendors.document', [$vendor, $d])); ?>" class="a-btn a-btn-ghost" target="_blank" rel="noopener">Open</a></div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php ($old = $vendor->documents->whereNotNull('superseded_at')); ?>
                <?php if($old->isNotEmpty()): ?>
                    <details class="border-t border-line px-5 py-3 text-sm"><summary class="min-h-11 cursor-pointer py-2 font-semibold">Earlier copies (<?php echo e($old->count()); ?>)</summary>
                        <ul class="space-y-1 pb-2"><?php $__currentLoopData = $old; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><a class="text-link underline" href="<?php echo e(route('admin.vendors.document', [$vendor, $d])); ?>"><?php echo e($d->kind->short()); ?>, expired <?php echo e($d->expires_on?->format('j M Y')); ?></a> <span class="text-ink-3">replaced <?php echo e($d->superseded_at?->format('j M Y')); ?></span></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
                    </details>
                <?php endif; ?>
                <p class="border-t border-line px-5 py-3 text-xs text-ink-3"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'lock','class' => 'inline h-3.5 w-3.5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'lock','class' => 'inline h-3.5 w-3.5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?> Stored privately; procurement and administrators only. Each opening is logged.</p>
            </section>

            <section class="a-card p-5 md:p-6">
                <h2 class="font-semibold">Company</h2>
                <dl class="dl-grid mt-3">
                    <dt>Name</dt><dd><?php echo e($vendor->displayName()); ?></dd>
                    <dt>Type</dt><dd><?php echo e($vendor->type->label()); ?></dd>
                    <dt>TRN</dt><dd class="num"><?php echo e(format_trn($vendor->trn)); ?></dd>
                    <?php if($vendor->company_number): ?><dt>Company number</dt><dd><?php echo e($vendor->company_number); ?></dd><?php endif; ?>
                    <?php if($vendor->year_established): ?><dt>Established</dt><dd><?php echo e($vendor->year_established); ?></dd><?php endif; ?>
                    <dt>Address</dt><dd><?php echo e($vendor->address); ?>, <?php echo e($vendor->parish); ?></dd>
                    <dt>Trades</dt><dd><?php echo e(collect($vendor->trades)->map(fn ($t) => yps('trades.'.$t) ?? $t)->implode(', ')); ?></dd>
                    <?php if($vendor->parishes_served): ?><dt>Works in</dt><dd><?php echo e(implode(', ', $vendor->parishes_served)); ?></dd><?php endif; ?>
                    <?php if($vendor->employees): ?><dt>Employees</dt><dd><?php echo e(\App\Models\Vendor::EMPLOYEE_BANDS[$vendor->employees] ?? $vendor->employees); ?></dd><?php endif; ?>
                    <?php if($vendor->registration_grade): ?><dt>NCC/PPC category and grade</dt><dd><?php echo e($vendor->registration_grade); ?></dd><?php endif; ?>
                </dl>
                <?php if($vendor->experience): ?><h3 class="mt-5 font-semibold">Comparable work</h3><p class="measure mt-1 whitespace-pre-line text-ink-2"><?php echo e($vendor->experience); ?></p><?php endif; ?>
                <?php if($vendor->message): ?><h3 class="mt-5 font-semibold">Message</h3><p class="measure mt-1 whitespace-pre-line text-ink-2"><?php echo e($vendor->message); ?></p><?php endif; ?>
            </section>
        </div>

        <div class="min-w-0 space-y-6">
            <section class="a-card p-5">
                <h2 class="font-semibold">Decision</h2>
                <p class="mt-1 text-sm text-ink-2"><?php if (isset($component)) { $__componentOriginal51ed764111e345fc11534f121cfeb451 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal51ed764111e345fc11534f121cfeb451 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.status','data' => ['status' => $vendor->status]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('status'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($vendor->status)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal51ed764111e345fc11534f121cfeb451)): ?>
<?php $attributes = $__attributesOriginal51ed764111e345fc11534f121cfeb451; ?>
<?php unset($__attributesOriginal51ed764111e345fc11534f121cfeb451); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal51ed764111e345fc11534f121cfeb451)): ?>
<?php $component = $__componentOriginal51ed764111e345fc11534f121cfeb451; ?>
<?php unset($__componentOriginal51ed764111e345fc11534f121cfeb451); ?>
<?php endif; ?><?php if($vendor->approved_at): ?> since <?php echo e($vendor->approved_at->format('j M Y')); ?><?php endif; ?></p>
                <form method="POST" action="<?php echo e(route('admin.vendors.update', $vendor)); ?>" class="mt-3 flex flex-wrap gap-2">
                    <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                    <label for="v-status" class="sr-only">Status</label>
                    <select id="v-status" name="status" class="a-input min-w-0 flex-1"><?php $__currentLoopData = \App\Enums\VendorStatus::cases(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($s->value); ?>" <?php if($vendor->status === $s): echo 'selected'; endif; ?>><?php echo e($s->label()); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select>
                    <button class="a-btn a-btn-primary">Save</button>
                </form>
                <p class="mt-3 text-xs text-ink-3">A vendor can only be prequalified while every required certificate is on file and in date.</p>
            </section>
            <section class="a-card p-5">
                <h2 class="font-semibold">Contact</h2>
                <dl class="dl-grid mt-3">
                    <dt>Name</dt><dd><?php echo e($vendor->contact_name); ?><?php if($vendor->contact_role): ?><span class="text-ink-3">, <?php echo e($vendor->contact_role); ?></span><?php endif; ?></dd>
                    <dt>Phone</dt><dd><a class="text-link underline" href="<?php echo e(tel_href($vendor->phone)); ?>"><?php echo e(format_phone($vendor->phone)); ?></a></dd>
                    <dt>Email</dt><dd><a class="text-link underline" href="mailto:<?php echo e($vendor->email); ?>"><?php echo e($vendor->email); ?></a></dd>
                    <dt>Applied</dt><dd><?php echo e($vendor->created_at->format('j M Y')); ?> (<?php echo e($vendor->reference); ?>)</dd>
                </dl>
            </section>
            <?php echo $__env->make('admin.partials.timeline', ['notes' => $vendor->notes, 'action' => route('admin.vendors.note', $vendor)], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    </div>
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
<?php /**PATH /Users/keronlewis/yp-seaton/resources/views/admin/vendors/show.blade.php ENDPATH**/ ?>