<?php

namespace App\Domain\Meeting\Resources\MeetingResource\Pages;

use App\Domain\Meeting\Resources\MeetingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMeeting extends EditRecord
{
    protected static string $resource = MeetingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ViewAction::make(),
        ];
    }
}
