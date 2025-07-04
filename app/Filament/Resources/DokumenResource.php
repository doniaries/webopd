<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DokumenResource\Pages;
use App\Models\Dokumen;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Support\Colors\Color;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Filament\Actions\StaticAction;

class DokumenResource extends Resource
{
    protected static ?string $model = Dokumen::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $modelLabel = 'Dokumen';
    protected static ?string $navigationLabel = 'Dokumen';
    protected static ?string $navigationGroup = 'Konten';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Dokumen')
                    ->schema([
                        Forms\Components\TextInput::make('nama_dokumen')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                                if ($operation === 'edit') {
                                    return;
                                }
                                $set('slug', Str::slug($state));
                            })
                            ->label('Nama Dokumen'),

                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->disabledOn('edit')
                            ->dehydrated()
                            ->label('Slug (URL)'),

                        Forms\Components\DatePicker::make('tahun_terbit')
                            ->required()
                            ->label('Tahun Terbit')
                            ->default(now()),

                        Forms\Components\DatePicker::make('published_at')
                            ->label('Tanggal Publikasi')
                            ->default(now()),

                        Forms\Components\Textarea::make('deskripsi')
                            ->label('Deskripsi')
                            ->columnSpanFull()
                            ->rows(3),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('File Dokumen')
                    ->schema([
                        Forms\Components\FileUpload::make('file')
                            ->label('File PDF')
                            ->directory('dokumen')
                            ->acceptedFileTypes(['application/pdf'])
                            ->downloadable()
                            ->visibility('public')
                            ->openable()
                            ->previewable()
                            ->panelLayout('grid')
                            ->preserveFilenames()
                            ->uploadingMessage('Sedang mengunggah...')
                            ->uploadProgressIndicatorPosition('left')
                            ->columnSpanFull()
                            ->helperText('Unggah file dokumen dalam format PDF (maks. 10MB)'),

                        Forms\Components\FileUpload::make('cover')
                            ->label('Cover Dokumen')
                            ->directory('dokumen/covers')
                            ->image()
                            ->imageEditor()
                            ->columnSpanFull()
                            ->helperText('Unggah gambar cover dokumen (opsional)'),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_dokumen')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->description(fn(Dokumen $record) => $record->tahun_terbit?->format('Y')),

                Tables\Columns\TextColumn::make('views')
                    ->label('Dilihat')
                    ->numeric()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('file')
                    ->label('File')
                    ->searchable()
                    ->tooltip('Klik untuk melihat')
                    ->alignCenter()
                    ->icon('heroicon-m-document')
                    ->color(Color::Green)
                    ->formatStateUsing(fn($state) => !empty($state) ? 'Lihat' : '-')
                    ->action(
                        Tables\Actions\Action::make('previewFile')
                            ->modalHeading('Preview Dokumen')
                            ->modalWidth('4xl')
                            ->modalSubmitAction(false)
                            ->stickyModalHeader() //header tidak hilang ketika scroll
                            // ->modalWidth(MaxWidth::FiveExtraLarge)
                            ->stickyModalFooter()
                            ->modalCancelAction(fn(StaticAction $action) => $action->label('Tutup'))
                            ->modalCancelActionLabel('Tutup')
                            ->modalContent(function ($record) {
                                if (empty($record->file)) {
                                    return 'No files available';
                                }

                                $files = collect($record->file)->map(function ($file) {
                                    return [
                                        'url' => Storage::url($file),
                                        'filename' => basename($file)
                                    ];
                                });

                                return view('filament.components.file-viewer', [
                                    'files' => $files
                                ]);
                            })
                    ),

                Tables\Columns\TextColumn::make('downloads')
                    ->label('Diunduh')
                    ->numeric()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('published_at')
                    ->label('Tgl. Publikasi')
                    ->date('d M Y')
                    ->sortable()
                    ->toggleable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('tahun_terbit')
                    ->options(fn() => Dokumen::query()
                        ->selectRaw('YEAR(tahun_terbit) as year')
                        ->distinct()
                        ->orderBy('year', 'desc')
                        ->pluck('year', 'year'))
                    ->label('Tahun Terbit'),
            ])
            ->actions([

                // Tables\Actions\ViewAction::make(),
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDokumens::route('/'),
            'create' => Pages\CreateDokumen::route('/create'),
            'edit' => Pages\EditDokumen::route('/{record}/edit'),
        ];
    }
}
