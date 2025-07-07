<?php

namespace App\Filament\Resources\PostGalleryResource\Pages;

use App\Filament\Resources\PostGalleryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPostGallery extends EditRecord
{
    protected static string $resource = PostGalleryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
