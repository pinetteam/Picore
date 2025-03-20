<div>
    <!-- Üst Eylemler (Yeni Ekle vb.) -->
    <div class="flex justify-between items-center p-4 border-b">
        <h2 class="text-lg font-medium text-gray-900">Salon Programları</h2>
        <button
            onclick="Livewire.dispatch('mountAction', { id: 'add_program' })"
            class="px-4 py-2 bg-primary-600 text-white text-sm rounded-lg hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500">
            <span class="flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Program Ekle
            </span>
        </button>
    </div>

    <!-- Tablo -->
    <table class="min-w-full divide-y divide-gray-200">
        <thead>
        <tr>
            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sıralama</th>
            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kod</th>
            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Başlık</th>
            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Başlangıç</th>
            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bitiş</th>
            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tür</th>
            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durum</th>
            <th class="px-6 py-3 bg-gray-50 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">İşlemler</th>
        </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
        @forelse ($programs as $program)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $program->sort_order }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $program->code }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    <div class="flex items-center">
                        @if(($program->type === 'session' && $program->sessions->count() > 0) ||
                           ($program->type === 'debate' && $program->debates->count() > 0))
                            <button
                                onclick="Livewire.dispatch('call', { method: 'toggleRow', params: ['{{ $program->id }}'] })"
                                class="mr-2 text-primary-500">
                                @if(isset($expandedRows[$program->id]))
                                    <svg class="w-4 h-4 expand-button expanded" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                @else
                                    <svg class="w-4 h-4 expand-button collapsed" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                @endif
                            </button>
                        @endif
                        {{ $program->title }}
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $program->start_at }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $program->finish_at }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            {{ $program->type === 'session' ? 'bg-green-100 text-green-800' :
                              ($program->type === 'debate' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                            {{ $program->type === 'session' ? 'Oturum' :
                              ($program->type === 'debate' ? 'Tartışma' : 'Diğer') }}
                        </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    @if($program->status)
                        <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    @else
                        <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <div class="flex justify-end space-x-2">
                        <!-- İşlemler -->
                        <button
                            onclick="Livewire.dispatch('mountAction', { id: 'edit', arguments: { record: '{{ $program->id }}' } })"
                            class="text-yellow-600 hover:text-yellow-900">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                            </svg>
                        </button>
                        <button
                            onclick="Livewire.dispatch('mountAction', { id: 'delete', arguments: { record: '{{ $program->id }}' } })"
                            class="text-red-600 hover:text-red-900">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                </td>
            </tr>

            <!-- Genişletilmiş İçerik (Oturumlar veya Tartışmalar) -->
            @if(isset($expandedRows[$program->id]))
                <tr>
                    <td colspan="8" class="px-6 py-4 bg-gray-50">
                        @if($program->type === 'session' && $program->sessions->count() > 0)
                            <!-- Oturumlar Tablosu -->
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 border">
                                    <thead>
                                    <tr class="bg-gray-100">
                                        <th class="px-4 py-2 text-xs text-gray-500">Konuşmacı</th>
                                        <th class="px-4 py-2 text-xs text-gray-500">Doküman</th>
                                        <th class="px-4 py-2 text-xs text-gray-500">Başlık</th>
                                        <th class="px-4 py-2 text-xs text-gray-500">Başlangıç</th>
                                        <th class="px-4 py-2 text-xs text-gray-500">Bitiş</th>
                                        <th class="px-4 py-2 text-xs text-gray-500">Sorular</th>
                                        <th class="px-4 py-2 text-xs text-gray-500">İşlemler</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($program->sessions as $session)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 text-xs text-gray-500">{{ $session->speaker->name ?? '-' }}</td>
                                            <td class="px-4 py-2 text-xs text-gray-500">{{ $session->document->title ?? '-' }}</td>
                                            <td class="px-4 py-2 text-xs text-gray-500">{{ $session->title }}</td>
                                            <td class="px-4 py-2 text-xs text-gray-500">{{ $session->start_at }}</td>
                                            <td class="px-4 py-2 text-xs text-gray-500">{{ $session->finish_at }}</td>
                                            <td class="px-4 py-2 text-xs text-gray-500">
                                                @if($session->questions_allowed)
                                                    <span class="text-green-600">Aktif</span>
                                                @else
                                                    <span class="text-red-600">Pasif</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-2 text-xs">
                                                <div class="flex space-x-2">
                                                    <button
                                                        onclick="Livewire.dispatch('mountAction', { id: 'edit_session', arguments: { record: '{{ $session->id }}' } })"
                                                        class="text-yellow-600 hover:text-yellow-900">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                                        </svg>
                                                    </button>
                                                    <button
                                                        onclick="Livewire.dispatch('mountAction', { id: 'delete_session', arguments: { record: '{{ $session->id }}' } })"
                                                        class="text-red-600 hover:text-red-900">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @elseif($program->type === 'debate' && $program->debates->count() > 0)
                            <!-- Tartışmalar Tablosu -->
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 border">
                                    <thead>
                                    <tr class="bg-gray-100">
                                        <th class="px-4 py-2 text-xs text-gray-500">Sıralama</th>
                                        <th class="px-4 py-2 text-xs text-gray-500">Kod</th>
                                        <th class="px-4 py-2 text-xs text-gray-500">Başlık</th>
                                        <th class="px-4 py-2 text-xs text-gray-500">Açıklama</th>
                                        <th class="px-4 py-2 text-xs text-gray-500">Oylama Başlangıcı</th>
                                        <th class="px-4 py-2 text-xs text-gray-500">Oylama Bitişi</th>
                                        <th class="px-4 py-2 text-xs text-gray-500">Durum</th>
                                        <th class="px-4 py-2 text-xs text-gray-500">İşlemler</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($program->debates as $debate)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 text-xs text-gray-500">{{ $debate->sort_order }}</td>
                                            <td class="px-4 py-2 text-xs text-gray-500">{{ $debate->code }}</td>
                                            <td class="px-4 py-2 text-xs text-gray-500">{{ $debate->title }}</td>
                                            <td class="px-4 py-2 text-xs text-gray-500">{{ \Illuminate\Support\Str::limit($debate->description, 30) }}</td>
                                            <td class="px-4 py-2 text-xs text-gray-500">{{ $debate->voting_started_at }}</td>
                                            <td class="px-4 py-2 text-xs text-gray-500">{{ $debate->voting_finished_at }}</td>
                                            <td class="px-4 py-2 text-xs text-gray-500">
                                                @if($debate->status)
                                                    <span class="text-green-600">Aktif</span>
                                                @else
                                                    <span class="text-red-600">Pasif</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-2 text-xs">
                                                <div class="flex space-x-2">
                                                    <button
                                                        onclick="Livewire.dispatch('mountAction', { id: 'edit_debate', arguments: { record: '{{ $debate->id }}' } })"
                                                        class="text-yellow-600 hover:text-yellow-900">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                                        </svg>
                                                    </button>
                                                    <button
                                                        onclick="Livewire.dispatch('mountAction', { id: 'delete_debate', arguments: { record: '{{ $debate->id }}' } })"
                                                        class="text-red-600 hover:text-red-900">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </td>
                </tr>
            @endif
        @empty
            <tr>
                <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                    Henüz program bulunmuyor. Yeni bir program ekleyin.
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
