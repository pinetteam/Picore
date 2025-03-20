<x-filament-panels::page>
    <div>
        <!-- Program Listesi -->
        <div class="space-y-0">
            @if(count($programs) > 0)
                <div class="flow-root">
                    <ul class="timeline-flow">
                        @foreach($programs as $index => $program)
                            <li class="timeline-item">
                                <!-- Program Başlık Çubuğu -->
                                <div class="timeline-connector">
                                    <div class="timeline-connector-badge" style="background-color:
        {{ $program->type === 'session' ? '#3b82f6' :
           ($program->type === 'debate' ? '#f97316' : '#6b7280') }}; color: white; font-weight: bold; text-shadow: 0 1px 2px rgba(0,0,0,0.2);">
                                        {{ $index + 1 }}
                                    </div>
                                </div>

                                <!-- Program Kartı -->
                                <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm mb-4">
                                    <!-- Program Başlık Kısmı -->
                                    <div class="p-3 flex items-center justify-between flex-wrap">
                                        <div class="flex items-center space-x-3">
                                            <span class="text-lg font-medium">{{ $program->title }}</span>

                                            @if($program->code)
                                                <span class="px-2 py-0.5 text-xs bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 rounded">
                                                    {{ $program->code }}
                                                </span>
                                            @endif

                                            <span class="px-2 py-1 text-xs rounded-full
                                                {{ $program->type === 'session' ? 'bg-blue-100 text-blue-800' :
                                                   ($program->type === 'debate' ? 'bg-orange-100 text-orange-800' :
                                                   'bg-gray-100 text-gray-800') }}">
                                                {{ $program->type === 'session' ? 'Oturum' : ($program->type === 'debate' ? 'Tartışma' : 'Diğer') }}
                                            </span>

                                            <span class="px-2 py-1 text-xs rounded-full {{ $program->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $program->status ? 'Aktif' : 'Pasif' }}
                                            </span>
                                        </div>

                                        <div class="text-sm text-gray-600 dark:text-gray-400">
                                            {{ $program->start_at ? $program->start_at->format('d.m.Y H:i') : '-' }} -
                                            {{ $program->finish_at ? $program->finish_at->format('d.m.Y H:i') : '-' }}
                                        </div>

                                        <div class="flex space-x-2 mt-2 sm:mt-0">
                                            @if($program->type === 'session')
                                                <button type="button"
                                                        wire:click="mountAction('add_session', { record: {{ $program->id }} })"
                                                        class="inline-flex items-center justify-center px-3 py-1.5 bg-blue-500 hover:bg-blue-600   rounded-md shadow-sm transition-colors"
                                                >
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                                    </svg>
                                                    <span>Oturum Ekle</span>
                                                </button>
                                            @elseif($program->type === 'debate')
                                                <button type="button"
                                                        wire:click="mountAction('add_debate', { record: {{ $program->id }} })"
                                                        class="inline-flex items-center justify-center px-3 py-1.5 bg-green-500 hover:bg-green-600   rounded-md shadow-sm transition-colors"
                                                >
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                                    </svg>
                                                    <span>Tartışma Ekle</span>
                                                </button>
                                            @endif

                                            <button type="button"
                                                    wire:click="mountAction('edit_program', { record: {{ $program->id }} })"
                                                    class="inline-flex items-center justify-center px-3 py-1.5 bg-amber-500 hover:bg-amber-600   rounded-md shadow-sm transition-colors"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                                </svg>
                                                <span>Düzenle</span>
                                            </button>

                                            <button type="button"
                                                    wire:click="mountAction('delete_program', { record: {{ $program->id }} })"
                                                    class="inline-flex items-center justify-center px-3 py-1.5 bg-red-500 hover:bg-red-600   rounded-md shadow-sm transition-colors"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                                <span> {{ $program->id }} Sil</span>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Alt Öğeler (Oturumlar veya Tartışmalar) -->
                                    <div class="border-t border-gray-200 dark:border-gray-700">
                                        @if($program->type === 'session')
                                            <div class="p-3">
                                                <div class="flex items-center mb-3">
                                                    <span class="text-sm font-medium text-gray-900 dark:text-gray-100">Oturumlar</span>
                                                </div>

                                                <div class="overflow-x-auto">
                                                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                                        <thead class="bg-gray-50 dark:bg-gray-800">
                                                        <tr>
                                                            <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Sıra</th>
                                                            <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Konuşmacı</th>
                                                            <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Belge</th>
                                                            <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kod</th>
                                                            <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Başlık</th>
                                                            <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Başlangıç</th>
                                                            <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Bitiş</th>
                                                            <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Soru Limiti</th>
                                                            <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Durum</th>
                                                            <th scope="col" class="px-3 py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">İşlemler</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                                        @forelse($program->sessions as $session)
                                                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                                                <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                                    {{ $session->sort_order }}
                                                                </td>
                                                                <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                                                    {{ $session->speaker ? $session->speaker->name : '-' }}
                                                                </td>
                                                                <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                                    @if($session->document)
                                                                        <a href="#" class="text-blue-600 dark:text-blue-400 hover:underline">
                                                                            <x-filament::icon alias="panels::resources.action.view" icon="heroicon-m-document" class="w-4 h-4 inline" />
                                                                            Belge
                                                                        </a>
                                                                    @else
                                                                        -
                                                                    @endif
                                                                </td>
                                                                <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                                    {{ $session->code ?? '-' }}
                                                                </td>
                                                                <td class="px-3 py-2 whitespace-nowrap text-sm font-medium text-gray-700 dark:text-gray-300">
                                                                    {{ $session->title }}
                                                                </td>
                                                                <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                                    {{ $session->start_at ? $session->start_at->format('d.m.Y H:i') : '-' }}
                                                                </td>
                                                                <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                                    {{ $session->finish_at ? $session->finish_at->format('d.m.Y H:i') : '-' }}
                                                                </td>
                                                                <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                                    {{ $session->question_limit ?? '-' }}
                                                                </td>
                                                                <td class="px-3 py-2 whitespace-nowrap">
                                                                        <span class="inline-flex items-center justify-center h-6 w-6 rounded-full {{ $session->status ? 'bg-green-500' : 'bg-red-500' }}">
                                                                            <x-filament::icon alias="panels::resources.action.{{ $session->status ? 'view' : 'delete' }}" icon="{{ $session->status ? 'heroicon-m-check' : 'heroicon-m-x-mark' }}" class="w-4 h-4 text-white" />
                                                                        </span>
                                                                </td>
                                                                <td class="px-3 py-2 whitespace-nowrap text-right text-sm">
                                                                    <div class="flex justify-end space-x-1">
                                                                        <button class="p-1 rounded-full bg-blue-100 text-blue-600 hover:bg-blue-200 inline-flex items-center justify-center">
                                                                            <x-filament::icon alias="panels::resources.action.view" icon="heroicon-m-eye" class="w-4 h-4" />
                                                                        </button>
                                                                        <button type="button" wire:click="mountAction('edit_session', { record: {{ $session->id }} })" class="p-1 rounded-full bg-yellow-100 text-yellow-600 hover:bg-yellow-200 inline-flex items-center justify-center">
                                                                            <x-filament::icon alias="panels::resources.action.edit" icon="heroicon-m-pencil-square" class="w-4 h-4" />
                                                                        </button>
                                                                        <button type="button" wire:click="mountAction('delete_session', { record: {{ $session->id }} })" class="p-1 rounded-full bg-red-100 text-red-600 hover:bg-red-200 inline-flex items-center justify-center">
                                                                            <x-filament::icon alias="panels::resources.action.delete" icon="heroicon-m-trash" class="w-4 h-4" />
                                                                        </button>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="10" class="px-4 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                                                    <div>Henüz oturum eklenmemiş.</div>

                                                                </td>
                                                            </tr>
                                                        @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>

                                                @if($program->sessions->count() > 0)
                                                    <div class="mt-3 flex justify-center">
                                                        <x-filament::button
                                                            wire:click="mountAction('add_session', { record: {{ $program->id }} })"
                                                            color="primary"
                                                            icon="heroicon-m-plus"
                                                            size="sm">
                                                            Oturum Ekle
                                                        </x-filament::button>
                                                    </div>
                                                @endif
                                            </div>
                                        @elseif($program->type === 'debate')
                                            <div class="p-3">
                                                <div class="flex items-center mb-3">
                                                    <span class="text-sm font-medium text-gray-900 dark:text-gray-100">Tartışmalar</span>
                                                </div>

                                                <div class="overflow-x-auto">
                                                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                                        <thead class="bg-gray-50 dark:bg-gray-800">
                                                        <tr>
                                                            <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Sıra</th>
                                                            <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kod</th>
                                                            <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Başlık</th>
                                                            <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Açıklama</th>
                                                            <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Oylama Başlangıcı</th>
                                                            <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Oylama Bitişi</th>
                                                            <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Durum</th>
                                                            <th scope="col" class="px-3 py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">İşlemler</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                                        @forelse($program->debates as $debate)
                                                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                                                <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                                    {{ $debate->sort_order }}
                                                                </td>
                                                                <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                                    {{ $debate->code ?? '-' }}
                                                                </td>
                                                                <td class="px-3 py-2 whitespace-nowrap text-sm font-medium text-gray-700 dark:text-gray-300">
                                                                    {{ $debate->title }}
                                                                </td>
                                                                <td class="px-3 py-2 text-sm text-gray-500 dark:text-gray-400 max-w-xs truncate">
                                                                    {{ Str::limit($debate->description, 50) ?? '-' }}
                                                                </td>
                                                                <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                                    {{ $debate->voting_started_at ? $debate->voting_started_at->format('d.m.Y H:i') : '-' }}
                                                                </td>
                                                                <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                                    {{ $debate->voting_finished_at ? $debate->voting_finished_at->format('d.m.Y H:i') : '-' }}
                                                                </td>
                                                                <td class="px-3 py-2 whitespace-nowrap">
                                                                        <span class="inline-flex items-center justify-center h-6 w-6 rounded-full {{ $debate->status ? 'bg-green-500' : 'bg-red-500' }}">
                                                                            <x-filament::icon alias="panels::resources.action.{{ $debate->status ? 'view' : 'delete' }}" icon="{{ $debate->status ? 'heroicon-m-check' : 'heroicon-m-x-mark' }}" class="w-4 h-4 text-white" />
                                                                        </span>
                                                                </td>
                                                                <td class="px-3 py-2 whitespace-nowrap text-right text-sm">
                                                                    <div class="flex justify-end space-x-1">
                                                                        <button class="p-1 rounded-full bg-blue-100 text-blue-600 hover:bg-blue-200 inline-flex items-center justify-center">
                                                                            <x-filament::icon alias="panels::resources.action.view" icon="heroicon-m-eye" class="w-4 h-4" />
                                                                        </button>
                                                                        <button type="button" wire:click="mountAction('edit_debate', { record: {{ $debate->id }} })" class="p-1 rounded-full bg-yellow-100 text-yellow-600 hover:bg-yellow-200 inline-flex items-center justify-center">
                                                                            <x-filament::icon alias="panels::resources.action.edit" icon="heroicon-m-pencil-square" class="w-4 h-4" />
                                                                        </button>
                                                                        <button type="button" wire:click="mountAction('delete_debate', { record: {{ $debate->id }} })" class="p-1 rounded-full bg-red-100 text-red-600 hover:bg-red-200 inline-flex items-center justify-center">
                                                                            <x-filament::icon alias="panels::resources.action.delete" icon="heroicon-m-trash" class="w-4 h-4" />
                                                                        </button>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="8" class="px-4 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                                                    <div>Henüz tartışma eklenmemiş.</div>

                                                                </td>
                                                            </tr>
                                                        @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>

