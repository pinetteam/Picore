<?php

namespace App\Domain\Meeting\Pages;

use App\Domain\Meeting\Concerns\HasMeetingContext;
use App\Models\Meeting\Hall\Hall;
use Filament\Pages\Page;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Support\HtmlString;
use AymanAlhattami\FilamentPageWithSidebar\Traits\HasPageSidebar;
use AymanAlhattami\FilamentPageWithSidebar\FilamentPageSidebar;
use AymanAlhattami\FilamentPageWithSidebar\PageNavigationItem;

class HallManagementPage extends Page implements HasForms
{
    use InteractsWithForms;
    use HasPageSidebar;
    use HasMeetingContext;

    public $persistentSection;
    public $hallId;

    // Sayfa ayarları
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationLabel = 'Hall Management';

    // View ve slug tanımlaması
    protected static string $view = 'domain.meeting.hall-management';
    protected static ?string $slug = 'meeting-management/{meeting}/halls/{hall}/{action?}';
    protected static bool $shouldRegisterNavigation = false;

    protected ?string $maxContentWidth = "full";

    /**
     * Mount method
     */
    public function mount($meeting = null, $hall = null, $action = null): void
    {
        $this->initializeMeetingContext($meeting, 'halls');
        $this->hallId = $hall;
        $this->persistentSection = 'halls';
        $this->currentSection = 'halls'; // currentSection'ı da ayarla
    }

    // MeetingManagementPage ile aynı sidebar'ı kullan
    public static function sidebar(): FilamentPageSidebar
    {
        $instance = new static();
        $meetingId = request()->route('meeting') ?? $instance->getMeetingsQuery()->first()?->id;

        // Mevcut trait'teki getMeetingSections metodunu kullan
        $sections = $instance->getMeetingSections();
        $navigationItems = [];

        // Aktif bölümü belirle - hall yönetim sayfası için 'halls' kullan
        $activeSection = 'halls'; // Bu sayfada her zaman 'halls' aktif olacak

        foreach ($sections as $key => $section) {
            // URL oluştur
            $url = url("meeting-management/{$meetingId}/{$key}");

            $navigationItems[] = PageNavigationItem::make($section['label'])
                ->icon($section['icon'])
                ->url($url)
                ->group($section['group'])
                ->label($section['label'])
                ->visible(true)
                ->isActiveWhen(fn() => $key === $activeSection); // Sadece aktif bölüm için true döndür
        }

        return FilamentPageSidebar::make()
            ->sidebarNavigation()
            ->setNavigationItems($navigationItems);
    }

    public function getTitle(): string
    {
        $hall = Hall::find($this->hallId);
        $hallName = $hall ? $hall->title : 'Hall';

        return "Hall Management > {$hallName}";
    }

    // Hall içeriğini render et
    public function renderHallContent()
    {
        if (!$this->getSelectedMeeting()) {
            return new HtmlString('
                <div class="text-center p-6">
                    <p class="text-gray-500">Please select a meeting</p>
                </div>
            ');
        }

        if (!$this->hallId) {
            return new HtmlString('
                <div class="text-center p-6">
                    <p class="text-gray-500">Hall not found</p>
                </div>
            ');
        }

        $action = request()->route('action') ?: 'view';

        try {
            return view('domain.meeting.hall-sections.' . $action, [
                'meeting' => $this->getSelectedMeeting(),
                'hall' => Hall::find($this->hallId)
            ]);
        } catch (\Exception $e) {
            return new HtmlString('
                <div class="text-center p-6">
                    <p class="text-red-500">Template for this action not found: ' . $e->getMessage() . '</p>
                    <p class="text-gray-500 mt-2">Please create the file <code>resources/views/domain/meeting/hall-sections/' . $action . '.blade.php</code></p>
                </div>
            ');
        }
    }
}
