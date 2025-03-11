<?php

namespace App\Domain\Meeting\Resources\MeetingResource\Pages;

use App\Domain\Meeting\Resources\MeetingResource;
use App\Domain\Meeting\Pages\MeetingGridView;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMeetings extends ListRecords
{
    protected static string $resource = MeetingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('grid_view')
                ->label('Grid Görünümü')
                ->icon('heroicon-o-squares-2x2')
                ->url(MeetingGridView::getUrl())
                ->color('gray'),
        ];
    }
}
