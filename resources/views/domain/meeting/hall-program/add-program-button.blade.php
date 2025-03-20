<!-- resources/views/domain/meeting/hall-program/add-program-button.blade.php -->
<div class="w-full px-4 py-2">
    <x-filament::button
        wire:click="mountAction('add_program')"
        icon="heroicon-o-plus"
        color="primary"
        class="w-full"
    >
        Program Ekle
    </x-filament::button>
</div>
