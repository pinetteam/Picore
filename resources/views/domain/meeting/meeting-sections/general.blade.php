<div>
    <h2 class="text-xl font-semibold mb-4">Toplantı Genel Bilgileri</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <div class="bg-gray-50 p-4 rounded-md">
                <h3 class="font-medium text-lg mb-3">Temel Bilgiler</h3>

                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Toplantı Kodu:</span>
                        <span class="font-medium">{{ $meeting->code }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-600">Başlık:</span>
                        <span class="font-medium">{{ $meeting->title }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-600">Tür:</span>
                        <span class="font-medium">{{ $meeting->type ?: '-' }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-600">Durum:</span>
                        <span class="font-medium">{{ $meeting->status ? 'Aktif' : 'Pasif' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="bg-gray-50 p-4 rounded-md">
                <h3 class="font-medium text-lg mb-3">Tarih Bilgileri</h3>

                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Başlangıç Tarihi:</span>
                        <span class="font-medium">{{ \Carbon\Carbon::parse($meeting->start_at)->format('d.m.Y') }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-600">Bitiş Tarihi:</span>
                        <span class="font-medium">{{ \Carbon\Carbon::parse($meeting->finish_at)->format('d.m.Y') }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-600">Oluşturulma Tarihi:</span>
                        <span class="font-medium">{{ $meeting->created_at->format('d.m.Y H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($meeting->banner_name)
        <div class="mt-6">
            <h3 class="font-medium text-lg mb-3">Toplantı Banner</h3>
            <img src="{{ asset('storage/' . $meeting->banner_name) }}"
                 alt="{{ $meeting->title }}"
                 class="max-w-full rounded-lg shadow-sm" />
        </div>
    @endif
</div>
