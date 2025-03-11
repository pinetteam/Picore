<?php

namespace App\Domain\Meeting\Resources\MeetingResource\Pages;

use App\Domain\Meeting\Resources\MeetingResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Components;
use Filament\Infolists\Infolist;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\Schema;

class ViewMeeting extends ViewRecord
{
    protected static string $resource = MeetingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Components\Section::make('Toplantı Bilgileri')
                    ->schema([
                        Components\Grid::make(2)
                            ->schema([
                                Components\ImageEntry::make('banner_url')
                                    ->label('Banner Görseli')
                                    ->columnSpanFull()
                                    ->defaultImageUrl('https://placehold.co/1200x675/CCCCCC/808080.png?text=No+Image'),


                                Components\TextEntry::make('title')
                                    ->label('Başlık'),

                                Components\TextEntry::make('code')
                                    ->label('Kod'),

                                Components\TextEntry::make('customer.title')
                                    ->label('Müşteri'),

                                Components\TextEntry::make('type_label')
                                    ->label('Tür'),

                                Components\IconEntry::make('status')
                                    ->boolean()
                                    ->label('Durum'),

                                Components\TextEntry::make('date_range')
                                    ->label('Tarih Aralığı'),

                                Components\TextEntry::make('created_at')
                                    ->label('Oluşturulma Tarihi')
                                    ->dateTime('d.m.Y H:i'),

                                Components\TextEntry::make('upload_debug')
                                    ->label('Debug Bilgisi')
                                    ->columnSpanFull()
                                    ->state(function ($record) {
                                        $debug = [
                                            'banner' => var_export($record->banner, true),
                                            'banner_url' => $record->banner_url,
                                        ];

                                        return implode("\n", array_map(function($k, $v) {
                                            return "$k: $v";
                                        }, array_keys($debug), $debug));
                                    }),

                            ]),
                    ]),

                Components\Section::make('Toplantı İstatistikleri')
                    ->schema([
                        Components\Grid::make(2)
                            ->schema([
                                // Katılımcı sayısını gösterme - tablo varsa
                                Components\TextEntry::make('participants_count')
                                    ->label('Katılımcı Sayısı')
                                    ->state(function ($record) {
                                        if (Schema::hasTable('meeting_participants')) {
                                            return $record->participants()->count();
                                        }
                                        return "Tablo oluşturulmadı";
                                    })
                                    ->color('success'),

                                // Kalan gün hesaplama
                                Components\TextEntry::make('days_left')
                                    ->label('Kalan Gün')
                                    ->state(function ($record) {
                                        if ($record->finish_at->isPast()) {
                                            return "Toplantı sona erdi";
                                        }
                                        return $record->finish_at->diffInDays(now()) . " gün";
                                    })
                                    ->color('danger'),
                            ]),
                    ]),
            ]);
    }
}
