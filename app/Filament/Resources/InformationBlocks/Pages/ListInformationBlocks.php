<?php

namespace App\Filament\Resources\InformationBlocks\Pages;

use App\Filament\Resources\InformationBlocks\InformationBlockResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListInformationBlocks extends ListRecords
{
    protected static string $resource = InformationBlockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
