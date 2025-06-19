<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SliderResource\Pages;
use App\Filament\Resources\SliderResource\RelationManagers;
use App\Models\Slider;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class SliderResource extends Resource
{
    protected static ?string $model = Slider::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Slider';
    protected static ?string $modelLabel = 'Slider';
    protected static ?string $navigationGroup = 'Konten';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('team_id')
                    ->default(fn() => Auth::user()->current_team_id)
                    ->hidden(fn() => !in_array(Auth::user()->email, ['admin@example.com'])), // Ganti dengan email admin yang sesuai
                Forms\Components\TextInput::make('judul')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('deskripsi')
                    ->columnSpanFull()
                    ->maxLength(500),
                Forms\Components\FileUpload::make('gambar')
                    ->required()
                    ->imageEditor()
                    ->image()
                    ->optimize('webp')
                    ->directory('sliders')
                    ->visibility('public')
                    ->maxSize(3072) // 3MB
                    ->imageResizeMode('cover')
                    ->imageCropAspectRatio('16:9')
                    ->imageResizeTargetWidth(1920)
                    ->imageResizeTargetHeight(1080)
                    ->hint('Ukuran disarankan: 1920x1080px (16:9), Maks: 3MB')
                    ->hintIcon('heroicon-o-information-circle')
                    ->hintColor('primary')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('url')
                    ->label('URL Tujuan')
                    ->maxLength(255)
                    ->url()
                    ->hint('Opsional: Isi jika ingin menambahkan tombol dengan link')
                    ->hintIcon('heroicon-o-link')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('urutan')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\Toggle::make('is_active')
                    ->required()
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('judul')
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                Tables\Columns\ImageColumn::make('gambar')
                    ->width(150)
                    ->height(80)
                    ->extraImgAttributes(['class' => 'object-cover rounded']),
                Tables\Columns\TextColumn::make('urutan')
                    ->numeric()
                    ->sortable()
                    ->alignCenter(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Aktif')
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('urutan', 'asc')
            ->filters([
                Tables\Filters\SelectFilter::make('is_active')
                    ->options([
                        '1' => 'Aktif',
                        '0' => 'Tidak Aktif',
                    ])
                    ->label('Status'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->iconButton()
                    ->icon('heroicon-o-pencil')
                    ->color('primary'),
                Tables\Actions\DeleteAction::make()
                    ->iconButton()
                    ->icon('heroicon-o-trash')
                    ->color('danger'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Hapus yang dipilih'),
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
            'index' => Pages\ListSliders::route('/'),
            'create' => Pages\CreateSlider::route('/create'),
            'edit' => Pages\EditSlider::route('/{record}/edit'),
        ];
    }
}
