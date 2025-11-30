<?php

namespace App\Filament\Resources\SiteSettings\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SiteSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('site_name'),
                TextInput::make('telegram'),
                TextInput::make('whatsapp'),
                TextInput::make('phone')
                    ->tel(),
                TextInput::make('dzen'),
            ]);
    }
}
