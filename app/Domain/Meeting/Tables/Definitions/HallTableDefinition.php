<?php

namespace App\Domain\Meeting\Tables\Definitions;

use App\Models\Meeting\Hall\Hall;
use App\Models\Meeting\Meeting;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Actions\Action;
use Filament\Forms;
use Filament\Notifications\Notification;

class HallTableDefinition
{
    protected $meetingId;



    public function __construct(int $meetingId)
    {
        $this->meetingId = $meetingId;
    }

    public function getQuery()
    {
        return Hall::query()->where('meeting_id', $this->meetingId);
    }

    public function getColumns(): array
    {
        return [
            TextColumn::make('id')
                ->numeric()
                ->sortable(),
            TextColumn::make('meeting_id')
                ->numeric()
                ->sortable(),
//            TextColumn::make('code')
//                ->searchable(),
            TextColumn::make('title')
                ->searchable(),
            IconColumn::make('show_on_session')
                ->boolean(),
            IconColumn::make('show_on_view_program')
                ->boolean(),
            IconColumn::make('show_on_ask_question')
                ->boolean(),
            IconColumn::make('show_on_send_mail')
                ->boolean(),
            IconColumn::make('status')
                ->boolean(),
            TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),

        ];
    }

    protected function getHallFormSchema(bool $isCreating = false): array
    {
        $schema = [];

        // Her durumda meeting_id gizli olarak ekle
        $schema[] = Forms\Components\Hidden::make('meeting_id')
            ->default($this->meetingId);

        // Code alanını gizli olarak ekle ve UUID oluştur
        $schema[] = Forms\Components\Hidden::make('code')
            ->default(fn () => \Illuminate\Support\Str::uuid()->toString());

        // Diğer görünür alanları ekle
        $schema = array_merge($schema, [
            Forms\Components\TextInput::make('title')
                ->required()
                ->maxLength(511),
            Forms\Components\Toggle::make('show_on_session')
                ->required(),
            Forms\Components\Toggle::make('show_on_view_program')
                ->required(),
            Forms\Components\Toggle::make('show_on_ask_question')
                ->required(),
            Forms\Components\Toggle::make('show_on_send_mail')
                ->required(),
            Forms\Components\Toggle::make('status')
                ->required(),
            Forms\Components\TextInput::make('created_by')
                ->numeric(),
            Forms\Components\TextInput::make('updated_by')
                ->numeric(),
            Forms\Components\TextInput::make('deleted_by')
                ->numeric(),
        ]);

        return $schema;
    }

    public function getActions(): array
    {
        return [

            Action::make('view')
                ->label('Manage Hall')
                ->icon('heroicon-o-eye')
//                ->url(fn ($record) => route('domain.meeting.hall-sections.view', [
//                    'meeting' => $this->meetingId,
//                    'hall' => $record->id,
//                ])),
             ->url(fn ($record) => url("meeting-management/{$this->meetingId}/halls/{$record->id}/view")),

            Action::make('edit')
                ->label('Edit')
                ->icon('heroicon-o-pencil')
                ->color('warning')
                ->modalHeading('Edit Hall')
                ->modalWidth('lg')
                ->form($this->getHallFormSchema())
                ->fillForm(fn (Hall $record) => $record->toArray())
                ->action(function (Hall $record, array $data) {
                    $record->update($data);
                    Notification::make()
                        ->title('Hall updated successfully')
                        ->success()
                        ->send();
                }),
            Action::make('delete')
                ->label('Delete')
                ->icon('heroicon-o-trash')
                ->color('danger')
                ->requiresConfirmation()
                ->action(fn (Hall $record) => $record->delete()),
        ];
    }

    public function getHeaderActions(): array
    {
        return [
            Action::make('create')
                ->label('Add Hall')
                ->icon('heroicon-o-plus')
                ->color('primary')
                ->modalHeading('Add New Hall')
                ->modalWidth('lg')
                ->form($this->getHallFormSchema(true))
                ->action(function (array $data) {
                    Hall::create($data);
                    Notification::make()
                        ->title('Hall added successfully')
                        ->success()
                        ->send();
                }),
        ];
    }

    public function getModelLabel(): string
    {
        return 'Hall';
    }

    public function getPluralModelLabel(): string
    {
        return 'Halls';
    }
}
