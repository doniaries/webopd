<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InfografisResource\Pages;
use App\Filament\Resources\InfografisResource\RelationManagers;
use App\Models\Infografis;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class InfografisResource extends Resource
{
    protected static ?string $model = Infografis::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $modelLabel = 'Infografis';
    protected static ?string $navigationGroup = 'Konten';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Dasar')
                    ->schema([
                        Forms\Components\TextInput::make('judul')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn(string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),

                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->disabled(fn(string $operation): bool => $operation === 'edit'),

                        Forms\Components\FileUpload::make('gambar')
                            ->label('Gambar Infografis')
                            ->image()
                            ->imageEditor()
                            ->required()
                            ->directory('infografis')
                            ->columnSpanFull(),

                        Forms\Components\Select::make('kategori')
                            ->options([
                                'pendidikan' => 'Pendidikan',
                                'kesehatan' => 'Kesehatan',
                                'infrastruktur' => 'Infrastruktur',
                                'ekonomi' => 'Ekonomi',
                                'sosial' => 'Sosial',
                                'lainnya' => 'Lainnya',
                            ])
                            ->required(),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true),

                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('gambar')
                    ->defaultImageUrl(asset('images/no_image.png'))
                    ->label('Gambar')
                    ->circular(),

                Tables\Columns\TextColumn::make('judul')
                    ->label('Judul')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('kategori')
                    ->label('Kategori')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pendidikan' => 'info',
                        'kesehatan' => 'danger',
                        'infrastruktur' => 'warning',
                        'ekonomi' => 'success',
                        'sosial' => 'primary',
                        default => 'gray',
                    })
                    ->searchable()
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->sortable(),


            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kategori')
                    ->options([
                        'pendidikan' => 'Pendidikan',
                        'kesehatan' => 'Kesehatan',
                        'infrastruktur' => 'Infrastruktur',
                        'ekonomi' => 'Ekonomi',
                        'sosial' => 'Sosial',
                        'lainnya' => 'Lainnya',
                    ]),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Aktif')
                    ->boolean(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListInfografis::route('/'),
            'create' => Pages\CreateInfografis::route('/create'),
            'view' => Pages\ViewInfografis::route('/{record}'),
            'edit' => Pages\EditInfografis::route('/{record}/edit'),
        ];
    }
}
