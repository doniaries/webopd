<?php

namespace App\Filament\Resources\InfografisResource\Widgets;

use App\Models\Infografis;
use Filament\Widgets\Widget;
use Illuminate\Support\HtmlString;

class InfografisOverview extends Widget
{
    protected static string $view = 'filament.resources.infografis-resource.widgets.infografis-overview';
    
    public ?Infografis $record = null;
    
    protected int | string | array $columnSpan = 'full';
    
    public function mount(Infografis $record): void
    {
        $this->record = $record;
    }
    
    protected function getViewData(): array
    {
        return [
            'record' => $this->record,
        ];
    }
}

// This widget will be used to display the infographic details in the view page.
