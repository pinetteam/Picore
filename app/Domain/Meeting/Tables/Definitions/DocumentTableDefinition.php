<?php

namespace App\Domain\Meeting\Tables\Definitions;

use App\Models\Meeting\Document\Document;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Actions\Action;
use Filament\Forms;
use Filament\Notifications\Notification;
use Illuminate\Support\HtmlString;
class DocumentTableDefinition
{
    protected $meetingId;

    public function __construct(int $meetingId)
    {
        $this->meetingId = $meetingId;
    }

    public function getQuery()
    {
        return Document::query()->where('meeting_id', $this->meetingId);
    }

    public function getColumns(): array
    {
        return [
            TextColumn::make('title')
                ->label('Title')
                ->searchable()
                ->sortable(),
            TextColumn::make('file_name')
                ->label('File Name')
                ->searchable(),
            TextColumn::make('file_extension')
                ->label('Type')
                ->badge(),
            TextColumn::make('file_size')
                ->label('Size')
                ->formatStateUsing(fn ($state) => $state ? round($state / 1024, 2) . ' KB' : '-'),
            IconColumn::make('is_public')
                ->label('Public')
                ->boolean()
                ->trueIcon('heroicon-o-check-circle')
                ->falseIcon('heroicon-o-x-circle')
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
//            TextColumn::make('created_at')
//                ->label('Created At')
//                ->dateTime('d.m.Y H:i')
//                ->sortable(),
        ];
    }

    protected function getDocumentFormSchema(bool $isCreating = false): array
    {
        $schema = [];

        if ($isCreating) {
            $schema[] = Forms\Components\Hidden::make('meeting_id')
                ->default($this->meetingId);
        }

        $schema = array_merge($schema, [
            Forms\Components\FileUpload::make('file_name')
                ->label('Document File')
                ->required($isCreating)
                ->disk('public')
                ->directory('documents')
                ->preserveFilenames()
                ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'image/*'])
                ->columnSpanFull(),
            Forms\Components\TextInput::make('title')
                ->label('Title')
                ->required(),
//            Forms\Components\Textarea::make('description')
//                ->label('Description')
//                ->rows(3)
//                ->columnSpanFull(),
            Forms\Components\Toggle::make('is_public')
                ->label('Public Document')
                ->helperText('If enabled, this document will be visible to all participants')
                ->onColor('success')
                ->offColor('danger')
                ->default(false),
            Forms\Components\Select::make('status')
                ->label('Status')
                ->options([
                    1 => 'Active',
                    0 => 'Inactive',
                ])
                ->default(1)
                ->required(),
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
                ->modalHeading('Edit Document')
                ->modalWidth('lg')
                ->form($this->getDocumentFormSchema())
                ->fillForm(fn (Document $record) => $record->toArray())
                ->action(function (Document $record, array $data) {
                    // Handle file upload if a new file is uploaded
                    if (isset($data['file_name']) && $data['file_name'] !== $record->file_name) {
                        // Optionally extract file extension and size from the uploaded file
                        if (is_string($data['file_name']) && file_exists(storage_path('app/public/' . $data['file_name']))) {
                            $pathInfo = pathinfo($data['file_name']);
                            $data['file_extension'] = $pathInfo['extension'] ?? null;
                            $data['file_size'] = filesize(storage_path('app/public/' . $data['file_name']));
                        }
                    }

                    $record->update($data);
                    Notification::make()
                        ->title('Document updated successfully')
                        ->success()
                        ->send();
                }),
             Action::make('view_document')
                 ->label('Görüntüle')
                 ->icon('heroicon-o-eye')
                 ->modalHeading(fn($record) => "{$record->title} Belgesi")
                 ->modalContent(function ($record) {
                     $fileUrl = url('storage/' . $record->file_name);
                     $extension = strtolower($record->file_extension);

                     if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                         // Resim dosyaları için
                         $html = '<div class="flex justify-center items-center" style="min-height: 80vh;">
                            <img src="'.$fileUrl.'" alt="Belge" class="max-w-full max-h-[80vh] object-contain">
                        </div>';
                     } elseif ($extension === 'pdf') {
                         // PDF için iframe kullanımı - daha iyi görüntüleme sağlar
                         $html = '<div class="w-full" style="height: 80vh;">
                            <iframe src="'.$fileUrl.'" width="100%" height="100%"
                                style="border: none; min-height: 80vh;"></iframe>
                        </div>';
                     } else {
                         // Diğer dosya türleri için indirme linki
                         $html = '<div class="text-center p-8 flex flex-col justify-center" style="min-height: 50vh;">
                            <p class="mb-4">Bu belge türü doğrudan görüntülenemiyor.</p>
                            <div>
                                <a href="'.$fileUrl.'" download class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                    Belgeyi İndir
                                </a>
                            </div>
                        </div>';
                     }

                     return new HtmlString($html);
                 })
                 ->modalWidth('7xl'), // En geniş modal boyutu,
            Action::make('download')
                ->label('Download')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->url(fn (Document $record) => url('storage/' . $record->file_name))
                ->openUrlInNewTab(),
            Action::make('delete')
                ->label('Delete')
                ->icon('heroicon-o-trash')
                ->color('danger')
                ->requiresConfirmation()
                ->action(fn (Document $record) => $record->delete()),
        ];
    }

    public function getHeaderActions(): array
    {
        return [
            Action::make('create')
                ->label('Add Document')
                ->icon('heroicon-o-plus')
                ->color('primary')
                ->modalHeading('Add New Document')
                ->modalWidth('lg')
                ->form($this->getDocumentFormSchema(true))
                ->action(function (array $data) {
                    // Extract file extension and size from the uploaded file
                    if (isset($data['file_name']) && is_string($data['file_name']) && file_exists(storage_path('app/public/' . $data['file_name']))) {
                        $pathInfo = pathinfo($data['file_name']);
                        $data['file_extension'] = $pathInfo['extension'] ?? null;
                        $data['file_size'] = filesize(storage_path('app/public/' . $data['file_name']));
                    }

                    Document::create($data);
                    Notification::make()
                        ->title('Document added successfully')
                        ->success()
                        ->send();
                }),
        ];
    }

    public function getModelLabel(): string
    {
        return 'Document';
    }

    public function getPluralModelLabel(): string
    {
        return 'Documents';
    }
}
