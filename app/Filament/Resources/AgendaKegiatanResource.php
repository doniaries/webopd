<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AgendaKegiatanResource\Pages;
use App\Filament\Resources\AgendaKegiatanResource\RelationManagers;
use App\Models\AgendaKegiatan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AgendaKegiatanResource extends Resource
{
    protected static ?string $model = AgendaKegiatan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $modelLabel = 'Agenda Kegiatan';
    protected static ?string $navigationGroup = 'Konten';
    protected static ?int $navigationSort = 3;



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Section 1: Informasi Dasar
                Forms\Components\Section::make('Informasi Dasar')
                    ->schema([
                        Forms\Components\TextInput::make('nama_agenda')
                            ->label('Nama Agenda')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Contoh: Rapat Koordinasi Bulanan')
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                $set('slug', \Illuminate\Support\Str::slug($state));
                            }),
                        Forms\Components\Hidden::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true),
                        Forms\Components\Textarea::make('uraian_agenda')
                            ->label('Uraian Kegiatan')
                            ->required()
                            ->placeholder('Deskripsi lengkap agenda kegiatan')
                            ->columnSpanFull(),
                    ])
                    ->columns(1),

                // Section 2: Detail Pelaksanaan
                Forms\Components\Section::make('Detail Pelaksanaan')
                    ->schema([
                        Forms\Components\TextInput::make('penyelenggara')
                            ->label('Penyelenggara')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Contoh: Dinas Komunikasi dan Informatika'),
                        Forms\Components\TextInput::make('tempat')
                            ->label('Tempat')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Contoh: Ruang Rapat Lt. 3'),
                    ])
                    ->columns(2),

                // Section 3: Waktu Pelaksanaan
                Forms\Components\Section::make('Waktu Pelaksanaan')
                    ->schema([
                        // Tanggal dan Waktu Mulai
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\DatePicker::make('dari_tanggal')
                                    ->label('Tanggal Mulai')
                                    ->required()
                                    ->native(false)
                                    ->displayFormat('d F Y')
                                    ->default(now()),
                                Forms\Components\TimePicker::make('waktu_mulai')
                                    ->label('Waktu Mulai')
                                    ->seconds(false)
                                    ->displayFormat('H:i')
                                    ->default(now()->format('H:00')),
                            ]),
                        
                        // Tanggal dan Waktu Selesai
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\DatePicker::make('sampai_tanggal')
                                    ->label('Tanggal Selesai')
                                    ->required()
                                    ->native(false)
                                    ->displayFormat('d F Y')
                                    ->afterOrEqual('dari_tanggal')
                                    ->default(fn ($get) => $get('dari_tanggal') ?? now()),
                                Forms\Components\TimePicker::make('waktu_selesai')
                                    ->label('Waktu Selesai')
                                    ->seconds(false)
                                    ->displayFormat('H:i')
                                    ->default(now()->addHour()->format('H:00')),
                            ]),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_agenda')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama_penyelenggara')
                    ->label('Penyelenggara')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tempat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('dari_tanggal')
                    ->label('Tanggal')
                    ->dateTime('d M Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('waktu_mulai')
                    ->label('Waktu')
                    ->time('H:i'),
                Tables\Columns\TextColumn::make('sampai_tanggal')
                    ->label('Sampai')
                    ->dateTime('d M Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('waktu_selesai')
                    ->label('Selesai')
                    ->time('H:i'),

                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListAgendaKegiatans::route('/'),
            'create' => Pages\CreateAgendaKegiatan::route('/create'),
            'edit' => Pages\EditAgendaKegiatan::route('/{record}/edit'),
        ];
    }
}
