<?php

namespace App\Domain\Meeting\Concerns;

use App\Models\Meeting\Meeting;
use Illuminate\Database\Eloquent\Builder;

trait HasMeetingContext
{
    public $selectedMeetingId = null;
    public $currentSection = 'general';

    protected function getMeetingSections(): array
    {
        return [
            // Hazırlık ve Yönetim grubu
            'general' => [
                'label'       => 'Genel Bilgiler',
                'icon'        => 'heroicon-o-information-circle',
                'description' => 'Toplantı genel bilgileri',
                'group'       => 'Hazırlık ve Yönetim'
            ],
            'documents' => [
                'label'       => 'Dokümanlar',
                'icon'        => 'heroicon-o-document',
                'description' => 'Toplantı dokümanları',
                'group'       => 'Hazırlık ve Yönetim'
            ],
            'participants' => [
                'label'       => 'Katılımcılar',
                'icon'        => 'heroicon-o-users',
                'description' => 'Toplantı katılımcıları',
                'group'       => 'Hazırlık ve Yönetim'
            ],

            // İçerik ve Etkileşim grubu
            'announcements' => [
                'label'       => 'Duyurular',
                'icon'        => 'heroicon-o-megaphone',
                'description' => 'Toplantı duyuruları',
                'group'       => 'İçerik ve Etkileşim'
            ],
            'surveys' => [
                'label'       => 'Anketler',
                'icon'        => 'heroicon-o-clipboard-document-list',
                'description' => 'Toplantı anketleri',
                'group'       => 'İçerik ve Etkileşim'
            ],
            'score-games' => [
                'label'       => 'Skor Oyunları',
                'icon'        => 'heroicon-o-trophy',
                'description' => 'Etkileşimli skor oyunları',
                'group'       => 'İçerik ve Etkileşim'
            ],

            // Ortam ve Mekan grubu
            'halls' => [
                'label'       => 'Salonlar',
                'icon'        => 'heroicon-o-building-office-2',
                'description' => 'Toplantı salonları',
                'group'       => 'Ortam ve Mekan'
            ],
            'virtual-stands' => [
                'label'       => 'Sanal Standlar',
                'icon'        => 'heroicon-o-computer-desktop',
                'description' => 'Sanal sergi standları',
                'group'       => 'Ortam ve Mekan'
            ],

            // Raporlar ve Analizler grubu
            'attendance-reports' => [
                'label'       => 'Katılım Raporları',
                'icon'        => 'heroicon-o-chart-bar',
                'description' => 'Katılımcı istatistikleri',
                'group'       => 'Raporlar ve Analizler'
            ],
            'participant-logs' => [
                'label'       => 'Katılımcı Logları',
                'icon'        => 'heroicon-o-document-text',
                'description' => 'Katılımcı aktivite kayıtları',
                'group'       => 'Raporlar ve Analizler'
            ],
            'registration-reports' => [
                'label'       => 'Kayıt Raporları',
                'icon'        => 'heroicon-o-document-chart-bar',
                'description' => 'Kayıt süreçleri analizleri',
                'group'       => 'Raporlar ve Analizler'
            ],
            'survey-reports' => [
                'label'       => 'Anket Raporları',
                'icon'        => 'heroicon-o-chart-pie',
                'description' => 'Anket sonuçları ve analizleri',
                'group'       => 'Raporlar ve Analizler'
            ],
            'keypad-reports' => [
                'label'       => 'Keypad Raporları',
                'icon'        => 'heroicon-o-calculator',
                'description' => 'Keypad interaksiyon verileri',
                'group'       => 'Raporlar ve Analizler'
            ],
            'debate-reports' => [
                'label'       => 'Tartışma Raporları',
                'icon'        => 'heroicon-o-chat-bubble-left-right',
                'description' => 'Panel ve tartışma analizleri',
                'group'       => 'Raporlar ve Analizler'
            ],
            'score-game-reports' => [
                'label'       => 'Oyun Skorları Raporları',
                'icon'        => 'heroicon-o-star',
                'description' => 'Skor oyunları sonuçları',
                'group'       => 'Raporlar ve Analizler'
            ],
            'question-reports' => [
                'label'       => 'Soru Raporları',
                'icon'        => 'heroicon-o-question-mark-circle',
                'description' => 'Soru-cevap oturumları analizleri',
                'group'       => 'Raporlar ve Analizler'
            ],
        ];
    }

    public function getSelectedMeeting(): ?Meeting
    {
        if ($this->selectedMeetingId) {
            return Meeting::find($this->selectedMeetingId);
        }

        return null;
    }

    protected function getCurrentUserCustomerId(): int
    {
        return auth()->user()->customer_id;
    }

    protected function getMeetingsQuery(): Builder
    {
        return Meeting::where('customer_id', $this->getCurrentUserCustomerId());
    }

    protected function initializeMeetingContext($meeting = null, $section = null): void
    {
        $currentCustomerId = $this->getCurrentUserCustomerId();
        $hasMeetings = $this->getMeetingsQuery()->exists();

        if (!$hasMeetings) {
            $this->selectedMeetingId = null;
            return;
        }

        if ($meeting) {
            $isAccessible = $this->getMeetingsQuery()->where('id', $meeting)->exists();

            if ($isAccessible) {
                $this->selectedMeetingId = $meeting;
            } else {
                $this->redirectToFirstMeeting($section);
            }
        } else {
            $this->redirectToFirstMeeting($section);
        }

        // Set current section if valid
        if ($section && array_key_exists($section, $this->getMeetingSections())) {
            $this->currentSection = $section;
        }
    }

    protected function redirectToFirstMeeting($section = null): void
    {
        $firstMeeting = $this->getMeetingsQuery()->select('id')->first();

        if ($firstMeeting) {
            $this->selectedMeetingId = $firstMeeting->id;

            // Redirect to the first meeting
            $this->redirect(static::getUrl([
                'meeting' => $this->selectedMeetingId,
                'section' => $section ?? 'general'
            ]));
        }
    }

    public function getFormattedStartDate(): string
    {
        $meeting = $this->getSelectedMeeting();
        if (!$meeting || !$meeting->start_at) {
            return '-';
        }

        try {
            return \Carbon\Carbon::parse($meeting->start_at)->format('d.m.Y');
        } catch (\Exception $e) {
            return $meeting->start_at;
        }
    }

    public function getFormattedFinishDate(): string
    {
        $meeting = $this->getSelectedMeeting();
        if (!$meeting || !$meeting->finish_at) {
            return '-';
        }

        try {
            return \Carbon\Carbon::parse($meeting->finish_at)->format('d.m.Y');
        } catch (\Exception $e) {
            return $meeting->finish_at;
        }
    }
}
