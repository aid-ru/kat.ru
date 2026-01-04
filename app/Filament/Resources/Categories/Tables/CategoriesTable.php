<?php

namespace App\Filament\Resources\Categories\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;

class CategoriesTable
{
    public static function make(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Название')
                    ->sortable()
                    ->searchable(),
                
                TextColumn::make('parent.name')
                    ->label('Родитель'),
                
                TextColumn::make('type')
                    ->label('Тип')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'product' => 'info',
                        'service' => 'success',
                        'job' => 'warning',
                        'person' => 'danger',
                        default => 'gray',
                    }),

                IconColumn::make('settings.hide_price')
                    ->label('Без цены')
                    ->boolean()
                    ->state(fn ($record) => $record->settings['hide_price'] ?? false),
/*
                IconColumn::make('settings.hide_price')
                    ->label('Без цены')
                    ->boolean(),
*/
            ])
            ->filters([
                // Здесь можно добавить фильтр по типу
            ]);
    }

    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
