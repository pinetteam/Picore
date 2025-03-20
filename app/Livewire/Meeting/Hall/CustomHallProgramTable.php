<?php

namespace App\Livewire\Meeting\Hall;

use Livewire\Component;
use App\Models\Meeting\Hall\Program\Program;
use App\Models\Meeting\Hall\Hall;
use Illuminate\Support\Collection;

class CustomHallProgramTable extends Component
{
    public $hallId;
    public $programs;
    public $expandedRows = [];

    protected $listeners = [
        'programAdded' => 'refreshData',
        'programUpdated' => 'refreshData',
        'programDeleted' => 'refreshData',
    ];

    public function mount($hallId)
    {
        $this->hallId = $hallId;
        $this->refreshData();
    }

    public function refreshData()
    {
        $this->programs = Program::where('hall_id', $this->hallId)
            ->with(['sessions', 'debates'])
            ->orderBy('sort_order')
            ->get();
    }

    public function toggleRow($rowId)
    {
        if (isset($this->expandedRows[$rowId])) {
            unset($this->expandedRows[$rowId]);
        } else {
            $this->expandedRows[$rowId] = true;
        }
    }

    public function render()
    {
        return view('livewire.meeting.hall.custom-hall-program-table');
    }
}
