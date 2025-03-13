<div
    class="flex flex-col gap-2 items-center justify-center"
    x-ignore
    x-load-src="<?php echo e(\Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('qr','lara-zeus/qr')); ?>"
    x-load
    x-data="qrPlugin({
        state: '<?php echo e($statePath); ?>',
    })"
>
    <div class="flex flex-col justify-center items-center" x-ref="qr">
        <!--[if BLOCK]><![endif]--><?php if(optional($options)['type'] === 'png'): ?>
            <img src="data:png;base64,<?php echo e(base64_encode(\LaraZeus\Qr\Facades\Qr::output($data,$options))); ?>"/>
        <?php else: ?>
            <?php echo e(\LaraZeus\Qr\Facades\Qr::output($data,$options)); ?>

        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>

    <!--[if BLOCK]><![endif]--><?php if($downloadable): ?>
        <div class="flex items-center gap-4">
            <?php if (isset($component)) { $__componentOriginal6330f08526bbb3ce2a0da37da512a11f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6330f08526bbb3ce2a0da37da512a11f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.button.index','data' => ['tooltip' => __('Download as a PNG'),'color' => 'info','size' => 'sm','icon' => 'heroicon-o-arrow-down-tray','@click' => 'download(\''.e($statePath).'\',\'png\');']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tooltip' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Download as a PNG')),'color' => 'info','size' => 'sm','icon' => 'heroicon-o-arrow-down-tray','@click' => 'download(\''.e($statePath).'\',\'png\');']); ?>
                <?php echo e(__('png')); ?>

             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6330f08526bbb3ce2a0da37da512a11f)): ?>
<?php $attributes = $__attributesOriginal6330f08526bbb3ce2a0da37da512a11f; ?>
<?php unset($__attributesOriginal6330f08526bbb3ce2a0da37da512a11f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6330f08526bbb3ce2a0da37da512a11f)): ?>
<?php $component = $__componentOriginal6330f08526bbb3ce2a0da37da512a11f; ?>
<?php unset($__componentOriginal6330f08526bbb3ce2a0da37da512a11f); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal6330f08526bbb3ce2a0da37da512a11f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6330f08526bbb3ce2a0da37da512a11f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.button.index','data' => ['tooltip' => __('Download as an SVG'),'color' => 'info','size' => 'sm','icon' => 'heroicon-o-arrow-down-tray','@click' => 'download(\''.e($statePath).'\',\'svg\');']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tooltip' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Download as an SVG')),'color' => 'info','size' => 'sm','icon' => 'heroicon-o-arrow-down-tray','@click' => 'download(\''.e($statePath).'\',\'svg\');']); ?>
                <?php echo e(__('svg')); ?>

             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6330f08526bbb3ce2a0da37da512a11f)): ?>
<?php $attributes = $__attributesOriginal6330f08526bbb3ce2a0da37da512a11f; ?>
<?php unset($__attributesOriginal6330f08526bbb3ce2a0da37da512a11f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6330f08526bbb3ce2a0da37da512a11f)): ?>
<?php $component = $__componentOriginal6330f08526bbb3ce2a0da37da512a11f; ?>
<?php unset($__componentOriginal6330f08526bbb3ce2a0da37da512a11f); ?>
<?php endif; ?>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH C:\Users\Administrator\Documents\web\pinet\PiCore\vendor\lara-zeus\qr\src\/../resources/views/download.blade.php ENDPATH**/ ?>