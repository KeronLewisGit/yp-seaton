<?php if (isset($component)) { $__componentOriginalc8c9fd5d7827a77a31381de67195f0c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.admin','data' => ['title' => $room->name]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($room->name)]); ?>
     <?php $__env->slot('actions', null, []); ?> <a href="<?php echo e(route('admin.rooms.index')); ?>" class="a-btn a-btn-ghost"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
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
<?php endif; ?>Rooms</a> <?php $__env->endSlot(); ?>

    <?php if($link): ?>
        <div class="a-card mb-6 border-l-4 p-5" style="border-left-color: var(--good)" role="status">
            <p class="font-semibold">Share this link with <?php echo e($room->client_contact ?? $room->client_name); ?></p>
            <p class="mt-1 text-sm text-ink-2">It works until <?php echo e($room->link_expires_at?->format('l j F Y')); ?>. Copy it now: for security it is not shown again.</p>
            <label for="share-url" class="sr-only">Share link</label>
            <input id="share-url" readonly value="<?php echo e($link); ?>" class="a-input mt-3 w-full font-mono text-sm" onfocus="this.select()">
        </div>
    <?php endif; ?>

    <div class="grid gap-6 xl:grid-cols-[minmax(0,1.5fr)_minmax(0,1fr)]">
        <div class="min-w-0 space-y-6">
            <section class="a-card min-w-0" aria-labelledby="docs-title">
                <h2 id="docs-title" class="px-5 pt-4 font-semibold">Documents (<?php echo e($room->documents->count()); ?>)</h2>
                <div class="table-box mt-3">
                    <table class="data-table">
                        <thead><tr><th>Document</th><th>Category</th><th class="r">Size</th><th class="r">Client downloads</th><th><span class="sr-only">Actions</span></th></tr></thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $room->documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="min-w-[14rem]"><a class="font-semibold text-link underline-offset-2 hover:underline" href="<?php echo e(route('admin.rooms.download', [$room, $d])); ?>"><?php echo e($d->title); ?></a><p class="text-xs text-ink-3"><?php echo e($d->extension()); ?> · <?php echo e($d->created_at->format('j M Y')); ?> · <?php echo e($d->uploader->name ?? 'staff'); ?></p></td>
                                    <td><?php echo e($d->category->label()); ?></td>
                                    <td class="r"><?php echo e(file_size($d->size)); ?></td>
                                    <td class="r"><?php echo e($d->downloads); ?></td>
                                    <td class="r"><form method="POST" action="<?php echo e(route('admin.rooms.documents.destroy', [$room, $d])); ?>" onsubmit="return confirm('Remove this document from the room?')"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button class="a-btn a-btn-ghost w-11 px-0" aria-label="Remove <?php echo e($d->title); ?>"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'trash','class' => 'h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'trash','class' => 'h-4 w-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?></button></form></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr><td colspan="5" class="py-8 text-center text-ink-3">No documents yet.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <form method="POST" action="<?php echo e(route('admin.rooms.upload', $room)); ?>" enctype="multipart/form-data" class="grid gap-3 border-t border-line p-5 md:grid-cols-[minmax(0,1fr)_12rem]">
                    <?php echo csrf_field(); ?>
                    <div><label for="d-title" class="mb-1 block text-sm text-ink-2">Title</label><input id="d-title" name="title" class="a-input w-full" required maxlength="160" placeholder="e.g. Drawing C-101 rev B"></div>
                    <div><label for="d-cat" class="mb-1 block text-sm text-ink-2">Category</label><select id="d-cat" name="category" class="a-input w-full"><?php $__currentLoopData = \App\Enums\RoomCategory::cases(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($c->value); ?>"><?php echo e($c->label()); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div>
                    <div class="md:col-span-2"><label for="d-file" class="mb-1 block text-sm text-ink-2">File <span class="text-ink-3">(PDF, DWG, Office, images or ZIP, up to 20 MB)</span></label><input id="d-file" type="file" name="file" required class="input" accept=".<?php echo e(implode(',.', \App\Models\DocumentRoom::FILE_TYPES)); ?>"></div>
                    <div><button class="a-btn a-btn-primary"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'upload','class' => 'h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'upload','class' => 'h-4 w-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>Upload</button></div>
                </form>
            </section>
        </div>
        <div class="min-w-0 space-y-6">
            <section class="a-card p-5">
                <h2 class="font-semibold">Client link</h2>
                <?php if($room->linkIsLive()): ?>
                    <p class="mt-2"><?php if (isset($component)) { $__componentOriginal3e43da63772e725970863e9067088b49 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3e43da63772e725970863e9067088b49 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.chip','data' => ['tone' => 'good','icon' => 'link']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('chip'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tone' => 'good','icon' => 'link']); ?>Live until <?php echo e($room->link_expires_at?->format('j M Y')); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3e43da63772e725970863e9067088b49)): ?>
