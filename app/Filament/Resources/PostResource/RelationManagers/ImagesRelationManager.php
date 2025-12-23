<?php

namespace App\Filament\Resources\PostResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ImagesRelationManager extends RelationManager
{
    protected static string $relationship = 'images';

    protected static ?string $recordTitleAttribute = 'caption';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('image_path')
                    ->label('Gambar')
                    ->image()
                    ->imageEditor()
                    ->directory('foto-utama')
                    ->required(),
                Forms\Components\TextInput::make('caption')
                    ->label('Keterangan Singkat')
                    ->helperText('Judul atau keterangan singkat untuk gambar')
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->label('Deskripsi')
                    ->helperText('Deskripsi lengkap tentang gambar (opsional)')
                    ->rows(3),
                Forms\Components\TextInput::make('order')
                    ->label('Urutan')
                    ->helperText('Urutan tampilan gambar (angka lebih kecil ditampilkan lebih dulu)')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\Toggle::make('is_featured')
                    ->label('Gambar Unggulan')
                    ->helperText('Tandai sebagai gambar unggulan untuk ditampilkan sebagai thumbnail')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_path')
                    ->defaultImageUrl(asset('images/no_image.png'))
                    ->label('Gambar')
                    ->circular(false)
                    ->square()
                    ->width(100)
                    ->height(80),
                Tables\Columns\TextColumn::make('caption')
                    ->label('Keterangan')
                    ->searchable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('order')
                    ->label('Urutan')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Unggulan')
                    ->boolean()
                    ->trueIcon('heroicon-o-star')
                    ->falseIcon('heroicon-o-x-mark')
                    ->trueColor('warning')
                    ->falseColor('gray'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Gambar Unggulan')
                    ->placeholder('Semua Gambar')
                    ->trueLabel('Hanya Unggulan')
                    ->falseLabel('Bukan Unggulan')
                    ->queries(
                        true: fn(Builder $query) => $query->where('is_featured', true),
                        false: fn(Builder $query) => $query->where('is_featured', false),
                        blank: fn(Builder $query) => $query,
                    ),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        return $data;
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('order');
    }
}
