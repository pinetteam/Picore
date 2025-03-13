<div>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold">Duyurular</h2>
    </div>

    @if($this->currentSection === 'announcements')
        {{ $this->table }}
    @endif
</div>
