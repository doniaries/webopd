<?php

namespace App\Filament\Resources\Shield\RoleResource\Forms;

use Filament\Forms;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Form;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Permission;

class RoleForm
{
    public static function get(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label(__('filament-shield::filament-shield.field.name'))
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('guard_name')
                            ->label(__('filament-shield::filament-shield.field.guard_name'))
                            ->default(config('filament.auth.guard'))
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Toggle::make('select_all')
                            ->onIcon('heroicon-s-shield-check')
                            ->offIcon('heroicon-s-shield-exclamation')
                            ->label(__('filament-shield::filament-shield.field.select_all.name'))
                            ->helperText(fn (): string => __('filament-shield::filament-shield.field.select_all.message'))
                            ->live()
                            ->afterStateUpdated(function ($livewire, $state) {
                                $permissions = Permission::all()->pluck('name')->toArray();
                                $livewire->form->getState()['permissions'] = $state ? $permissions : [];
                            })
                            ->dehydrated(fn ($state): bool => $state),
                    ]),
                Forms\Components\Tabs::make('Permissions')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make(__('filament-shield::filament-shield.tabs.all_permissions'))
                            ->visible(fn (): bool => true)
                            ->schema([
                                Forms\Components\Grid::make([
                                    'default' => 1,
                                    'lg' => 2,
                                ])
                                    ->schema(static::getResourceEntitiesSchema())
                                    ->columns([
                                        'sm' => 2,
                                        'lg' => 3,
                                    ]),
                            ]),
                    ])
                    ->columnSpan('full'),
            ]);
    }

    protected static function getResourceEntitiesSchema(): array
    {
        $permissions = Permission::all()
            ->groupBy(fn ($permission) => (string) str($permission->name)->beforeLast('.'))
            ->sortKeys();

        return $permissions->map(function (Collection $items, string $key) {
            return CheckboxList::make($key)
                ->label(ucfirst($key))
                ->options($items->pluck('name', 'id'))
                ->searchable()
                ->afterStateHydrated(function (CheckboxList $component, $state) use ($key) {
                    if (is_array($state)) {
                        $component->state(
                            collect($state)
                                ->filter(fn ($permission) => str_starts_with($permission, $key))
                                ->mapWithKeys(fn ($permission) => [
                                    (string) $permission => true,
                                ])
                                ->toArray()
                        );
                    }
                })
                ->dehydrated(fn ($state) => ! blank($state));
        })->values()->toArray();
    }
}
