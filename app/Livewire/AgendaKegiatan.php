<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class AgendaKegiatan extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 6;
    public $currentMonth;
    public $currentYear;
    public $months = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember'
    ];
    public $years = [];

    public function mount()
    {
        $this->currentMonth = now()->month;
        $this->currentYear = now()->year;

        // Generate years from current year - 5 to current year + 5
        $currentYear = now()->year;
        $this->years = range($currentYear - 5, $currentYear + 5);
    }

    public function nextMonth()
    {
        $date = Carbon::create($this->currentYear, $this->currentMonth, 1)->addMonth();
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
        $this->resetPage();
    }

    public function previousMonth()
    {
        $date = Carbon::create($this->currentYear, $this->currentMonth, 1)->subMonth();
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
        $this->resetPage();
    }

    public function render()
    {
        // Debug: Tampilkan parameter query
        \Log::info('Query parameters:', [
            'month' => $this->currentMonth,
            'year' => $this->currentYear,
            'search' => $this->search
        ]);

        $query = \App\Models\AgendaKegiatan::where('dari_tanggal', '>=', now()->toDateString())
            ->orderBy('dari_tanggal', 'asc')
            ->orderBy('waktu_mulai', 'asc');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('nama_agenda', 'like', '%' . $this->search . '%')
                    ->orWhere('uraian_agenda', 'like', '%' . $this->search . '%')
                    ->orWhere('tempat', 'like', '%' . $this->search . '%');
            });
        }

        $agendas = $query->paginate($this->perPage);

        // Debug: Tampilkan data yang ditemukan
        \Log::info('Agendas found:', [
            'count' => $agendas->count(),
            'items' => $agendas->toArray()
        ]);

        return view('livewire.agenda-kegiatan', [
            'agendas' => $agendas,
            'months' => $this->months,
            'currentMonth' => $this->currentMonth,
            'currentYear' => $this->currentYear,
            'pageTitle' => 'Agenda Kegiatan',
            'pageDescription' => 'Daftar agenda dan kegiatan terbaru',
        ]);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function changeMonth($month)
    {
        $this->currentMonth = $month;
        $this->resetPage();
    }

    public function changeYear($year)
    {
        $this->currentYear = $year;
        $this->resetPage();
    }
}
