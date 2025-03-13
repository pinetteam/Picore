<x-filament-panels::page class="w-full" style="max-width: 100%; margin-left: 0; margin-right: 0;">
    @if($this->getSelectedMeeting())
        <x-filament::section>
            <x-slot name="heading">
                {{ $this->getSelectedMeeting()->title }}
            </x-slot>

            <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow mb-4">
                <div class="flex flex-wrap gap-6">
                    <div class="flex items-center">
                        <x-heroicon-o-calendar class="w-5 h-5 text-primary-500 mr-2" />
                        <div>
                            <span class="text-gray-500 dark:text-gray-400 text-sm">Başlangıç:</span>
                            <span class="ml-2 font-medium">{{ $this->getFormattedStartDate() }}</span>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <x-heroicon-o-clock class="w-5 h-5 text-primary-500 mr-2" />
                        <div>
                            <span class="text-gray-500 dark:text-gray-400 text-sm">Bitiş:</span>
                            <span class="ml-2 font-medium">{{ $this->getFormattedFinishDate() }}</span>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <x-heroicon-o-check-circle class="w-5 h-5 text-primary-500 mr-2" />
                        <div>
                            <span class="text-gray-500 dark:text-gray-400 text-sm">Durum:</span>
                            <span class="ml-2">
                                 @if($this->getSelectedMeeting()->status)
                                    <span class="text-success-600 font-medium">Aktif</span>
                                @else
                                    <span class="text-danger-600 font-medium">Pasif</span>
                                @endif
                </span>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <x-heroicon-o-document-text class="w-5 h-5 text-primary-500 mr-2" />
                        <div>
                            <span class="text-gray-500 dark:text-gray-400 text-sm">ID:</span>
                            <span class="ml-2 font-medium">{{ $this->getSelectedMeeting()->id }}</span>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <x-heroicon-o-question-mark-circle class="w-5 h-5 text-primary-500 mr-2" />
                        <div>
                            <span class="text-gray-500 dark:text-gray-400 text-sm">Type:</span>
                            <span class="ml-2 font-medium">{{ $this->getSelectedMeeting()->type }}</span>
                        </div>
                    </div>


                </div>
            </div>
        </x-filament::section>

        <x-filament::section class="mt-4">
            <x-slot name="heading">
                <div class="flex items-center">
                    <span>{{ ucfirst($this->currentSection) }}</span>
                </div>
            </x-slot>

            @if($this->currentSection === 'announcements' || $this->currentSection === 'participants' || $this->currentSection === 'documents' || $this->currentSection === 'halls' || $this->currentSection === 'surveys')
                {{ $this->table }}
            @else
                {{ $this->renderSectionContent() }}
            @endif
        </x-filament::section>
    @else
        <x-filament::section>
            <div class="flex flex-col items-center justify-center py-8">
                <x-heroicon-o-information-circle class="w-16 h-16 text-gray-400 mb-4" />

                <h3 class="text-xl font-semibold text-gray-700 mb-2">Lütfen bir toplantı seçin</h3>

                <p class="text-gray-500 text-center max-w-md mb-6">
                    Detayları görüntülemek için yukarıdaki listeden bir toplantı seçmelisiniz. Toplantı seçildiğinde tüm bilgiler burada görüntülenecektir.
                </p>

                <x-filament::button>
                    Toplantı Seçin
                </x-filament::button>
            </div>
        </x-filament::section>
    @endif
</x-filament-panels::page>
