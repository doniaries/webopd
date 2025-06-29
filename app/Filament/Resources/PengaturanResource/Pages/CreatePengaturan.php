<?php

namespace App\Filament\Resources\PengaturanResource\Pages;

use App\Filament\Resources\PengaturanResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePengaturan extends CreateRecord
{
    protected static string $resource = PengaturanResource::class;
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return $data;
    }
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
