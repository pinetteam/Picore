<div>
    <h2 class="text-xl font-bold mb-4">Katılımcılar</h2>

    @if($meeting->participants && $meeting->participants->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ad Soyad</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">E-posta</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rol</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @foreach($meeting->participants as $participant)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $participant->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $participant->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $participant->role }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center p-4 text-gray-500">
            <p>Bu toplantı için henüz katılımcı bulunmuyor.</p>
        </div>
    @endif
</div>
