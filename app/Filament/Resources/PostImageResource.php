<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostImageResource\Pages;
use App\Filament\Resources\PostImageResource\RelationManagers;
use App\Models\PostImage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PostImageResource extends Resource
{
    protected static ?string $model = PostImage::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Post Image';
    protected static ?string $modelLabel = 'Post Image';
    protected static ?int $navigationSort = 3;

    public static function getNavigationGroup(): ?string
    {
        return 'Konten';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\Section::make('Informasi Dasar')
                            ->description('Informasi dasar gambar')
                            ->schema([
                                Forms\Components\Hidden::make('team_id')
                                    ->default(fn() => auth()->user()->teams->first()?->id)
                                    ->dehydrated(),
                                Forms\Components\Select::make('post_id')
                                    ->label('Artikel')
                                    ->relationship('post', 'title', function ($query) {
                                        return $query->where('team_id', auth()->user()->teams->first()?->id);
                                    })
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                                Forms\Components\FileUpload::make('image_path')
                                    ->label('Gambar')
                                    ->image()
                                    ->imageEditor()
                                    ->directory('post-images')
                                    ->required(),
                            ])->columnSpan(1),
                            
                        Forms\Components\Section::make('Detail Gambar')
                            ->description('Informasi tambahan tentang gambar')
                            ->schema([
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
                                    ->helperText('Tandai sebagai gambar unggulan untuk ditampilkan di galeri')
                                    ->required(),
                            ])->columnSpan(1),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('team.name')
                    ->hidden(),
                Tables\Columns\ImageColumn::make('image_path')
                    ->label('Gambar')
                    ->circular(false)
                    ->square()
                    ->width(100)
                    ->height(80),
                Tables\Columns\TextColumn::make('post.title')
                    ->label('Artikel')
                    ->searchable()
                    ->sortable()
                    ->limit(40)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 40) {
                            return null;
                        }
                        return $state;
                    }),
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
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('post')
                    ->label('Artikel')
                    ->relationship('post', 'title', function ($query) {
                        return $query->where('team_id', auth()->user()->teams->first()?->id);
                    }),
                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Gambar Unggulan')
                    ->placeholder('Semua Gambar')
                    ->trueLabel('Hanya Unggulan')
                    ->falseLabel('Bukan Unggulan')
                    ->queries(
                        true: fn (Builder $query) => $query->where('is_featured', true),
                        false: fn (Builder $query) => $query->where('is_featured', false),
                        blank: fn (Builder $query) => $query,
                    ),
                Tables\Filters\Filter::make('created_at')
                    ->label('Tanggal Dibuat')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('Dari Tanggal'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
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
            'index' => Pages\ListPostImages::route('/'),
            'create' => Pages\CreatePostImage::route('/create'),
            'edit' => Pages\EditPostImage::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->when(!auth()->user()->hasRole('super_admin'), function ($query) {
                $query->where('team_id', auth()->user()->teams->first()?->id);
            });
    }
}
