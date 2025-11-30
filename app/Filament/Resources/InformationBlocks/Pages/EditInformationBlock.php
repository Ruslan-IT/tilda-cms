<?php

namespace App\Filament\Resources\InformationBlocks\Pages;

use App\Filament\Resources\InformationBlocks\InformationBlockResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditInformationBlock extends EditRecord
{
    protected static string $resource = InformationBlockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
