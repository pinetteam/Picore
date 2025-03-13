<input
    <?php echo e($attributes
            ->merge([
                'id' => $getId(),
                'type' => 'hidden',
                $applyStateBindingModifiers('wire:model') => $getStatePath(),
            ], escape: false)
            ->merge($getExtraAttributes(), escape: false)
            ->class(['fi-fo-hidden'])); ?>

/>
<?php /**PATH C:\Users\Administrator\Documents\web\pinet\PiCore\vendor\filament\forms\src\/../resources/views/components/hidden.blade.php ENDPATH**/ ?>