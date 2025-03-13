<?php

namespace App\Domain\Meeting\Tables\Definitions;

use App\Models\Meeting\Announcement\Announcement;
use App\Models\Meeting\Meeting;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Actions\Action;
use Filament\Forms;
use Filament\Notifications\Notification;

class AnnouncementTableDefinition
{
    protected $meetingId;



    public function __construct(int $meetingId)
    {
        $this->meetingId = $meetingId;
    }

    public function getQuery()
    {
        return Announcement::query()->where('meeting_id', $this->meetingId);
    }

    public function getColumns(): array
    {
        return [
            TextColumn::make('title')
                ->label('Title')
                ->searchable()
                ->sortable(),
            TextColumn::make('status')
                ->label('Status')
                ->badge()
                ->formatStateUsing(fn ($state) => match ($state) {
                    1 => 'Active',
                    0 => 'Inactive',
                    default => 'Unknown'
                })
                ->color(fn ($state) => match ($state) {
                    1 => 'success',
                    0 => 'danger',
                    default => 'gray'
                })
                ->sortable(),
            IconColumn::make('is_published')
                ->label('Published')
                ->boolean()
                ->trueIcon('heroicon-o-check-circle')
                ->falseIcon('heroicon-o-x-circle')
                ->sortable(),
            TextColumn::make('publish_at')
                ->label('Publish At')
                ->dateTime('d.m.Y H:i')
                ->sortable(),
            TextColumn::make('created_at')
                ->label('Created At')
                ->dateTime('d.m.Y H:i')
                ->sortable(),
        ];
    }

    protected function getAnnouncementFormSchema(bool $isCreating = false): array
    {
        $schema = [];

        if ($isCreating) {
            $schema[] = Forms\Components\Hidden::make('meeting_id')
                ->default($this->meetingId);
        }

        $schema = array_merge($schema, [
            Forms\Components\TextInput::make('title')
                ->label('Title')
                ->required(),
            Forms\Components\Select::make('status')
                ->label('Status')
                ->options([
                    1 => 'Active',
                    0 => 'Passive',
                ])
                ->default(1)
                ->required(),
//            Forms\Components\Toggle::make('is_published')
//                ->label('Published')
//                ->onColor('success')
//                ->offColor('danger')
//                ->default(false)
//                ->visible(fn (string $context) => $context === 'edit'), // Sadece düzenleme modunda görünür
            Forms\Components\DateTimePicker::make('publish_at')
                ->label('Publish At')
                ->default(now()),
        ]);

        return $schema;
    }

    public function getActions(): array
    {
        return [
            Action::make('edit')
                ->label('Edit')
                ->icon('heroicon-o-pencil')
                ->color('warning')
                ->modalHeading('Edit Announcement')
                ->modalWidth('lg')
                ->form($this->getAnnouncementFormSchema())
                ->fillForm(fn (Announcement $record) => $record->toArray())
                ->action(function (Announcement $record, array $data) {
                    $record->update($data);
                    Notification::make()
                        ->title('Announcement updated successfully')
                        ->success()
                        ->send();
                }),
            Action::make('delete')
                ->label('Delete')
                ->icon('heroicon-o-trash')
                ->color('danger')
                ->requiresConfirmation()
                ->action(fn (Announcement $record) => $record->delete()),
        ];
    }

    public function getHeaderActions(): array
    {
        return [
            Action::make('create')
                ->label('Add Announcement')
                ->icon('heroicon-o-plus')
                ->color('primary')
                ->modalHeading('Add New Announcement')
                ->modalWidth('lg')
                ->form($this->getAnnouncementFormSchema(true))
                ->action(function (array $data) {
                    Announcement::create($data);
                    Notification::make()
                        ->title('Announcement added successfully')
                        ->success()
                        ->send();
                }),
        ];
    }

    public function getModelLabel(): string
    {
        return 'Announcement';
    }

    public function getPluralModelLabel(): string
    {
        return 'Announcements';
    }
}
