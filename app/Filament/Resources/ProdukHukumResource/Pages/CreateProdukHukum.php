<?php

namespace App\Filament\Resources\ProdukHukumResource\Pages;

use App\Filament\Resources\ProdukHukumResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProdukHukum extends CreateRecord
{
    protected static string $resource = ProdukHukumResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
