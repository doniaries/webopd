<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PengaturanResource\Pages;
use App\Filament\Resources\PengaturanResource\RelationManagers;
use App\Models\Pengaturan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components;
use Filament\Tables\Actions\ViewAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PengaturanResource extends Resource
{
    protected static ?string $model = Pengaturan::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'Identitas Instansi';
    protected static ?string $modelLabel = 'Pengaturan';
    protected static ?string $pluralModelLabel = 'Pengaturan';
    protected static ?string $navigationGroup = 'Instansi';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Website')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Instansi')
                            ->required()
                            ->dehydrated()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                $set('slug', \Illuminate\Support\Str::slug($state));
                            })
                            ->unique(ignoreRecord: true),

                        Forms\Components\TextInput::make('kabupaten')
                            ->label('Kabupaten / Kota')
                            ->placeholder('Contoh: Kota Padang Panjang')
                            ->maxLength(255),

                        Forms\Components\Hidden::make('slug')
                            ->label('Slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->hint('URL-friendly version of the name (auto-generated if empty)'),

                        Forms\Components\Textarea::make('alamat_instansi')
                            ->label('Alamat Instansi')
                            ->required()
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('kepala_instansi')
                            ->label('Nama Kepala Instansi')
                            ->maxLength(255)
                            ->columnSpan(1),

                        Forms\Components\FileUpload::make('foto_pimpinan')
                            ->label('Foto Pimpinan')
                            ->image()
                            ->imageEditor()
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('3:4')
                            ->imageResizeTargetWidth('300')
                            ->imageResizeTargetHeight('400')
                            ->directory('pengaturan/foto-pimpinan')
                            ->visibility('public')
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg'])
                            ->minSize(200) // 200KB
                            ->maxSize(2048) // 2MB
                            ->helperText('Format: JPG, JPEG, PNG | Ukuran: 200KB - 2MB | Rasio: 3:4')
                            ->columnSpan(1),

                        Forms\Components\TextInput::make('no_telp_instansi')
                            ->label('Nomor Telepon')
                            ->tel()
                            ->maxLength(20),

                        Forms\Components\TextInput::make('email_instansi')
                            ->label('Email Instansi')
                            ->email()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        // Forms\Components\TextInput::make('alamat_instansi')
                        //     ->label('Alamat Instansi')
                        //     ->required()
                        //     ->maxLength(255),

                        // Add these inside the Informasi Website section, before the columns(2) call
                        Forms\Components\TextInput::make('latitude')
                            ->label('Latitude')
                            ->maxLength(20)
                            ->helperText('Contoh: -0.6638828813218716'),

                        Forms\Components\TextInput::make('longitude')
                            ->label('Longitude')
                            ->helperText('Contoh: 100.93693581443286'),

                        // Sosial Media
                        Forms\Components\TextInput::make('facebook')
                            ->label('Facebook')
                            ->url()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('twitter')
                            ->label('Twitter')
                            ->url()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('instagram')
                            ->label('Instagram')
                            ->url()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('youtube')
                            ->label('YouTube')
                            ->url()
                            ->maxLength(255),

                    ])
                    ->columns(2),

                // File Uploads Section
                Forms\Components\Section::make('File Upload')
                    ->schema([
                        Forms\Components\FileUpload::make('logo')
                            ->label('Logo Instansi')
                            ->image()
                            ->directory('pengaturan/logo')
                            ->disk('public')
                            ->visibility('public')
                            ->preserveFilenames()
                            ->imageResizeTargetWidth(300)
                            ->imageResizeTargetHeight(300)
                            ->imageResizeMode('contain')
                            ->helperText('Ukuran disarankan: 300x300px, format: PNG/JPG'),

                        Forms\Components\Select::make('active_theme')
                            ->label('Tema Website')
                            ->options([
                                'default' => 'Default (Original)',
                                'modern' => 'Modern (Custom Default)',
                            ])
                            ->default('default')
                            ->required()
                            ->selectablePlaceholder(false)
                            ->native(false),


                    ])
                    ->columns(2),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Components\Section::make('Identitas Instansi')
                    ->schema([
                        Components\ImageEntry::make('logo')
                            ->label('Logo Instansi')
                            ->height(100)
                            ->circular(),
                        Components\TextEntry::make('name')
                            ->label('Nama Instansi')
                            ->weight('bold')
                            ->size(Components\TextEntry\TextEntrySize::Large),
                        Components\TextEntry::make('kabupaten')
                            ->label('Kabupaten / Kota'),
                        Components\TextEntry::make('active_theme')
                            ->label('Tema Aktif')
                            ->badge()
                            ->color(fn(string $state): string => match ($state) {
                                'default' => 'gray',
                                'modern' => 'success',
                                default => 'gray',
                            }),
                    ])->columns(2),

                Components\Section::make('Informasi Kontak & Lokasi')
                    ->schema([
                        Components\TextEntry::make('alamat_instansi')
                            ->label('Alamat')
                            ->columnSpanFull(),
                        Components\TextEntry::make('email_instansi')
                            ->label('Email')
                            ->icon('heroicon-m-envelope'),
                        Components\TextEntry::make('no_telp_instansi')
                            ->label('Telepon')
                            ->icon('heroicon-m-phone'),
                        Components\TextEntry::make('latitude'),
                        Components\TextEntry::make('longitude'),
                    ])->columns(2),

                Components\Section::make('Pimpinan')
                    ->schema([
                        Components\ImageEntry::make('foto_pimpinan')
                            ->label('Foto Pimpinan')
                            ->height(150),
                        Components\TextEntry::make('kepala_instansi')
                            ->label('Nama Pimpinan')
                            ->weight('bold'),
                    ])->columns(2),

                Components\Section::make('Media Sosial')
                    ->schema([
                        Components\TextEntry::make('facebook')->icon('heroicon-o-globe-alt')->url(fn($record) => $record->facebook)->openUrlInNewTab(),
                        Components\TextEntry::make('twitter')->icon('heroicon-o-globe-alt')->url(fn($record) => $record->twitter)->openUrlInNewTab(),
                        Components\TextEntry::make('instagram')->icon('heroicon-o-globe-alt')->url(fn($record) => $record->instagram)->openUrlInNewTab(),
                        Components\TextEntry::make('youtube')->icon('heroicon-o-globe-alt')->url(fn($record) => $record->youtube)->openUrlInNewTab(),
                    ])->columns(4),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Instansi')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('kepala_instansi')
                    ->label('Nama Pimpinan')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\ImageColumn::make('foto_pimpinan')
                    ->defaultImageUrl(asset('images/no_image.png'))
                    ->label('Foto Pimpinan')
                    ->disk('public')
                    ->height(50)
                    ->circular(),


                Tables\Columns\TextColumn::make('email_instansi')
                    ->label('Email')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('no_telp_instansi')
                    ->searchable()
                    ->label('No. Telp')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('alamat_instansi')
                    ->searchable()
                    ->label('Alamat')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('latitude')
                    ->searchable()
                    ->label('Latitude')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('longitude')
                    ->searchable()
                    ->label('Longitude')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\ImageColumn::make('logo')
                    ->defaultImageUrl(asset('images/no_image.png'))
                    ->label('Logo')
                    ->disk('public')
                    ->height(30)
                    ->toggleable(isToggledHiddenByDefault: true),


                Tables\Columns\TextColumn::make('facebook')
                    ->searchable()
                    ->label('Facebook')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('twitter')
                    ->searchable()
                    ->label('Twitter')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('instagram')
                    ->searchable()
                    ->label('Instagram')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('youtube')
                    ->searchable()
                    ->label('Youtube')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\SelectColumn::make('active_theme')
                    ->label('Tema Website')
                    ->options([
                        'default' => 'Default (Original)',
                        'modern' => 'Modern (Custom Default)',
                    ])
                    ->selectablePlaceholder(false)
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Add any filters here
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
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Add any relation managers here
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPengaturans::route('/'),
            'create' => Pages\CreatePengaturan::route('/create'),
            'view' => Pages\ViewPengaturan::route('/{record}'),
            'edit' => Pages\EditPengaturan::route('/{record}/edit'),
        ];
    }
}
