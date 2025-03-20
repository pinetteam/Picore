<div class="p-4 relative">
    <!-- Sağ üstte geri dönüş butonu -->
    <div class="absolute top-2 right-2">
        <a href="{{ url("meeting-management/{$meeting->id}/halls/{$hall->id}/program") }}"
           class="inline-flex items-center px-4 py-2 bg-gray-200 rounded-lg text-gray-700 hover:bg-gray-300 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Back to Programs
        </a>
    </div>

    <div class="rounded-lg shadow p-6 mt-12">
        <h2 class="text-2xl font-bold mb-4">{{ $program->title }}</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                <p class="text-sm text-gray-500">Hall</p>
                <p class="font-medium">{{ $hall->title }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Status</p>
                <p class="font-medium">
                    @if($program->status)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Active
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            Inactive
                        </span>
                    @endif
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Start Date & Time</p>
                <p class="font-medium">{{ \Carbon\Carbon::parse($program->start_date)->format('d.m.Y H:i') }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">End Date & Time</p>
                <p class="font-medium">{{ \Carbon\Carbon::parse($program->end_date)->format('d.m.Y H:i') }}</p>
            </div>

            <div class="col-span-2">
                <p class="text-sm text-gray-500">Description</p>
                <p class="font-medium">{{ $program->description ?? 'No description available' }}</p>
            </div>
        </div>

        <div class="border-t pt-6">
            <h3 class="text-lg font-semibold mb-4">Speakers</h3>

            @if(isset($program->speakers) && count($program->speakers) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($program->speakers as $speaker)
                        <div class="border rounded-lg p-3 flex items-center">
                            <div class="w-12 h-12 rounded-full bg-gray-200 flex-shrink-0 overflow-hidden">
                                @if(isset($speaker->profile_image))
                                    <img src="{{ $speaker->profile_image }}" alt="{{ $speaker->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="ml-3">
                                <p class="font-medium">{{ $speaker->name }}</p>
                                <p class="text-sm text-gray-500">{{ $speaker->title ?? 'Speaker' }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">No speakers assigned to this program.</p>
            @endif
        </div>

        <div class="mt-6 flex justify-end space-x-3">
            <a href="#" onclick="Livewire.dispatch('openModal', { component: 'domain.meeting.modals.edit-program-modal', arguments: { programId: {{ $program->id }} } })"
               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                Edit Program
            </a>
            <a href="#" onclick="if(confirm('Are you sure you want to delete this program?')) { Livewire.dispatch('deleteProgram', { programId: {{ $program->id }} }) }"
               class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                Delete Program
            </a>
        </div>
    </div>
</div>
