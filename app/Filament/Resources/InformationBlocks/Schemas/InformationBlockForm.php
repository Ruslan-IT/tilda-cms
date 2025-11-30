<?php

namespace App\Filament\Resources\InformationBlocks\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class InformationBlockForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Название')
                    ->required()
                    ->maxLength(255),
                Textarea::make('content')
                    ->label('Контент')
                    ->rows(20)
                    ->placeholder('Вставьте HTML прямо')
                    ->columnSpan('full'),
                FileUpload::make('image')
                    ->label('Изображение')
                    ->image()
                    ->directory('information-blocks')
                    ->maxSize(10240) // максимум 10MB
                    ->helperText('Можно загрузить одно изображение для блока (если оно есть в верстке)'),
            ]);
    }
}
