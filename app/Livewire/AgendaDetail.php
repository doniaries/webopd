<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\AgendaKegiatan;

class AgendaDetail extends Component
{
    public $id;
    public $agenda;

    public function mount($id)
    {
        $this->id = $id;
        $this->agenda = AgendaKegiatan::findOrFail($id);
    }

    public function render()
    {
        return view('livewire.agenda-detail', [
            'agenda' => $this->agenda,
        ]);
    }
}
