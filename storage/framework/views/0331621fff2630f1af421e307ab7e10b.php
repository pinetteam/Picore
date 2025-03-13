<?php if (isset($component)) { $__componentOriginal264637b95f4dc75c69c90ee3b9ac6a00 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal264637b95f4dc75c69c90ee3b9ac6a00 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-page-with-sidebar::components.page','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-page-with-sidebar::page'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <?php echo $__env->make($this->getIncludedSidebarView(), array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal264637b95f4dc75c69c90ee3b9ac6a00)): ?>
<?php $attributes = $__attributesOriginal264637b95f4dc75c69c90ee3b9ac6a00; ?>
<?php unset($__attributesOriginal264637b95f4dc75c69c90ee3b9ac6a00); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal264637b95f4dc75c69c90ee3b9ac6a00)): ?>
<?php $component = $__componentOriginal264637b95f4dc75c69c90ee3b9ac6a00; ?>
<?php unset($__componentOriginal264637b95f4dc75c69c90ee3b9ac6a00); ?>
<?php endif; ?><?php /**PATH C:\Users\Administrator\Documents\web\pinet\PiCore\resources\views/vendor/filament-page-with-sidebar/proxy.blade.php ENDPATH**/ ?>