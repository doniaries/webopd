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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PengaturanResource extends Resource
{
    protected static ?string $model = Pengaturan::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'Setting';
    protected static ?string $modelLabel = 'Pengaturan';
    protected static ?string $pluralModelLabel = 'Pengaturan';
    protected static ?string $navigationGroup = 'Pengaturan';
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
                            ->maxLength(255),

                        Forms\Components\TextInput::make('no_telp_instansi')
                            ->label('Nomor Telepon')
                            ->tel()
                            ->maxLength(20),

                        Forms\Components\TextInput::make('email_instansi')
                            ->label('Email Instansi')
                            ->email()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        Forms\Components\TextInput::make('alamat_instansi')
                            ->label('Alamat Instansi')
                            ->required()
                            ->maxLength(255),

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

                        Forms\Components\FileUpload::make('favicon')
                            ->label('Favicon')
                            ->image()
                            ->directory('pengaturan/favicon')
                            ->disk('public')
                            ->visibility('public')
                            ->preserveFilenames()
                            ->imageResizeTargetWidth(64)
                            ->imageResizeTargetHeight(64)
                            ->imageResizeMode('contain')
                            ->helperText('Ukuran disarankan: 64x64px, format: ICO/PNG')
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Website')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email_instansi')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('no_telp_instansi')
                    ->searchable()
                    ->label('No. Telp'),
                Tables\Columns\TextColumn::make('alamat_instansi')
                    ->searchable()
                    ->label('Alamat'),
                Tables\Columns\TextColumn::make('latitude')
                    ->searchable()
                    ->label('Latitude'),
                Tables\Columns\TextColumn::make('longitude')
                    ->searchable()
                    ->label('Longitude'),

                Tables\Columns\TextColumn::make('logo_instansi')
                    ->searchable()
                    ->label('Logo'),
                Tables\Columns\TextColumn::make('favicon_instansi')
                    ->searchable()
                    ->label('Favicon'),
                Tables\Columns\TextColumn::make('facebook')
                    ->searchable()
                    ->label('Facebook'),
                Tables\Columns\TextColumn::make('twitter')
                    ->searchable()
                    ->label('Twitter'),
                Tables\Columns\TextColumn::make('instagram')
                    ->searchable()
                    ->label('Instagram'),
                Tables\Columns\TextColumn::make('youtube')
                    ->searchable()
                    ->label('Youtube'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Add any filters here
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
            // Add any relation managers here
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPengaturans::route('/'),
            'create' => Pages\CreatePengaturan::route('/create'),
            'edit' => Pages\EditPengaturan::route('/{record}/edit'),
        ];
    }
}
