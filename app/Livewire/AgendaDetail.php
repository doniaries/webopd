<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\AgendaKegiatan;

class AgendaDetail extends Component
{
    public $agenda;

    public function mount(AgendaKegiatan $agenda)
    {
        $this->agenda = $agenda;
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
