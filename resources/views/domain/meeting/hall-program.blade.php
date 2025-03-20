<x-filament::page>
    <div class="relative mb-4">
        {!! $this->renderBackButton() !!}
    </div>

    <!-- Your custom table HTML -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
        {!! $this->renderCustomProgramTable() !!}
    </div>

    <!-- Hidden Filament table for action handling -->
    <div class="hidden">
        {{ $this->table }}
    </div>

    <style>
        .expand-button.expanded {
            transform: rotate(90deg);
            transition: transform 0.2s;
        }

        .expand-button.collapsed {
            transform: rotate(0deg);
            transition: transform 0.2s;
        }
    </style>

    <script>
        document.addEventListener('livewire:initialized', () => {
            // Listen for Filament action events and refresh custom table
            Livewire.hook('commit', ({ component, commit, respond, succeed }) => {
                succeed(({ effects }) => {
                    if (component.id === '{{ $this->getId() }}') {
                        // Refresh the component if needed after an action completes
                    }
                });
            });

            Livewire.on('rowToggled', () => {
                // Alt tablolar güncellendiğinde yapılacak işlemler
            });
        });
    </script>
</x-filament::page>