{{--                                                @if($program->debates->count() > 0)--}}
{{--                                                    <div class="mt-3 flex justify-center">--}}
{{--                                                        <x-filament::button--}}
{{--                                                            wire:click="mountAction('add_debate', { record: {{ $program->id }} })"--}}
{{--                                                            color="warning"--}}
{{--                                                            icon="heroicon-m-plus"--}}
{{--                                                            size="sm">--}}
{{--                                                            Tartışma Ekle--}}
{{--                                                        </x-filament::button>--}}
{{--                                                    </div>--}}
{{--                                                @endif--}}
                                            </div>
                                        @else
                                            <div class="p-4 text-center text-gray-500 dark:text-gray-400">
                                                Bu program için detay bilgisi bulunmuyor.
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @else
                <div class="text-center p-6 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                    <p class="text-gray-700 dark:text-gray-300 mb-4">Henüz program bulunmuyor.</p>
                    <x-filament::button
                        wire:click="mountAction('add_program')"
                        color="primary"
                        icon="heroicon-m-plus">
                        Program Ekle
                    </x-filament::button>
                </div>
            @endif
        </div>

        <!-- Yeni Program Ekleme Butonu -->
        <div class="mt-6 flex justify-center">
            <x-filament::button
                wire:click="addProgram"
                color="primary"
                icon="heroicon-m-plus">
                Yeni Program Ekle
            </x-filament::button>
        </div>
    </div>

    <style>
        .timeline-flow {
            position: relative;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .timeline-item {
            position: relative;
            padding-left: 3rem;
            margin-bottom: 1rem;
        }

        .timeline-item:not(:last-child)::before {
            content: '';
            position: absolute;
            top: 1.5rem;
            bottom: -1rem;
            left: 1.25rem;
            width: 2px;
            background-color: #e5e7eb;
            z-index: 0;
        }

        .timeline-connector {
            position: absolute;
            left: 0;
            top: 0.75rem;
            z-index: 1;
        }

        .timeline-connector-badge {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 9999px;
            background-color: #3b82f6; /* Default blue background */
            color: white;
            font-weight: 600;
            font-size: 0.875rem;
            z-index: 2;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }
    </style>
</x-filament-panels::page>
