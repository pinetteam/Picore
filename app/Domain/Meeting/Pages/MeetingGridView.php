<?php

namespace App\Domain\Meeting\Pages;

use App\Domain\Meeting\Models\Meeting;
use Filament\Pages\Page;
use Filament\Actions\Action;

class MeetingGridView extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static string $view = 'domain.meeting.pages.meeting-grid-view';

    protected static ?string $navigationGroup = 'Toplantı Yönetimi';

    protected static ?string $navigationLabel = 'Toplantı Grid Görünümü';

    protected static ?string $title = 'Toplantılar';

    protected static ?int $navigationSort = 1;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('create')
                ->label('Toplantı Oluştur')
                ->url(route('filament.admin.resources.meetings.create'))
                ->color('primary')
                ->icon('heroicon-o-plus'),
        ];
    }

    public function getMeetings()
    {
        return Meeting::with('customer')
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
