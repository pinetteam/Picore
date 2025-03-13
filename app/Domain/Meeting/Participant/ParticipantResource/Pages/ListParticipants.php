<?php

namespace App\Domain\Meeting\Participant\ParticipantResource\Pages;

use App\Domain\Meeting\Participant\ParticipantResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListParticipants extends ListRecords
{
    protected static string $resource = ParticipantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
