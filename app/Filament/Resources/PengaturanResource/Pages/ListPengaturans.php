<?php

namespace App\Filament\Resources\PengaturanResource\Pages;

use App\Filament\Resources\PengaturanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPengaturans extends ListRecords
{
    protected static string $resource = PengaturanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function mount(): void
    {
        $settings = \App\Models\Pengaturan::first();

        if ($settings) {
            $this->redirect(PengaturanResource::getUrl('view', ['record' => $settings]));
        } else {
            $this->redirect(PengaturanResource::getUrl('create'));
        }
    }
}
