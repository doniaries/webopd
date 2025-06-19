<?php

namespace App\Filament\Resources\PostImageResource\Pages;

use App\Filament\Resources\PostImageResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePostImage extends CreateRecord
{
    protected static string $resource = PostImageResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['team_id'] = auth()->user()->teams()->first()->id;
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
