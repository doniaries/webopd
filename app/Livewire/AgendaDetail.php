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
            'pageTitle' => $this->agenda->nama_agenda,
            'pageDescription' => \Illuminate\Support\Str::limit(strip_tags($this->agenda->uraian_agenda), 160)
        ]);
    }
}
