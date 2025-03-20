
    @if($this->getSelectedMeeting())
        <x-filament::section>
            <div class="p-4  dark:bg-gray-800 rounded-lg shadow mb-4">
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



<div class="p-4 relative">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">Hall Details</h2>

        <a href="{{ url("meeting-management/{$meeting->id}/halls") }}"
           class="inline-flex items-center px-4 py-2 bg-gray-200 rounded-lg text-gray-700 hover:bg-gray-300 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Back to Halls
        </a>
    </div>
    <div class="  rounded-lg shadow p-6">

        @if($hall)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-500">Code</p>
                    <p class="font-medium">{{ $hall->code }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Title</p>
                    <p class="font-medium">{{ $hall->title }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Show on Session</p>
                    <p class="font-medium">{{ $hall->show_on_session ? 'Yes' : 'No' }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Show on View Program</p>
                    <p class="font-medium">{{ $hall->show_on_view_program ? 'Yes' : 'No' }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Show on Ask Question</p>
                    <p class="font-medium">{{ $hall->show_on_ask_question ? 'Yes' : 'No' }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Show on Send Mail</p>
                    <p class="font-medium">{{ $hall->show_on_send_mail ? 'Yes' : 'No' }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Status</p>
                    <p class="font-medium">{{ $hall->status ? 'Active' : 'Inactive' }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Created At</p>
                    <p class="font-medium">{{ $hall->created_at->format('Y-m-d H:i') }}</p>
                </div>
            </div>


        @endif

            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="{{ url('meeting-management/'.$meeting->id.'/halls/'.$hall->id.'/program/view') }}" class="block p-6  rounded-lg shadow hover:shadow-md transition">
                    <div class="flex items-center mb-3">
                        <x-heroicon-o-calendar-days class="w-6 h-6 text-primary-500 mr-2" />
                        <h3 class="text-lg font-semibold">  Program</h3>
                    </div>
                    <p class="text-sm text-gray-500">Salon programını görüntüleyin ve düzenleyin. Tüm oturumları ve etkinlikleri yönetin.</p>
                </a>

                <a href="{{ url('meeting-management/'.$meeting->id.'/halls/'.$hall->id.'/screen/view') }}" class="block p-6  rounded-lg shadow hover:shadow-md transition">
                    <div class="flex items-center mb-3">
                        <x-heroicon-o-computer-desktop class="w-6 h-6 text-primary-500 mr-2" />
                        <h3 class="text-lg font-semibold">  Ekran</h3>
                    </div>
                    <p class="text-sm text-gray-500">Salon ekranı ayarlarını yapılandırın. Görüntüleme tercihlerini ve gösterilecek içeriği belirleyin.</p>
                </a>

                <a href="{{ url('meeting-management/'.$meeting->id.'/halls/'.$hall->id.'/session/view') }}" class="block p-6  rounded-lg shadow hover:shadow-md transition">
                    <div class="flex items-center mb-3">
                        <x-heroicon-o-clipboard-document-list class="w-6 h-6 text-primary-500 mr-2" />
                        <h3 class="text-lg font-semibold">  Oturumlar</h3>
                    </div>
                    <p class="text-sm text-gray-500">Oturum raporlarını görüntüleyin. Katılım istatistikleri ve oturum detaylarına erişin.</p>
                </a>
            </div>
    </div>
</div>
