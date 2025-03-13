<?php

namespace App\Domain\Meeting\Tables\Definitions;

use App\Models\Meeting\Participant\Participant;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Actions\Action;
use Filament\Forms;
use Filament\Notifications\Notification;
use LaraZeus\Qr\Facades\Qr;



class ParticipantTableDefinition
{
    protected $meetingId;

    public function __construct(int $meetingId)
    {
        $this->meetingId = $meetingId;
    }

    public function getQuery()
    {
        return Participant::query()->where('meeting_id', $this->meetingId);
    }

    public function getColumns(): array
    {
        return [
            TextColumn::make('first_name')
                ->label('First Name')
                ->searchable()
                ->sortable(),
            TextColumn::make('last_name')
                ->label('Last Name')
                ->searchable()
                ->sortable(),
            TextColumn::make('email')
                ->label('Email')
                ->searchable()
                ->sortable(),
            TextColumn::make('phone')
                ->label('Phone')
                ->searchable()
                ->sortable(),
            TextColumn::make('type')
                ->label('Type')
                ->searchable()
                ->sortable(),
            TextColumn::make('organisation')
                ->label('Organisation')
                ->searchable()
                ->sortable(),

            IconColumn::make('enrolled')
                ->label('Enrolled')
                ->boolean()
                ->trueIcon('heroicon-o-check-circle')
                ->falseIcon('heroicon-o-x-circle')
                ->sortable(),

            TextColumn::make('status')
                ->label('Status')
                ->badge()
                ->formatStateUsing(fn ($state) => match ($state) {
                    1 => 'Active',
                    0 => 'Passive',
                    default => 'Unknown'
                }),

        ];
    }

    public function getActions(): array
    {
        return [

            Action::make('qrCode')
                ->label('QR Code')
                ->icon('heroicon-o-qr-code')
                ->color('success')
                ->fillForm(fn(Participant $record) => [
                    'qr-options' => Qr::getDefaultOptions(),
                    'qr-data' => $record->username,
                ])
                ->form(Qr::getFormSchema('qr-data', 'qr-options'))
                ->modalHeading('Participant QR Code')
                ->action(function ($data) {
                    // Bu noktada QR kodu zaten gösterilmiş olacak
                    // Ek bir işlem yapmak isterseniz burada yapabilirsiniz
                }),

            Action::make('edit')
                ->label('Edit')
                ->icon('heroicon-o-pencil')
                ->color('warning')
                ->modalHeading('Edit Participant')
                ->modalWidth('lg')
                ->form($this->getParticipantFormSchema())
                ->fillForm(fn (Participant $record) => $record->toArray())
                ->action(function (Participant $record, array $data) {
                    // Enrolled durumu değiştiyse ve true olmuşsa enrolled_at'i güncelle
                    if ($data['enrolled'] == true && $record->enrolled == false) {
                        $data['enrolled_at'] = now();
                    }

                    $record->update($data);
                    Notification::make()
                        ->title('Participant updated successfully')
                        ->success()
                        ->send();
                }),
            Action::make('delete')
                ->label('Delete')
                ->icon('heroicon-o-trash')
                ->color('danger')
                ->requiresConfirmation()
                ->action(fn (Participant $record) => $record->delete()),


        ];
    }

    public function getHeaderActions(): array
    {
        return [
            Action::make('create')
                ->label('Add Participant')
                ->icon('heroicon-o-plus')
                ->color('primary')
                ->modalHeading('Add New Participant')
                ->modalWidth('lg')
                ->form($this->getParticipantFormSchema(true))
                ->action(function (array $data) {
                    do {
                        $username = str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
                    } while (Participant::where('username', $username)->exists());

                    $data['username'] = $username;

                    Participant::create($data);
                    Notification::make()
                        ->title('Participant added successfully')
                        ->success()
                        ->send();
                }),
        ];
    }

    protected function getParticipantFormSchema(bool $isCreating = false): array
    {
        $schema = [];

        if ($isCreating) {
            $schema[] = Forms\Components\Hidden::make('meeting_id')
                ->default($this->meetingId);
        }

        $schema = array_merge($schema, [
            Forms\Components\TextInput::make('first_name')
                ->label('First Name')
                ->required(),
            Forms\Components\TextInput::make('last_name')
                ->label('Last Name')
                ->required(),
            Forms\Components\TextInput::make('email')
                ->label('Email')
                ->email()
                ->required(),
            Forms\Components\TextInput::make('phone')
                ->label('Phone'),
            Forms\Components\TextInput::make('password')
                ->label('Password')
                ->required(),
            Forms\Components\TextInput::make('organisation')
                ->label('Organisation'),

            Forms\Components\Toggle::make('enrolled')
                ->label('Enrolled')
                ->onColor('success')
                ->offColor('danger')
                ->default(false),
            Forms\Components\Select::make('status')
                ->label('Status')
                ->options([
                    1 => 'Active',
                    0 => 'Passive',
                ])
                ->default(1)

            ,

            Forms\Components\Select::make('type')
                ->label('Type')
                ->options([
                    'agent' => 'Agent',
                    'attendee' => 'Attendee',
                    'team' => 'Team',
                ])
                ->placeholder('Choose...'),
        ]);

        return $schema;
    }

    public function getModelLabel(): string
    {
        return 'Participant';
    }

    public function getPluralModelLabel(): string
    {
        return 'Participants';
    }
}
