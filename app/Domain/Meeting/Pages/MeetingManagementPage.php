<?php

namespace App\Domain\Meeting\Pages;

use App\Domain\Meeting\Concerns\HasMeetingContext;
use App\Domain\Meeting\Tables\Definitions\AnnouncementTableDefinition;
use App\Domain\Meeting\Tables\Definitions\DocumentTableDefinition;
use App\Domain\Meeting\Tables\Definitions\ParticipantTableDefinition;
use App\Domain\Meeting\Tables\Definitions\HallTableDefinition;
use Filament\Pages\Page;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Support\HtmlString;
use AymanAlhattami\FilamentPageWithSidebar\Traits\HasPageSidebar;
use AymanAlhattami\FilamentPageWithSidebar\FilamentPageSidebar;
use AymanAlhattami\FilamentPageWithSidebar\PageNavigationItem;


class MeetingManagementPage extends Page implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;
    use HasPageSidebar;
    use HasMeetingContext;
    public $persistentSection;


    // Navigation settings
    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-bar';
    protected static ?string $navigationLabel = 'Meeting Management';
    protected static ?string $navigationGroup = 'Meeting Management';
    protected static ?int $navigationSort = 1;

    // Blade view path
    protected static string $view = 'domain.meeting.meeting-dashboard';

    // URL structure with meeting ID and section parameters
    protected static ?string $slug = 'meeting-management/{meeting?}/{section?}';

    protected static ?string $title = null;
    protected static bool $shouldRegisterNavigation = false;

    protected ?string $maxContentWidth = "full";

    /**
     * Mount method to set meeting and section from URL
     */
    public function mount($meeting = null, $section = null): void
    {
        $this->initializeMeetingContext($meeting, $section);


        if ($this->selectedMeetingId && !$section) {
            $this->persistentSection = null; // veya 'overview', 'dashboard' gibi özel bir değer
        } else {
            $this->persistentSection = $section ?: 'general';
        }

    }

    // Sidebar (navigation) for filament-page-with-sidebar
    public static function sidebar(): FilamentPageSidebar
    {
        $instance = new static();
        $meetingId = request()->route('meeting') ?? $instance->getMeetingsQuery()->first()?->id;

        $sections = $instance->getMeetingSections();
        $navigationItems = [];

        foreach ($sections as $key => $section) {
            $navigationItems[] = PageNavigationItem::make($section['label'])
                ->icon($section['icon'])
                ->url(static::getUrl([
                    'meeting' => $meetingId,
                    'section' => $key
                ]))
                ->group($section['group'])
                ->label($section['label']) // Açık label tanımlaması

                ->visible(true) // Explicitly set visibility
                ->isActiveWhen(function () use ($key) {
                    $section = request()->route('section');


                    return $section === $key || (!$section && $key === 'general');
                });
        }

        return FilamentPageSidebar::make()
            ->sidebarNavigation( )
            ->setNavigationItems($navigationItems);
    }


    public function getTitle(): string
    {
        $sections = $this->getMeetingSections();

        // Önce route'dan bölüm bilgisini almaya çalış
        $routeSection = request()->route('section');

        // Eğer route'da bölüm bilgisi varsa, persistentSection'ı güncelle
        if ($routeSection && isset($sections[$routeSection])) {
            $this->persistentSection = $routeSection;
        }

        // Kalıcı bölüm değişkenini kullan
        $currentSection = $this->persistentSection ?: 'general';

        if (isset($sections[$currentSection])) {
            $section = $sections[$currentSection];

            // Toplantı ID'sini al
            $meetingId = request()->route('meeting') ?: $this->selectedMeetingId;

            return $meetingId
                ? "{$section['group']} > {$section['label']} ({$meetingId})"
                : "{$section['group']} > {$section['label']}";
        }

        return 'Toplantı Yönetimi';
    }

    // Get table definition based on current section
    protected function getTableDefinition()
    {
        if (!$this->selectedMeetingId) {
            return null;
        }

        if (!$this->persistentSection) {
            return null;
        }


        switch ($this->currentSection) {
            case 'general':
                return null;
            case 'announcements':
                return new AnnouncementTableDefinition($this->selectedMeetingId);
            case 'participants':
                return new ParticipantTableDefinition($this->selectedMeetingId);
            case 'documents':
                return new DocumentTableDefinition($this->selectedMeetingId);
            case 'halls':
                return  new HallTableDefinition($this->selectedMeetingId);
            case 'surveys':
                // Implement other table definitions as needed
                return null;
            default:
                return null;
        }
    }

    // Table query based on current section
    public function getTableQuery()
    {
        $definition = $this->getTableDefinition();

        if (!$definition) {
            // Boş bir sorgu döndür
            return \App\Models\User::query()->whereRaw('1 = 0');
            // veya toplantı ile ilgili bir model kullanın
            // return \App\Domain\Meeting\Models\Announcement::query()->whereRaw('1 = 0');
        }

        return $definition->getQuery();
    }

    // Table columns definition
    public function getTableColumns(): array
    {
        $definition = $this->getTableDefinition();
        return $definition ? $definition->getColumns() : [];
    }

    // Table actions definition
    public function getTableActions(): array
    {
        $definition = $this->getTableDefinition();
        return $definition ? $definition->getActions() : [];
    }

    // Table header actions definition
    public function getTableHeaderActions(): array
    {
        $definition = $this->getTableDefinition();
        return $definition ? $definition->getHeaderActions() : [];
    }

    // Get singular model label for table
    public function getTableModelLabel(): string
    {
        $definition = $this->getTableDefinition();
        return $definition ? $definition->getModelLabel() : '';
    }

    // Get plural model label for table
    public function getTablePluralModelLabel(): string
    {
        $definition = $this->getTableDefinition();
        return $definition ? $definition->getPluralModelLabel() : '';
    }

    // Empty state heading for table
    public function getTableEmptyStateHeading(): ?string
    {
        if (!$this->getSelectedMeeting()) {
            return 'Please select a meeting';
        }

        $sections = $this->getMeetingSections();
        $section = $this->currentSection;

        if (isset($sections[$section])) {
            return "No {$sections[$section]['label']} yet";
        }

        return null;
    }

    // Empty state description for table
    public function getTableEmptyStateDescription(): ?string
    {
        if (!$this->getSelectedMeeting()) {
            return 'After selecting a meeting, you can view its content.';
        }

        $sections = $this->getMeetingSections();
        $section = $this->currentSection;

        if (isset($sections[$section])) {
            return "No {$section} have been added for this meeting yet.";
        }

        return null;
    }

    // Empty state icon for table
    public function getTableEmptyStateIcon(): ?string
    {
        $sections = $this->getMeetingSections();
        return $sections[$this->currentSection]['icon'] ?? null;
    }

    // Render section content based on the current section
    public function renderSectionContent()
    {


        if (!$this->getSelectedMeeting()) {
            return new HtmlString('
                <div class="text-center p-6">
                    <p class="text-gray-500">Please select a meeting</p>
                </div>
            ');
        }

        // Section null ise bir overview sayfası göster
        if (!$this->persistentSection || $this->persistentSection === 'general') {
            return view('domain.meeting.meeting-sections.overview', [
                'meeting' => $this->getSelectedMeeting()
            ]);
        }

        try {
            return view('domain.meeting.meeting-sections.' . $this->currentSection, [
                'meeting' => $this->getSelectedMeeting()
            ]);
        } catch (\Exception $e) {
            return new HtmlString('
                <div class="text-center p-6">
                    <p class="text-red-500">Template for this section not found.</p>
                    <p class="text-gray-500 mt-2">Please create the file <code>resources/views/domain/meeting/meeting-sections/' . $this->currentSection . '.blade.php</code></p>
                </div>
            ');
        }
    }
}
