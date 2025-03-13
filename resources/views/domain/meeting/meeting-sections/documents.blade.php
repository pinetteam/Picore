<div>
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold">Dökümanlar</h2>
        <button class="px-4 py-2 bg-primary-500 text-white rounded-md">
            Yeni Döküman Yükle
        </button>
    </div>

    @if($meeting->documents && $meeting->documents->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($meeting->documents as $document)
                <div class="border rounded-lg p-4">
                    <div class="flex items-center mb-2">
                        <x-heroicon-o-document class="w-6 h-6 text-gray-500 mr-2" />
                        <h3 class="font-medium">{{ $document->name }}</h3>
                    </div>
                    <p class="text-sm text-gray-500 mb-2">
                        {{ $document->file_type }} · {{ number_format($document->file_size / 1024, 2) }} KB
                    </p>
                    <div class="flex justify-end">
                        <a href="{{ $document->file_url }}" class="text-primary-500 hover:underline text-sm" target="_blank">
                            İndir
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center p-4 text-gray-500">
            <p>Bu toplantı için henüz döküman bulunmuyor.</p>
        </div>
    @endif
</div>
