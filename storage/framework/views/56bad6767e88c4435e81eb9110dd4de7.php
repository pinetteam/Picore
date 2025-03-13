<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'collapsible' => true,
    'icon' => null,
    'items' => [],
    'label' => null,
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'collapsible' => true,
    'icon' => null,
    'items' => [],
    'label' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<li
    x-data="{ label: <?php echo \Illuminate\Support\Js::from($label)->toHtml() ?> }"
    data-group-label="<?php echo e($label); ?>"
    class="fi-sidebar-group flex flex-col gap-y-1">

    <!--[if BLOCK]><![endif]--><?php if($label): ?>
        <div
            <?php if($collapsible): ?>
                x-on:click="$store.sidebar.toggleCollapsedGroup(label)"
            <?php endif; ?>

            <?php if(filament()->isSidebarCollapsibleOnDesktop()): ?>
                x-transition:enter="delay-100 lg:transition"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
            <?php endif; ?>

            class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                'flex items-center gap-x-3 px-2 py-2',
                'cursor-pointer' => $collapsible,
            ]); ?>">

            <!--[if BLOCK]><![endif]--><?php if($icon): ?>
                <?php if (isset($component)) { $__componentOriginalbfc641e0710ce04e5fe02876ffc6f950 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.icon','data' => ['icon' => $icon,'class' => 'fi-sidebar-group-icon h-6 w-6 text-gray-400 dark:text-gray-500']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($icon),'class' => 'fi-sidebar-group-icon h-6 w-6 text-gray-400 dark:text-gray-500']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950)): ?>
<?php $attributes = $__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950; ?>
<?php unset($__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbfc641e0710ce04e5fe02876ffc6f950)): ?>
<?php $component = $__componentOriginalbfc641e0710ce04e5fe02876ffc6f950; ?>
<?php unset($__componentOriginalbfc641e0710ce04e5fe02876ffc6f950); ?>
<?php endif; ?>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

            <span class="fi-sidebar-group-label flex-1 text-sm font-semibold text-gray-700 dark:text-gray-200">
                <?php echo e($label); ?>

            </span>

            <?php if (isset($component)) { $__componentOriginalf0029cce6d19fd6d472097ff06a800a1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf0029cce6d19fd6d472097ff06a800a1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.icon-button','data' => ['color' => 'gray','icon' => 'heroicon-m-chevron-up','iconAlias' => 'panels::sidebar.group.collapse-button','xOn:click.stop' => '$store.sidebar.toggleCollapsedGroup(label)','xBind:class' => '{ \'rotate-180\': $store.sidebar.groupIsCollapsed(label) }','class' => 'fi-sidebar-group-collapse-button -my-2 -me-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::icon-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['color' => 'gray','icon' => 'heroicon-m-chevron-up','icon-alias' => 'panels::sidebar.group.collapse-button','x-on:click.stop' => '$store.sidebar.toggleCollapsedGroup(label)','x-bind:class' => '{ \'rotate-180\': $store.sidebar.groupIsCollapsed(label) }','class' => 'fi-sidebar-group-collapse-button -my-2 -me-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf0029cce6d19fd6d472097ff06a800a1)): ?>
<?php $attributes = $__attributesOriginalf0029cce6d19fd6d472097ff06a800a1; ?>
<?php unset($__attributesOriginalf0029cce6d19fd6d472097ff06a800a1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf0029cce6d19fd6d472097ff06a800a1)): ?>
<?php $component = $__componentOriginalf0029cce6d19fd6d472097ff06a800a1; ?>
<?php unset($__componentOriginalf0029cce6d19fd6d472097ff06a800a1); ?>
<?php endif; ?>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <ul x-show="! ($store.sidebar.groupIsCollapsed(label) && ($store.sidebar.isOpen || <?php echo \Illuminate\Support\Js::from(filament()->isSidebarCollapsibleOnDesktop())->toHtml() ?>))"
        <?php if(filament()->isSidebarCollapsibleOnDesktop()): ?>
            x-transition:enter="delay-100 lg:transition"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
        <?php endif; ?>

        x-collapse.duration.200ms class="fi-sidebar-group-items flex flex-col gap-y-1">

        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if (isset($component)) { $__componentOriginal55c618cc9d73e90a57a4596696d27ef3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal55c618cc9d73e90a57a4596696d27ef3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-page-with-sidebar::components.item','data' => ['activeIcon' => $item->getActiveIcon(),'active' => $item->isActive(),'badgeColor' => $item->getBadgeColor(),'badge' => $item->getBadge(),'first' => $loop->first,'grouped' => filled($label),'icon' => $item->getIcon(),'last' => $loop->last,'url' => $item->getUrl(),'shouldOpenUrlInNewTab' => $item->shouldOpenUrlInNewTab()]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-page-with-sidebar::item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['active-icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item->getActiveIcon()),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item->isActive()),'badge-color' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item->getBadgeColor()),'badge' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item->getBadge()),'first' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($loop->first),'grouped' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(filled($label)),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item->getIcon()),'last' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($loop->last),'url' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item->getUrl()),'should-open-url-in-new-tab' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item->shouldOpenUrlInNewTab())]); ?>
                <?php echo e($item->getLabel()); ?>

             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal55c618cc9d73e90a57a4596696d27ef3)): ?>
<?php $attributes = $__attributesOriginal55c618cc9d73e90a57a4596696d27ef3; ?>
<?php unset($__attributesOriginal55c618cc9d73e90a57a4596696d27ef3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal55c618cc9d73e90a57a4596696d27ef3)): ?>
<?php $component = $__componentOriginal55c618cc9d73e90a57a4596696d27ef3; ?>
<?php unset($__componentOriginal55c618cc9d73e90a57a4596696d27ef3); ?>
<?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
    </ul>
</li>
<?php /**PATH C:\Users\Administrator\Documents\web\pinet\PiCore\resources\views/vendor/filament-page-with-sidebar/components/group.blade.php ENDPATH**/ ?>