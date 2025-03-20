<?php

namespace App\Domain\Meeting\Pages\Hall;

use \Carbon\Carbon;
use App\Domain\Meeting\Concerns\HasMeetingContext;
use App\Models\Meeting\Hall\Program\Program;
use App\Models\Meeting\Hall\Program\Session;
use App\Models\Meeting\Hall\Program\Debate;
use App\Models\Meeting\Hall\Hall;
use App\Models\System\Setting\Variable\Variable;
use Filament\Forms\Components\Hidden;
use Filament\Pages\Page;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use AymanAlhattami\FilamentPageWithSidebar\Traits\HasPageSidebar;
use AymanAlhattami\FilamentPageWithSidebar\FilamentPageSidebar;
use AymanAlhattami\FilamentPageWithSidebar\PageNavigationItem;

class HallProgram extends Page implements HasForms, HasActions
{
    use InteractsWithForms;
    use HasMeetingContext;
    use HasPageSidebar;
    use InteractsWithActions;

    public $hallId;
    public $persistentSection;
    public $expandedRows = [];
    public $programs = [];

    // View ve slug tanımlaması
    protected static string $view = 'domain.meeting.hall-program-custom';
    protected static ?string $slug = 'meeting-management/{meeting}/halls/{hall}/program/view';
    protected static bool $shouldRegisterNavigation = false;

    protected ?string $maxContentWidth = "full";

    /**
     * Mount method
     */
    public function mount($meeting = null, $hall = null): void
    {
        $this->initializeMeetingContext($meeting, 'halls');
        $this->hallId = $hall;
        $this->persistentSection = 'halls';

        // Programları yükle
        $this->loadPrograms();
    }

