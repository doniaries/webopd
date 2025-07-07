<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use App\Models\Tag;

use App\Models\User;
use Spatie\Permission\Traits\HasRoles;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Facades\Filament;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationLabel = 'Postingan';
    protected static ?string $modelLabel = 'Postingan';
    protected static ?string $navigationGroup = 'Konten';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\Group::make()
                            ->schema([
                                Forms\Components\Section::make('Informasi Dasar')
                                    ->description('Judul dan konten artikel')
                                    ->schema([
                                        Forms\Components\TextInput::make('title')
                                            ->label('Judul')
                                            ->required()
                                            ->maxLength(255)
                                            ->live(onBlur: true)
                                            ->placeholder('Masukkan judul artikel di sini')
                                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                                $set('slug', \Illuminate\Support\Str::slug($state));
                                            }),
                                        Forms\Components\Hidden::make('slug')
                                            ->required()
                                            ->unique(ignoreRecord: true),
                                        Forms\Components\RichEditor::make('content')
                                            ->label('Isi Artikel')
                                            ->required()
                                            ->toolbarButtons([
                                                'blockquote',
                                                'bold',
                                                'bulletList',
                                                'codeBlock',
                                                'h2',
                                                'h3',
                                                'italic',
                                                'link',
                                                'orderedList',
                                                'redo',
                                                'strike',
                                                'underline',
                                                'undo',
                                            ])
                                            ->fileAttachmentsDisk('public')
                                            ->fileAttachmentsDirectory('uploads')
                                            ->columnSpanFull(),
                                    ])->columnSpan(['lg' => 3]),

                                Forms\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\Section::make('Foto Utama')
                                            ->description('Foto utama untuk thumbnail artikel')
                                            ->schema([
                                                Forms\Components\FileUpload::make('foto_utama')
                                                    ->label('Foto Utama')
                                                    ->helperText('Foto ini akan ditampilkan sebagai thumbnail artikel')
                                                    ->directory('foto-utama')
                                                    ->image()
                                                    ->imageEditor()
                                                    ->imageResizeMode('cover')
                                                    ->imageCropAspectRatio('16:9')
                                                    ->maxSize(2048),

                                            ])->columnSpan(1),
                                        Forms\Components\Section::make('Gambar Tambahan')
                                            ->description('Gambar tambahan untuk konten artikel')
                                            ->schema([
                                                Forms\Components\Repeater::make('postGallery')
                                                    ->relationship()
                                                    ->schema([
                                                        Forms\Components\FileUpload::make('image_path')
                                                            ->label('Gambar')
                                                            ->directory('post-gallery')
                                                            ->image()
                                                            ->required()
                                                            ->imageEditor()
                                                            ->imageResizeMode('cover')
                                                            ->optimize('webp')
                                                            ->maxSize(2048)
                                                            ->disk('public')
                                                            ->preserveFilenames(),
                                                    ])
                                                    ->columns(2)
                                                    ->columnSpanFull()
                                                    ->label('Galeri Gambar')
                                                    ->reorderable()
                                                    ->cloneable()
                                                    ->collapsible()
                                                    ->itemLabel(fn(array $state): ?string => 'Gambar')
                                                    ->createItemButtonLabel('Tambah Gambar')
                                                    ->defaultItems(0),
                                            ])->columnSpan(1),
                                    ])->columnSpan(['lg' => 3]),
                            ])->columnSpan(['lg' => 3]),

                        Forms\Components\Group::make()
                            ->schema([
                                Forms\Components\Section::make('Status Publikasi')
                                    ->description('Pengaturan status publikasi artikel')
                                    ->schema([
                                        Forms\Components\Select::make('status')
                                            ->options([
                                                'draft' => 'Draft',
                                                'published' => 'Dipublikasikan',
                                                'archived' => 'Diarsipkan'
                                            ])
                                            ->default('draft')
                                            ->required(),
                                        Forms\Components\DateTimePicker::make('published_at')
                                            ->label('Tanggal Publikasi')
                                            ->default(now())
                                            ->visible(fn(Forms\Get $get) => $get('status') === 'published'),
                                    ]),

                                Forms\Components\Section::make('Informasi Artikel')
                                    ->description('Informasi dasar artikel')
                                    ->schema([
                                        Forms\Components\Select::make('tags')
                                            ->relationship('tags', 'name')
                                            ->label('Tag')
                                            ->preload()
                                            ->multiple()
                                            ->searchable()
                                            ->saveRelationshipsUsing(function ($record, $state) {
                                                if (! $state) {
                                                    $record->tags()->detach();
                                                    return;
                                                }

                                                $record->tags()->sync($state);
                                            }),
                                        // User selection - only visible and changeable by super admin
                                        Forms\Components\Select::make('user_id')
                                            ->relationship('user', 'name')
                                            ->default(fn() => \Filament\Facades\Filament::auth()->id())
                                            ->dehydrated(),

                                        Forms\Components\Hidden::make('views')
                                            ->required()
                                            ->default(0),
                                    ]),
                            ])->columnSpan(['lg' => 1]),
                    ])->columns(['lg' => 4])
            ]);
    }



    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\ImageColumn::make('foto_utama_url')
                    ->label('Foto Utama')
                    ->circular(false)
                    ->square()
                    ->width(100)
                    ->height(60),
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->limit(50)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 50) {
                            return null;
                        }
                        return $state;
                    }),
                Tables\Columns\TextColumn::make('slug')
                    ->hidden(),
                Tables\Columns\TextColumn::make('tags.name')
                    ->label('Tag')
                    ->listWithLineBreaks()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Penulis')
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'danger' => 'draft',
                        'success' => 'published',
                        'warning' => 'archived',
                    ])
                    ->icons([
                        'heroicon-o-pencil' => 'draft',
                        'heroicon-o-check-circle' => 'published',
                        'heroicon-o-archive-box' => 'archived',
                    ]),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Tanggal Publikasi')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('views')
                    ->label('Dilihat')
                    ->numeric()
                    ->sortable(),
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
                Tables\Columns\TextColumn::make('deleted_at')
                    ->label('Dihapus')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('published_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Dipublikasikan',
                        'archived' => 'Diarsipkan',
                    ]),
                Tables\Filters\SelectFilter::make('tags')
                    ->label('Tag')
                    ->relationship('tags', 'name')
                    ->multiple()
                    ->searchable()
                    ->preload(),
                Tables\Filters\Filter::make('published_at')
                    ->label('Tanggal Publikasi')
                    ->form([
                        Forms\Components\DatePicker::make('published_from')
                            ->label('Dari Tanggal'),
                        Forms\Components\DatePicker::make('published_until')
                            ->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['published_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('published_at', '>=', $date),
                            )
                            ->when(
                                $data['published_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('published_at', '<=', $date),
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

    public static function afterCreate(Post $record, array $data): void
    {
        if (isset($data['postGallery'])) {
            $record->postGallery()->createMany($data['postGallery']);
        }
    }

    public static function afterEdit(Post $record, array $data): void
    {
        if (isset($data['postGallery'])) {
            $record->postGallery()->delete();
            $record->postGallery()->createMany($data['postGallery']);
        }
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        if (Filament::auth()->check()) {
            $user = Filament::auth()->user();

            // If user is not super admin, only show their own posts
            if ($user) {
                $isSuperAdmin = method_exists($user, 'hasRole') ? $user->hasRole('super_admin') : false;
                if (!$isSuperAdmin) {
                    $query->where('user_id', $user->id);
                }
            }
        }

        return $query->withoutGlobalScopes([
            SoftDeletingScope::class,
        ]);
    }
}
