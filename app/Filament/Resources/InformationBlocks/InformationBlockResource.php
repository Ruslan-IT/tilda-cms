<?php

namespace App\Filament\Resources\InformationBlocks;

use App\Filament\Resources\InformationBlocks\Pages\CreateInformationBlock;
use App\Filament\Resources\InformationBlocks\Pages\EditInformationBlock;
use App\Filament\Resources\InformationBlocks\Pages\ListInformationBlocks;
use App\Filament\Resources\InformationBlocks\Schemas\InformationBlockForm;
use App\Filament\Resources\InformationBlocks\Tables\InformationBlocksTable;
use App\Models\InformationBlock;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class InformationBlockResource extends Resource
{
    protected static ?string $model = InformationBlock::class;


    protected static ?string $navigationLabel = 'Инфо-блоки';
    protected static ?string $pluralModelLabel = 'Информационные блоки';
    protected static ?string $modelLabel = 'Инфо-блок';


    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return InformationBlockForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InformationBlocksTable::configure($table);
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
            'index' => ListInformationBlocks::route('/'),
            'create' => CreateInformationBlock::route('/create'),
            'edit' => EditInformationBlock::route('/{record}/edit'),
        ];
    }
}
