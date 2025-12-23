<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SambutanPimpinanResource\Pages;
use App\Filament\Resources\SambutanPimpinanResource\RelationManagers;
use App\Models\SambutanPimpinan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class SambutanPimpinanResource extends Resource
{
    protected static ?string $model = SambutanPimpinan::class;

    protected static ?string $navigationIcon = 'heroicon-o-microphone';

    protected static ?string $modelLabel = 'Sambutan Pimpinan';

    protected static ?string $navigationGroup = 'Instansi';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('judul')
                    ->default('Sambutan Pimpinan')
                    ->dehydrated()
                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                        $set('slug', \Illuminate\Support\Str::slug($state));
                    }),
                Forms\Components\Hidden::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true),

                Forms\Components\RichEditor::make('isi_sambutan')
                    ->label('Isi Sambutan')
                    ->required()
                    ->columnSpanFull()
                    ->hint('Tuliskan sambutan pimpinan di sini'),
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('jabatan')
                    ->required()
                    ->maxLength(255),

                Forms\Components\FileUpload::make('foto')
                    ->image()
                    ->required(),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama')
                    ->limit(100),
                Tables\Columns\TextColumn::make('jabatan')
                    ->label('Jabatan')
                    ->default('Kepala Dinas')
                    ->limit(100),
                Tables\Columns\TextColumn::make('isi_sambutan')
                    ->label('Isi Sambutan')
                    ->limit(100)
                    ->html()
                    ->wrap(),
                Tables\Columns\ImageColumn::make('foto')
                    ->defaultImageUrl(asset('images/no_image.png'))
                    ->label('Foto Pimpinan'),


                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Terakhir Diperbarui')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListSambutanPimpinans::route('/'),
            'create' => Pages\CreateSambutanPimpinan::route('/create'),
            'edit' => Pages\EditSambutanPimpinan::route('/{record}/edit'),
        ];
    }
}
