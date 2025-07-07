<?php

namespace App\Filament\Resources\PostGalleryResource\Pages;

use App\Filament\Resources\PostGalleryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPostGalleries extends ListRecords
{
    protected static string $resource = PostGalleryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
