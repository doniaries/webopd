<?php

namespace App\Filament\Resources\PostGalleryResource\Pages;

use App\Filament\Resources\PostGalleryResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePostGallery extends CreateRecord
{
    protected static string $resource = PostGalleryResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
