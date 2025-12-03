<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Товары')
                    ->schema([
                        RepeatableEntry::make('items')
                            ->schema([
                                ImageEntry::make('image')
                                    ->label('Фото')
                                    ->size(60) // <<< маленькая картинка
                                    ->circular(false), // можно убрать
                                TextEntry::make('title')->label('Название'),
                                TextEntry::make('qty')->label('Кол-во'),
                                TextEntry::make('price')->label('Цена'),
                            ])
                            ->columnSpanFull(),
                    ]),

                Section::make('Информация о клиенте')
                    ->schema([
                        TextEntry::make('name')->label('Имя'),
                        TextEntry::make('phone')->label('Телефон'),
                        TextEntry::make('email')->label('Email'),
                        TextEntry::make('total_price')->label('Сумма'),
                    ]),


            ]);
    }
}
