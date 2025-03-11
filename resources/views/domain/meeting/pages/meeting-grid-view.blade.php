<x-filament-panels::page>
    <div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow-md">
        <div class="mb-6">
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
                <input type="search" id="search-meetings" class="block w-full p-4 pl-12 text-sm text-gray-900 dark:text-white border border-gray-300 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-700 focus:ring-primary-500 focus:border-primary-500" placeholder="Toplantı ara..." required>            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mt-2">
            @foreach ($this->getMeetings() as $meeting)
                <div class="meeting-card bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl shadow-sm transition-all duration-300 hover:shadow-lg hover:scale-105 overflow-hidden">
                    <a href="{{ route('filament.admin.resources.meetings.view', $meeting) }}" class="block relative">
                        <div class="w-full h-48 bg-gray-200 dark:bg-gray-600 flex items-center justify-center overflow-hidden">
                            @if($meeting->banner_name)
                                <img class="w-full h-full object-cover"
                                     src="{{ $meeting->banner_url }}"
                                     alt="{{ $meeting->title }} banner">
                            @else
                                <div class="flex flex-col items-center justify-center text-gray-500 dark:text-gray-400">
                                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="mt-2 text-sm">Önizleme Yok</span>
                                </div>
                            @endif
                        </div>
                        <div class="absolute top-3 right-3">
                            <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-medium
                                @if($meeting->status) bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 @endif">
                                {{ $meeting->status ? 'Aktif' : 'Pasif' }}
                            </span>
                        </div>
                    </a>
                    <div class="p-5">
                        <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 dark:text-white truncate">
                            {{ $meeting->title }}
                        </h5>
                        <p class="mb-1 text-sm text-gray-700 dark:text-gray-300">
                            <span class="font-medium">Kod:</span> {{ $meeting->code }}
                        </p>
                        <p class="mb-2 text-sm text-gray-700 dark:text-gray-300">
                            <span class="font-medium">Müşteri:</span> {{ $meeting->customer->title }}
                        </p>
                        <div class="flex flex-wrap justify-between items-center text-xs text-gray-500 dark:text-gray-400 mb-4">
                            <div class="flex items-center">
                                <svg class="inline-block w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                {{ $meeting->start_at->format('d.m.Y') }} - {{ $meeting->finish_at->format('d.m.Y') }}
                            </div>
                            <div class="mt-1 md:mt-0">
                                <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                    {{ $meeting->type_label ?? 'Belirsiz Tür' }}
                                </span>
                            </div>
                        </div>

                        <div class="flex justify-between mt-4">
                            <div class="flex space-x-1">
                                <a href="{{ route('filament.admin.resources.meetings.view', $meeting) }}"
                                   class="p-2 text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300 transition-colors duration-200 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800"
                                   title="Görüntüle">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>

                                <a href="{{ route('filament.admin.resources.meetings.edit', $meeting) }}"
                                   class="p-2 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition-colors duration-200 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800"
                                   title="Düzenle">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>

                                <button type="button"
                                        onclick="if(confirm('Bu toplantıyı silmek istediğinizden emin misiniz?')) { window.location.href = '{{ route('filament.admin.resources.meetings.edit', $meeting) }}?delete=1'; }"
                                        class="p-2 text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 transition-colors duration-200 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800"
                                        title="Sil">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>

                            <a href="{{ route('filament.admin.resources.meetings.edit', $meeting) }}"
                               class="inline-flex items-center text-sm font-medium text-primary-600 dark:text-primary-400 hover:underline">
                                Detaylar
                                <svg class="w-3 h-3 ms-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        // Basit istemci taraflı arama işlevi
        document.getElementById('search-meetings').addEventListener('keyup', function() {
            const searchValue = this.value.toLowerCase();
            const meetingCards = document.querySelectorAll('.meeting-card');

            meetingCards.forEach(card => {
                const title = card.querySelector('h5').textContent.toLowerCase();
                const code = card.querySelector('p:nth-child(2)').textContent.toLowerCase();
                const customer = card.querySelector('p:nth-child(3)').textContent.toLowerCase();

                if (title.includes(searchValue) || code.includes(searchValue) || customer.includes(searchValue)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    </script>
</x-filament-panels::page>
