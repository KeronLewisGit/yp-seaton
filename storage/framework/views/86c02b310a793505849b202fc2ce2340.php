<?php if (isset($component)) { $__componentOriginalfefb4fd9b7004fa65f70c415ac76903e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfefb4fd9b7004fa65f70c415ac76903e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.site','data' => ['title' => 'Privacy notice','description' => 'How Y.P. Seaton & Associates handles the details sent through this website.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.site'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Privacy notice','description' => 'How Y.P. Seaton & Associates handles the details sent through this website.']); ?>
    <?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['title' => 'Privacy notice','kicker' => 'Privacy','sheet' => 'L-01','lead' => 'What we keep when you send a tender, a prequalification, a job application or a message, and why.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Privacy notice','kicker' => 'Privacy','sheet' => 'L-01','lead' => 'What we keep when you send a tender, a prequalification, a job application or a message, and why.']); ?>
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
    <section class="wrap prose-copy measure mt-12 md:mt-16">
        <p>This website is run by <?php echo e(yps('name')); ?>, <?php echo e(yps('address.street')); ?>, <?php echo e(yps('address.city')); ?>, <?php echo e(yps('address.country')); ?>. It is written with the Data Protection Act, 2020 (Jamaica) in mind. Questions: <a href="mailto:<?php echo e(yps('email')); ?>"><?php echo e(yps('email')); ?></a> or <?php echo e(format_phone(yps('phone'))); ?>.</p>
        <h2>What we collect</h2>
        <ul>
            <li><strong>Tender invitations:</strong> the procuring entity, contact person, tender details and the documents you upload.</li>
            <li><strong>Prequalification:</strong> company details, TRN, contact person, trades and the certificates you upload with their numbers and expiry dates.</li>
            <li><strong>Job applications:</strong> your name, phone, email, parish, experience, qualifications and CV if you attach one.</li>
            <li><strong>Messages:</strong> your name, contact details and message.</li>
        </ul>
        <h2>Why, and who sees it</h2>
        <p>We use these details only to respond: to decide whether to bid, to assess and manage subcontractors and suppliers, to consider applicants for work, and to reply to messages. Each kind of submission is seen only by the staff who handle it (estimating, procurement or human resources) and the site administrator. We do not sell or share them for marketing.</p>
        <h2>Where it is kept</h2>
        <p>Uploads are stored on a private part of our web server that is not reachable from the internet; staff open them after signing in. Emails confirming your reference number are sent from our website.</p>
        <h2>How long</h2>
        <ul>
            <li>Tender records: for the life of the tender and any resulting contract, plus the period our records rules require.</li>
            <li>Prequalification records: while you remain on our approved list. We email a renewal link before a certificate expires.</li>
            <li>Job applications: up to 12 months, unless you ask us to delete yours sooner.</li>
        </ul>
        <h2>Your rights</h2>
        <p>You can ask to see, correct or delete the details we hold about you by emailing <a href="mailto:<?php echo e(yps('email')); ?>"><?php echo e(yps('email')); ?></a>. Quote your reference number if you have one.</p>
        <h2>Cookies</h2>
        <p>The site uses one session cookie to keep forms secure and a setting that remembers light or dark mode. There is no advertising or tracking.</p>
        <p class="hint">Last updated <?php echo e(now()->format('F Y')); ?>. To be reviewed by the firm before launch.</p>
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
<?php /**PATH /Users/keronlewis/yp-seaton/resources/views/pages/privacy.blade.php ENDPATH**/ ?>