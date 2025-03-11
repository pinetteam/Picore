<?php

namespace App\Domain\Meeting\Resources\MeetingResource\Pages;

use App\Domain\Meeting\Resources\MeetingResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMeeting extends CreateRecord
{
    protected static string $resource = MeetingResource::class;
}
