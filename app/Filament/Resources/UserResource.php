<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Facades\Filament;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Hash;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rules\Password;
use App\Filament\Resources\UserResource\Pages;
use Filament\Tables\Enums\ActionsPosition;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use STS\FilamentImpersonate\Tables\Actions\Impersonate;
use App\Filament\Resources\UserResource\RelationManagers\RolesRelationManager;


class UserResource extends Resource
{
    protected static ?string $model = User::class;


    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Users';
    protected static ?string $pluralNavigationLabel = 'Users';
    protected static ?string $slug = 'users';
    protected static ?string $pluralSlug = 'users';

    public static function getNavigationGroup(): ?string
    {
        return 'Pengaturan';
    }


    public static function shouldRegister(): bool
    {
        return auth()->user()?->hasAnyRole(['super_admin', 'admin']) ?? false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Akun')
                    ->description('Pengaturan akun dan hak akses')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama')
                            ->prefixIcon('heroicon-o-user')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->prefixIcon('heroicon-o-at-symbol')
                            ->email()
                            ->placeholder('xxxxxx@xxxx.xxx')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Forms\Components\TextInput::make('password')
                            ->label('Password')
                            ->revealable()
                            ->prefixIcon('heroicon-o-lock-closed')
                            ->password()
                            ->dehydrated(fn($state) => filled($state))
                            ->required(fn(string $context): bool => $context === 'create')
                            ->maxLength(255),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Status Aktif')
                            ->onIcon('heroicon-m-bolt')
                            ->offIcon('heroicon-m-user')
                            ->onColor('success')
                            ->offColor('danger')
                            ->inline(false)
                            ->default(true),
                        Forms\Components\Select::make('roles')
                            ->relationship('roles', 'name', function ($query) {
                                if (auth()->user()?->hasRole('super_admin')) {
                                    return $query;
                                }
                                return $query->whereNot('name', 'super_admin');
                            })
                            ->multiple()
                            ->preload()
                            ->searchable(),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(static::getEloquentQuery())
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->wrap()
                    ->colors(['warning'])
                    ->copyable()
                    ->searchable(),
                // Teams column removed
                Tables\Columns\TextColumn::make('roles.name')
                    ->label('Role')
                    ->badge()
                    ->color('success')
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Status User')
                    ->onColor('success')
                    ->offColor('danger')
                    ->visible(fn() => auth()->user()->hasRole('super_admin')),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('roles')
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->preload(),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status')
                    ->placeholder('Semua Status')
                    ->trueLabel('Aktif')
                    ->falseLabel('Non-Aktif'),
            ])
            ->actions([
                Impersonate::make(),
                Tables\Actions\Action::make('Change Password')
                    ->authorize('update')
                    ->label('Ganti Password')
                    ->icon('heroicon-o-key')
                    ->form([
                        Forms\Components\TextInput::make('password')
                            ->required()
                            ->revealable()
                            ->password()
                            ->rule(Password::default())
                            ->same('passwordConfirmation'),
                        Forms\Components\TextInput::make('passwordConfirmation')
                            ->required()
                            ->revealable()
                            ->password(),
                    ])
                    ->action(function (User $user, array $data) {
                        $user->update(['password' => Hash::make($data['password'])]);

                        Notification::make()
                            ->success()
                            ->title('Password Sukses Diganti')
                            ->send();
                    }),
                Tables\Actions\EditAction::make()
                    ->closeModalByClickingAway(false)
                    ->stickyModalFooter()
                    ->stickyModalHeader(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RolesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()
            ->select('users.*')
            ->with(['roles']);

        // Non-super admin tidak bisa melihat super admin
        if (!auth()->user()->hasRole('super_admin')) {
            $query->whereDoesntHave('roles', function (Builder $q) {
                $q->where('name', 'super_admin');
            });
        }

        return $query;
    }

    public static function getNavigationBadge(): ?string
    {
        $count = \Illuminate\Support\Facades\Cache::remember('filament.users.count', now()->addMinutes(5), function () {
            return static::getModel()::count();
        });

        return (string) $count;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        $count = \Illuminate\Support\Facades\Cache::remember('filament.users.count', now()->addMinutes(5), function () {
            return static::getModel()::count();
        });

        return $count < 5 ? 'warning' : 'danger';
    }
}
