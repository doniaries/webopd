<?php

namespace App\Filament\Resources\InfografisResource\Pages;

use App\Filament\Resources\InfografisResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewInfografis extends ViewRecord
{
    protected static string $resource = InfografisResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            InfografisResource\Widgets\InfografisOverview::class,
        ];
    }
}
