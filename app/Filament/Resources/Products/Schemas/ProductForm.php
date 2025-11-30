<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Название')
                    ->required(),
                TextInput::make('price')
                    ->label('Цена')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                TextInput::make('old_price')
                    ->label('Старая цена')
                    ->numeric()
                    ->prefix('$'),
                TextInput::make('sku')
                    ->label('Артикул')
                    ->required(),

                Textarea::make('full_description')
                    ->label('Описание дополнительное')
                    ->columnSpanFull(),
                FileUpload::make('image')
                    ->label('Фото')
                    ->image()
                    ->directory('products')
                    ->preserveFilenames()
                    ->nullable(),

                RichEditor::make('short_description')
                    ->label('Описание основное')
                    ->columnSpanFull()
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'strike',
                        'underline',
                        'bulletList',
                        'orderedList',
                        'link',
                        'blockquote',
                        'h2',
                        'h3',
                        'codeBlock',
                        'undo',
                        'redo',
                    ]),
            ]);
    }
}