    /**
     * Programları yükle
     */
    public function loadPrograms()
    {
        $this->programs = Program::where('hall_id', $this->hallId)
            ->with(['sessions.speaker', 'sessions.document', 'debates'])
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * Sidebar tanımı
     */
    public static function sidebar(): FilamentPageSidebar
    {
        $instance = new static();
        $meetingId = request()->route('meeting') ?? $instance->getMeetingsQuery()->first()?->id;

        $sections = $instance->getMeetingSections();
        $navigationItems = [];

        $activeSection = 'halls';

        foreach ($sections as $key => $section) {
            $url = url("meeting-management/{$meetingId}/{$key}");

            $navigationItems[] = PageNavigationItem::make($section['label'])
                ->icon($section['icon'])
                ->url($url)
                ->group($section['group'])
                ->label($section['label'])
                ->visible(true)
                ->isActiveWhen(fn() => $key === $activeSection);
        }

        return FilamentPageSidebar::make()
            ->sidebarNavigation()
            ->setNavigationItems($navigationItems);
    }

    /**
     * Başlık metodu
     */
    public function getTitle(): string
    {
        $hall = Hall::find($this->hallId);
        $hallName = $hall ? $hall->title : 'Hall';

        return "Hall Program > {$hallName}";
    }

    /**
     * Tarih formatını alma
     */
    protected function getDateTimeFormat()
    {
        $customerId = auth()->check() ? auth()->user()->customer_id : null;
        $customerId = $customerId ?: Customer::first()->id;

        $timeFormatSetting = Variable::where('variable', 'time_format')->first()
            ->settings()->where('customer_id', $customerId)->first();
        $time_format = $timeFormatSetting && $timeFormatSetting->value == '24H' ? ' H:i' : ' g:i A';

        $dateFormatSetting = Variable::where('variable', 'date_format')->first()
            ->settings()->where('customer_id', $customerId)->first();
        $date_format = $dateFormatSetting ? $dateFormatSetting->value : 'd.m.Y';

        return $date_format . $time_format;
    }

    /**
     * Program satırını genişlet/daralt
     */
    public function toggleRow($rowId)
    {
        if (isset($this->expandedRows[$rowId])) {
            unset($this->expandedRows[$rowId]);
        } else {
            $this->expandedRows[$rowId] = true;
        }
    }

    /**
     * Program satırının genişletilmiş olup olmadığını kontrol et
     */
    public function isRowExpanded($rowId): bool
    {
        return true;
       // return isset($this->expandedRows[$rowId]);
    }

    public function testAction()
    {
        Notification::make()
            ->title('Test butonu çalışıyor 2 3!')
            ->success()
            ->send();
    }

    protected function getActions(): array
    {
        return [
            'add_program' => $this->addProgramAction(),
            'edit_program' => $this->editProgramAction(),
            'delete_program' => $this->deleteProgramAction(),
            'add_session' => $this->addSessionAction(),
         //   'edit_session' => $this->editSessionAction(),
           // 'delete_session' => $this->deleteSessionAction(),
            'add_debate' => $this->addDebateAction(),
           'edit_debate' => $this->editDebateAction(),
          'delete_debate' => $this->deleteDebateAction(),
        ];
    }

    public function addProgram()
    {
        $this->mountAction('add_program');
    }

    public function editProgram($programId)
    {
        $this->mountAction('edit_program', ['record' => $programId]);
    }

    public function deleteProgram($programId)
    {
        $this->mountAction('delete_program', ['record' => $programId]);
    }

    public function addSession($programId)
    {
        $this->mountAction('add_session', ['record' => $programId]);
    }

    public function editSession($sessionId)
    {
        $this->mountAction('edit_session', ['record' => $sessionId]);
    }

    public function deleteSession($sessionId)
    {
        $this->mountAction('delete_session', ['record' => $sessionId]);
    }

    public function addDebate($programId)
    {
        $this->mountAction('add_debate', ['record' => $programId]);
    }

    public function editDebate($debateId)
    {
        $this->mountAction('edit_debate', ['record' => $debateId]);
    }

    public function deleteDebate($debateId)
    {
        $this->mountAction('delete_debate', ['record' => $debateId]);
    }
    public function deleteDebateAction(): Action
    {
        return Action::make('delete_debate')
            ->label('Tartışmayı Sil')
            ->color('danger')
            ->requiresConfirmation()
            ->extraAttributes(['class' => 'hidden'])
            ->modalHeading('Tartışmayı Sil')
            ->modalDescription(function (array $arguments) {
                $debate = Debate\Debate::find($arguments['record']);
                return $debate ? "'{$debate->title}' başlıklı tartışmayı silmek istediğinizden emin misiniz?" : "Bu tartışmayı silmek istediğinizden emin misiniz?";
            })
            ->modalSubmitActionLabel('Evet, Sil')
            ->modalCancelActionLabel('İptal')
            ->action(function (array $arguments) {
                $debate = Debate\Debate::find($arguments['record']);

                if (!$debate) {
                    Notification::make()
                        ->title('Tartışma bulunamadı')
                        ->danger()
                        ->send();
                    return;
                }

                $debate->deleted_by = auth()->id();
                $debate->save();
                $debate->delete();

                // Programları yeniden yükle
                $this->loadPrograms();

                Notification::make()
                    ->title('Tartışma başarıyla silindi')
                    ->success()
                    ->send();
            });
    }
    public function editDebateAction(): Action
    {
        return Action::make('edit_debate')
            ->label('Tartışmayı Düzenle')
            ->modalWidth('lg')
            ->extraAttributes(['class' => 'hidden'])
            ->mountUsing(function (Forms\Form $form, array $arguments) {
                $debate = Debate\Debate::find($arguments['record']);

                if ($debate) {
                    $form->fill([
                        'sort_order' => $debate->sort_order,
                        'code' => $debate->code,
                        'title' => $debate->title,
                        'description' => $debate->description,
                        'status' => $debate->status,
                    ]);
                }
            })
            ->form([
                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\TextInput::make('sort_order')
                            ->label('Sıralama')
                            ->numeric()
                            ->default(0)
                            ->columnSpan(1),
                        Forms\Components\TextInput::make('code')
                            ->label('Kod')
                            ->maxLength(255)
                            ->columnSpan(1),
                        Forms\Components\TextInput::make('title')
                            ->label('Başlık')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(2),
                        Forms\Components\Textarea::make('description')
                            ->label('Açıklama')
                            ->maxLength(65535)
                            ->columnSpan(2),
                        Forms\Components\Toggle::make('status')
                            ->label('Aktif')
                            ->default(true)
                            ->columnSpan(1),
                    ])
                    ->columns(2),
            ])
            ->action(function (array $data, array $arguments) {
                $debate = Debate\Debate::find($arguments['record']);

                if (!$debate) {
                    Notification::make()
                        ->title('Tartışma bulunamadı')
                        ->danger()
                        ->send();
                    return;
                }

                $data['updated_by'] = auth()->id();
                $debate->update($data);

                // Programları yeniden yükle
                $this->loadPrograms();

                Notification::make()
                    ->title('Tartışma başarıyla güncellendi')
                    ->success()
                    ->send();
            });
    }

    /**
     * Program ekleme aksiyonu
     */
    public function addProgramAction(): Action
    {
        $date_time_format = $this->getDateTimeFormat();

        return Action::make('add_program')
            ->label('Program Ekle')

            ->extraAttributes(['class' => 'hidden'])

            ->modalWidth('lg')
            ->form([
                Forms\Components\Hidden::make('hall_id')
                    ->default($this->hallId),

                Forms\Components\Section::make('Program Bilgileri')
                    ->schema([
                        Forms\Components\Grid::make()
                            ->schema([
                                Forms\Components\TextInput::make('sort_order')
                                    ->label('Sıralama')
                                    ->numeric()
                                    ->default(0)
                                    ->columnSpan(1),
                                Forms\Components\TextInput::make('code')
                                    ->label('Kod')
                                    ->maxLength(255)
                                    ->columnSpan(1),
                                Forms\Components\TextInput::make('title')
                                    ->label('Başlık')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpan(2),
                                Forms\Components\Textarea::make('description')
                                    ->label('Açıklama')
                                    ->maxLength(65535)
                                    ->columnSpan(2),
                            ])
                            ->columns(2),
                    ]),

                Forms\Components\Section::make('Detaylar')
                    ->schema([
                        Forms\Components\Grid::make()
                            ->schema([
                                Forms\Components\FileUpload::make('logo')
                                    ->label('Logo')
                                    ->image()
                                    ->directory('program-logos')
                                    ->columnSpan(2),
                                Forms\Components\DateTimePicker::make('start_at')
                                    ->label('Başlangıç Tarihi')
                                    ->required()
                                    ->native(false)
                                    ->displayFormat($date_time_format)
                                    ->columnSpan(1),
                                Forms\Components\DateTimePicker::make('finish_at')
                                    ->label('Bitiş Tarihi')
                                    ->required()
                                    ->native(false)
                                    ->displayFormat($date_time_format)
                                    ->columnSpan(1),
                                Forms\Components\Select::make('type')
                                    ->label('Tür')
                                    ->options([
                                        'debate' => 'Tartışma',
                                        'session' => 'Oturum',
                                        'other' => 'Diğer',
                                    ])
                                    ->required()
                                    ->columnSpan(1),
                                Forms\Components\Toggle::make('status')
                                    ->label('Aktif')
                                    ->default(true)
                                    ->columnSpan(1),
                            ])
                            ->columns(2),
                    ]),
            ])
            ->action(function (array $data): void {
                if (isset($data['start_at'])) {
                    if (!$data['start_at'] instanceof \Carbon\Carbon) {
                        $data['start_at'] = Carbon::parse($data['start_at']);
                    }
                }

                if (isset($data['finish_at'])) {
                    if (!$data['finish_at'] instanceof \Carbon\Carbon) {
                        $data['finish_at'] = Carbon::parse($data['finish_at']);
                    }
                }

                $data['created_by'] = auth()->id();

                Program::create($data);

                // Programları yeniden yükle
                $this->loadPrograms();

                Notification::make()
                    ->title('Program başarıyla eklendi')
                    ->success()
                    ->send();
            });
    }


    /**
     * Program silme aksiyonu
     */
    public function deleteProgramAction(): Action
    {
        return Action::make('delete_program')
            ->label('Programı Sil')
            ->color('danger')
            ->extraAttributes(['class' => 'hidden'])
            ->requiresConfirmation()
            ->modalHeading('Programı Sil')
            ->modalDescription(function (array $arguments) {
                $record = Program::find($arguments['record'] ?? null);
                if ($record) {
                    return "'{$record->title}' başlıklı programı silmek istediğinizden emin misiniz?";
                }
                return "Bu programı silmek istediğinizden emin misiniz?";
            })
            ->modalSubmitActionLabel('Evet, Sil')
            ->modalCancelActionLabel('İptal')
            ->action(function (array $data, array $arguments) {
                $record = Program::find($arguments['record'] ?? null);

                if (!$record) {
                    Notification::make()
                        ->title('Hata')
                        ->body('Silinecek program bulunamadı.')
                        ->danger()
                        ->send();
                    return;
                }

                // Silme işlemi
                try {
                    // Programı sil
                    $record->delete();

                    // Programları yeniden yükle
                    $this->loadPrograms();

                    Notification::make()
                        ->title('Başarılı')
                        ->body('Program başarıyla silindi.')
                        ->success()
                        ->send();
                } catch (\Exception $e) {
                    Notification::make()
                        ->title('Hata')
                        ->body("Silme sırasında bir hata oluştu: " . $e->getMessage())
                        ->danger()
                        ->send();
                }
            });
    }

    /**
     * Program düzenleme aksiyonu
     */
    public function editProgramAction(): Action
    {
        $date_time_format = $this->getDateTimeFormat();

        return Action::make('edit_program')
            ->label('Programı Düzenle')
            ->modalWidth('lg')
            ->extraAttributes(['class' => 'hidden'])
            ->mountUsing(function (Forms\Form $form, array $arguments) {
                $record = Program::find($arguments['record']);

                if ($record) {
                    $form->fill([
                        'sort_order' => $record->sort_order,
                        'code' => $record->code,
                        'title' => $record->title,
                        'description' => $record->description,
                        'logo' => $record->logo,
                        'start_at' => $record->start_at,
                        'finish_at' => $record->finish_at,
                        'type' => $record->type,
                        'status' => $record->status,
                    ]);
                }
            })
//            ->fillForm(function (Program $record): array {
//                // Program verilerini form alanlarıyla eşleşecek şekilde döndür
//                if (!$record) {
//                    return []; // Eğer record null ise boş bir array döndür
//                }
//
//                return [
//                    'sort_order' => $record->sort_order,
//                    'code' => $record->code,
//                    'title' => $record->title,
//                    'description' => $record->description,
//                    'logo' => $record->logo,
//                    'start_at' => $record->start_at,
//                    'finish_at' => $record->finish_at,
//                    'type' => $record->type,
//                    'status' => $record->status,
//                ];
//            })
            ->form([
                Forms\Components\Section::make('Program Bilgileri')
                    ->schema([
                        Forms\Components\Grid::make()
                            ->schema([
                                Forms\Components\TextInput::make('sort_order')
                                    ->label('Sıralama')
                                    ->numeric()
                                    ->columnSpan(1),
                                Forms\Components\TextInput::make('code')
                                    ->label('Kod')
                                    ->maxLength(255)
                                    ->columnSpan(1),
                                Forms\Components\TextInput::make('title')
                                    ->label('Başlık')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpan(2),
                                Forms\Components\Textarea::make('description')
                                    ->label('Açıklama')
                                    ->maxLength(65535)
                                    ->columnSpan(2),
                            ])
                            ->columns(2),
                    ]),

                Forms\Components\Section::make('Detaylar')
                    ->schema([
                        Forms\Components\Grid::make()
                            ->schema([
                                Forms\Components\FileUpload::make('logo')
                                    ->label('Logo')
                                    ->image()
                                    ->directory('program-logos')
                                    ->columnSpan(2),
                                Forms\Components\DateTimePicker::make('start_at')
                                    ->label('Başlangıç Tarihi')
                                    ->required()
                                    ->native(false)
                                    ->displayFormat($date_time_format)
                                    ->columnSpan(1),
                                Forms\Components\DateTimePicker::make('finish_at')
                                    ->label('Bitiş Tarihi')
                                    ->required()
                                    ->native(false)
                                    ->displayFormat($date_time_format)
                                    ->columnSpan(1),
                                Forms\Components\Select::make('type')
                                    ->label('Tür')
                                    ->options([
                                        'debate' => 'Tartışma',
                                        'session' => 'Oturum',
                                        'other' => 'Diğer',
                                    ])
                                    ->required()
                                    ->columnSpan(1),
                                Forms\Components\Toggle::make('status')
                                    ->label('Aktif')
                                    ->default(true)
                                    ->columnSpan(1),
                            ])
                            ->columns(2),
                    ]),
            ])
            ->action(function (array $data, array $arguments) {
                $record = Program::find($arguments['record']);

                if (!$record) {
                    Notification::make()
                        ->title('Program bulunamadı')
                        ->danger()
                        ->send();
                    return;
                }

                if (isset($data['start_at'])) {
                    if (!$data['start_at'] instanceof \Carbon\Carbon) {
                        $data['start_at'] = Carbon::parse($data['start_at']);
                    }
                }

                if (isset($data['finish_at'])) {
                    if (!$data['finish_at'] instanceof \Carbon\Carbon) {
                        $data['finish_at'] = Carbon::parse($data['finish_at']);
                    }
                }

                $data['updated_by'] = auth()->id();
                $record->update($data);

                // Programları yeniden yükle
                $this->loadPrograms();

                Notification::make()
                    ->title('Program başarıyla güncellendi')
                    ->success()
                    ->send();
            });
    }


    /**
     * Oturum ekleme aksiyonu
     */
    public function addSessionAction(): Action
    {
        $date_time_format = $this->getDateTimeFormat();

        return Action::make('add_session')
            ->label('Oturum Ekle')
            ->modalWidth('lg')
            ->extraAttributes(['class' => 'hidden'])
            ->form([
                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\Select::make('speaker_id')
                            ->label('Konuşmacı')
                            ->relationship('speakers', 'name')
                            ->searchable()
                            ->preload()
                            ->columnSpan(1),
                        Forms\Components\Select::make('document_id')
                            ->label('Doküman')
                            ->relationship('documents', 'title')
                            ->searchable()
                            ->preload()
                            ->columnSpan(1),
                        Forms\Components\TextInput::make('sort_order')
                            ->label('Sıralama')
                            ->numeric()
                            ->default(0)
                            ->columnSpan(1),
                        Forms\Components\TextInput::make('code')
                            ->label('Kod')
                            ->maxLength(255)
                            ->columnSpan(1),
                        Forms\Components\TextInput::make('title')
                            ->label('Başlık')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(2),
                        Forms\Components\DateTimePicker::make('start_at')
                            ->label('Başlangıç Tarihi')
                            ->required()
                            ->native(false)
                            ->displayFormat($date_time_format)
                            ->columnSpan(1),
                        Forms\Components\DateTimePicker::make('finish_at')
                            ->label('Bitiş Tarihi')
                            ->required()
                            ->native(false)
                            ->displayFormat($date_time_format)
                            ->columnSpan(1),
                        Forms\Components\Toggle::make('questions_allowed')
                            ->label('Sorular Aktif')
                            ->default(true)
                            ->columnSpan(1),
                        Forms\Components\TextInput::make('questions_limit')
                            ->label('Soru Limiti')
                            ->numeric()
                            ->default(5)
                            ->columnSpan(1),
                        Forms\Components\Toggle::make('status')
                            ->label('Aktif')
                            ->default(true)
                            ->columnSpan(1),
                    ])
                    ->columns(2),
            ])
            ->action(function (array $arguments, array $data): void {
                $data['program_id'] = $arguments['record'];
                $data['created_by'] = auth()->id();

                Session::create($data);

                // Programları yeniden yükle
                $this->loadPrograms();

                Notification::make()
                    ->title('Oturum başarıyla eklendi')
                    ->success()
                    ->send();
            });
    }

    /**
     * Tartışma ekleme aksiyonu
     */
    public function addDebateAction(): Action
    {
        return Action::make('add_debate')
            ->label('Tartışma Ekle')
            ->modalWidth('lg')
            ->extraAttributes(['class' => 'hidden'])
            ->form([
                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\TextInput::make('sort_order')
                            ->label('Sıralama')
                            ->numeric()
                            ->default(0)
                            ->columnSpan(1),
                        Forms\Components\TextInput::make('code')
                            ->label('Kod')
                            ->maxLength(255)
                            ->columnSpan(1),
                        Forms\Components\TextInput::make('title')
                            ->label('Başlık')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(2),
                        Forms\Components\Textarea::make('description')
                            ->label('Açıklama')
                            ->maxLength(65535)
                            ->columnSpan(2),
                        Forms\Components\Toggle::make('status')
                            ->label('Aktif')
                            ->default(true)
                            ->columnSpan(1),
                    ])
                    ->columns(2),
            ])
            ->action(function (array $arguments, array $data): void {
                $data['program_id'] = $arguments['record'];
                $data['created_by'] = auth()->id();

                Debate\Debate::create($data);

                // Programları yeniden yükle
                $this->loadPrograms();

                Notification::make()
                    ->title('Tartışma başarıyla eklendi')
                    ->success()
                    ->send();
            });
    }
}
