<?php

namespace App\Filament\Resources\Categories\Schemas;

use App\Models\Category;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TagsInput;
use Illuminate\Support\Str;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Основная информация')
                    ->components([
                        Grid::make(2)->components([
                            TextInput::make('name')
                                ->label('Название')
                                ->required()
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug($state))),

                            TextInput::make('slug')
                                ->label('URL Slug')
                                ->required()
                                ->unique(Category::class, ignoreRecord: true),
                        ]),

                        Grid::make(2)->components([
                            Select::make('parent_id')
                                ->label('Родительская категория')
                                ->relationship('parent', 'name')
                                ->placeholder('Корневая'),

                            Select::make('type')
                                ->label('Тип данных')
                                ->options([
                                    'product' => 'Товары',
                                    'service' => 'Услуги',
                                    'job'     => 'Работа',
                                    'person'  => 'Знакомства',
                                    'asset'   => 'Активы',
                                ])
                                ->required(),
                        ]),
                    ]),

                Section::make('Настройки (Settings)')
                    ->components([
                        Grid::make(3)->components([
                            Toggle::make('settings.hide_price')->label('Скрыть цену'),
                            Toggle::make('settings.hide_location')->label('Скрыть локацию'),
                            Toggle::make('settings.hide_condition')->label('Скрыть сост.(б/у)'),
                        ]),
                        
                        TagsInput::make('settings.custom_fields')
                            ->label('Кастомные поля')
                            ->placeholder('Напр: материал'),
                    ]),
            ]);
    }
}
