<?php

namespace App\Domain\Meeting\Participant\ParticipantResource\Pages;

use App\Domain\Meeting\Participant\ParticipantResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateParticipant extends CreateRecord
{
    protected static string $resource = ParticipantResource::class;
    protected static bool $canCreateAnother = false;

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
