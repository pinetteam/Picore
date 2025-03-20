<div>
    <!-- Header with Add Button -->
    <div class="mb-4 flex justify-between items-center">
        <h2 class="text-lg font-medium">Salon Programları</h2>
        <button
            type="button"
            wire:click="$dispatch('openModal', {id: 'add-program-modal', params: {hallId: {{ $hallId }}} })"
            class="inline-flex items-center px-4 py-2 bg-primary-500 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-600">
            <x-heroicon-o-plus class="w-4 h-4 mr-1" />
            Program Ekle
        </button>
    </div>

    <!-- Custom Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Sıralama
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Kod
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Başlık
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Başlangıç
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Bitiş
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Tür
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Durum
                </th>
                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                    İşlemler
                </th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
            @forelse($programs as $program)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $program->sort_order }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $program->code }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        <div class="flex items-center">
                            @if(($program->type === 'session' && $program->sessions->count() > 0) ||
                               ($program->type === 'debate' && $program->debates->count() > 0))
                                <button wire:click="toggleRow('{{ $program->id }}')" class="mr-2 text-primary-500">
                                    @if(isset($expandedRows[$program->id]))
                                        <x-heroicon-o-chevron-down class="w-4 h-4 transform rotate-0 transition-transform" />
                                    @else
                                        <x-heroicon-o-chevron-right class="w-4 h-4 transform rotate-0 transition-transform" />
                                    @endif
                                </button>
                            @endif
                            {{ $program->title }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $program->start_at }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $program->finish_at }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                            {{ $program->type === 'session' ? 'bg-green-100 text-green-800' :
                              ($program->type === 'debate' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                            {{ $program->type === 'session' ? 'Oturum' :
                              ($program->type === 'debate' ? 'Tartışma' : 'Diğer') }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        @if($program->status)
                            <span class="text-green-600"><x-heroicon-o-check-circle class="w-5 h-5" /></span>
                        @else
                            <span class="text-red-600"><x-heroicon-o-x-circle class="w-5 h-5" /></span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex justify-end space-x-2">
                            <button wire:click="$dispatch('openModal', {id: 'edit-program-modal', params: {programId: {{ $program->id }}} })"
                                    class="text-yellow-600 hover:text-yellow-900">
                                <x-heroicon-o-pencil class="w-5 h-5" />
                            </button>
                            <button wire:click="$dispatch('openModal', {id: 'delete-program-modal', params: {programId: {{ $program->id }}} })"
                                    class="text-red-600 hover:text-red-900">
                                <x-heroicon-o-trash class="w-5 h-5" />
                            </button>
                        </div>
                    </td>
                </tr>

                <!-- Expanded Content for Sessions or Debates -->
                @if(isset($expandedRows[$program->id]))
                    <tr>
                        <td colspan="8" class="px-6 py-4 bg-gray-50">
                            @if($program->type === 'session' && $program->sessions->count() > 0)
                                <!-- Sessions Table -->
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200 border">
                                        <thead class="bg-gray-100">
                                        <tr>
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
                                                <td class="px-4 py-2 text-xs">{{ $session->speaker->name ?? '-' }}</td>
                                                <td class="px-4 py-2 text-xs">{{ $session->document->title ?? '-' }}</td>
                                                <td class="px-4 py-2 text-xs">{{ $session->title }}</td>
                                                <td class="px-4 py-2 text-xs">{{ $session->start_at }}</td>
                                                <td class="px-4 py-2 text-xs">{{ $session->finish_at }}</td>
                                                <td class="px-4 py-2 text-xs">
                                                    @if($session->questions_allowed)
                                                        <span class="text-green-600">Aktif</span>
                                                    @else
                                                        <span class="text-red-600">Pasif</span>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-2 text-xs">
                                                    <div class="flex space-x-2">
                                                        <button wire:click="$dispatch('openModal', {id: 'edit-session-modal', params: {sessionId: {{ $session->id }}} })"
                                                                class="text-yellow-600 hover:text-yellow-900">
                                                            <x-heroicon-o-pencil class="w-4 h-4" />
                                                        </button>
                                                        <button wire:click="$dispatch('openModal', {id: 'delete-session-modal', params: {sessionId: {{ $session->id }}} })"
                                                                class="text-red-600 hover:text-red-900">
                                                            <x-heroicon-o-trash class="w-4 h-4" />
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @elseif($program->type === 'debate' && $program->debates->count() > 0)
                                <!-- Debates Table -->
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200 border">
                                        <thead class="bg-gray-100">
                                        <tr>
                                            <th class="px-4 py-2 text-xs text-gray-500">Sıralama</th>
                                            <th class="px-4 py-2 text-xs text-gray-500">Kod</th>
                                            <th class="px-4 py-2 text-xs text-gray-500">Başlık</th>
                                            <th class="px-4 py-2 text-xs text-gray-500">Açıklama</th>
                                            <th class="px-4 py-2 text-xs text-gray-500">Oylama Başlangıç</th>
                                            <th class="px-4 py-2 text-xs text-gray-500">Oylama Bitiş</th>
                                            <th class="px-4 py-2 text-xs text-gray-500">Durum</th>
                                            <th class="px-4 py-2 text-xs text-gray-500">İşlemler</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($program->debates as $debate)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-4 py-2 text-xs">{{ $debate->sort_order }}</td>
                                                <td class="px-4 py-2 text-xs">{{ $debate->code }}</td>
                                                <td class="px-4 py-2 text-xs">{{ $debate->title }}</td>
                                                <td class="px-4 py-2 text-xs">{{ Str::limit($debate->description, 30) }}</td>
                                                <td class="px-4 py-2 text-xs">{{ $debate->voting_started_at }}</td>
                                                <td class="px-4 py-2 text-xs">{{ $debate->voting_finished_at }}</td>
                                                <td class="px-4 py-2 text-xs">
                                                    @if($debate->status)
                                                        <span class="text-green-600">Aktif</span>
                                                    @else
                                                        <span class="text-red-600">Pasif</span>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-2 text-xs">
                                                    <div class="flex space-x-2">
                                                        <button wire:click="$dispatch('openModal', {id: 'edit-debate-modal', params: {debateId: {{ $debate->id }}} })"
                                                                class="text-yellow-600 hover:text-yellow-900">
                                                            <x-heroicon-o-pencil class="w-4 h-4" />
                                                        </button>
                                                        <button wire:click="$dispatch('openModal', {id: 'delete-debate-modal', params: {debateId: {{ $debate->id }}} })"
                                                                class="text-red-600 hover:text-red-900">
                                                            <x-heroicon-o-trash class="w-4 h-4" />
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
</div>
