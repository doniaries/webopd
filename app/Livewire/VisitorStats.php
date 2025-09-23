<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Visit;
use Illuminate\Support\Facades\DB;

class VisitorStats extends Component
{
    public $today = 0;
    public $month = 0;
    public $online = 0;
    public $ip = '';

    public function mount()
    {
        $now = now();
        $this->ip = request()->ip();

        // Today total
        $this->today = Visit::whereDate('visited_at', $now->toDateString())->distinct('session_id')->count('session_id');

        // Monthly total
        $this->month = Visit::whereYear('visited_at', $now->year)
            ->whereMonth('visited_at', $now->month)
            ->distinct('session_id')->count('session_id');

        // Online (active in last 5 minutes)
        $this->online = Visit::where('last_activity', '>=', $now->copy()->subMinutes(5))
            ->distinct('session_id')->count('session_id');
    }

    public function render()
    {
        return view('livewire.visitor-stats');
    }
}