<?php $attributes = $__attributesOriginal3e43da63772e725970863e9067088b49; ?>
<?php unset($__attributesOriginal3e43da63772e725970863e9067088b49); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3e43da63772e725970863e9067088b49)): ?>
<?php $component = $__componentOriginal3e43da63772e725970863e9067088b49; ?>
<?php unset($__componentOriginal3e43da63772e725970863e9067088b49); ?>
<?php endif; ?></p>
                    <p class="mt-2 text-sm text-ink-2">Last opened <?php echo e($room->last_opened_at?->diffForHumans() ?? 'never'); ?>.</p>
                <?php else: ?>
                    <p class="mt-2"><?php if (isset($component)) { $__componentOriginal3e43da63772e725970863e9067088b49 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3e43da63772e725970863e9067088b49 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.chip','data' => ['tone' => 'muted','icon' => 'lock']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('chip'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tone' => 'muted','icon' => 'lock']); ?>No live link <?php echo $__env->renderComponent(); ?>
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
                <form method="POST" action="<?php echo e(route('admin.rooms.share', $room)); ?>" class="mt-4 space-y-3">
                    <?php echo csrf_field(); ?>
                    <fieldset><legend class="mb-1 text-sm text-ink-2">New link valid for</legend>
                        <div class="flex flex-wrap gap-2"><?php $__currentLoopData = \App\Models\DocumentRoom::LINK_DAYS; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $days): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><label class="choice min-h-11 py-2"><input type="radio" name="days" value="<?php echo e($days); ?>" <?php if($days === 30): echo 'checked'; endif; ?>><?php echo e($days); ?> days</label><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></div>
                    </fieldset>
                    <?php if($room->client_email): ?><label class="flex min-h-11 items-center gap-2"><input type="checkbox" name="email" value="1" checked class="h-5 w-5 accent-[var(--primary)]">Email it to <?php echo e($room->client_email); ?></label><?php endif; ?>
                    <button class="a-btn a-btn-primary"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'link','class' => 'h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'link','class' => 'h-4 w-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>Create link</button>
                </form>
                <?php if($room->linkIsLive()): ?>
                    <form method="POST" action="<?php echo e(route('admin.rooms.revoke', $room)); ?>" class="mt-4 border-t border-line pt-4" onsubmit="return confirm('Stop every link sent so far from working?')"><?php echo csrf_field(); ?><button class="a-btn a-btn-danger">Withdraw all links</button></form>
                <?php endif; ?>
            </section>
            <form method="POST" action="<?php echo e(route('admin.rooms.update', $room)); ?>" class="a-card space-y-3 p-5">
                <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                <h2 class="font-semibold">Room details</h2>
                <div><label for="e-name" class="mb-1 block text-sm text-ink-2">Project</label><input id="e-name" name="name" value="<?php echo e(old('name', $room->name)); ?>" class="a-input w-full" required maxlength="160"></div>
                <div><label for="e-client" class="mb-1 block text-sm text-ink-2">Client organisation</label><input id="e-client" name="client_name" value="<?php echo e(old('client_name', $room->client_name)); ?>" class="a-input w-full" required maxlength="160"></div>
                <div><label for="e-contact" class="mb-1 block text-sm text-ink-2">Client contact</label><input id="e-contact" name="client_contact" value="<?php echo e(old('client_contact', $room->client_contact)); ?>" class="a-input w-full" maxlength="120"></div>
                <div><label for="e-email" class="mb-1 block text-sm text-ink-2">Contact email</label><input id="e-email" type="email" name="client_email" value="<?php echo e(old('client_email', $room->client_email)); ?>" class="a-input w-full"></div>
                <div><label for="e-desc" class="mb-1 block text-sm text-ink-2">Note to the client</label><textarea id="e-desc" name="description" class="a-input"><?php echo e(old('description', $room->description)); ?></textarea></div>
                <button class="a-btn a-btn-ghost">Save details</button>
            </form>
            <?php echo $__env->make('admin.partials.timeline', ['notes' => $room->notes, 'action' => null], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
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
<?php /**PATH /Users/keronlewis/yp-seaton/resources/views/admin/rooms/show.blade.php ENDPATH**/ ?>