<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostGalleryResource\Pages;
use App\Filament\Resources\PostGalleryResource\RelationManagers;
use App\Models\PostGallery;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PostGalleryResource extends Resource
{
    protected static ?string $model = PostGallery::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $modelLabel = 'Galeri Post';
    protected static ?string $navigationLabel = 'Galeri Post';
    protected static ?string $navigationGroup = 'Postingan';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('post_id')
                    ->relationship('post', 'title')
                    ->label('Post')
                    ->required()
                    ->searchable()
                    ->preload(),
                Forms\Components\FileUpload::make('image_path')
                    ->label('Gambar')
                    ->directory('gallery-images')
                    ->image()
                    ->required()
                    ->imageEditor()
                    ->imageResizeMode('cover')
                    ->optimize('webp')
                    ->maxSize(2048),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_path')
                    ->defaultImageUrl(asset('images/no_image.png'))
                    ->label('Gambar')
                    ->disk('public'),
                Tables\Columns\TextColumn::make('post.title')
                    ->label('Post')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPostGalleries::route('/'),
            'create' => Pages\CreatePostGallery::route('/create'),
            'edit' => Pages\EditPostGallery::route('/{record}/edit'),
        ];
    }
}
