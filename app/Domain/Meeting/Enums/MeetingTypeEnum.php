<?php

namespace App\Domain\Meeting\Enums;

enum MeetingTypeEnum: string
{
    case CONFERENCE = 'conference';
    case SEMINAR = 'seminar';
    case WORKSHOP = 'workshop';
    case MEETING = 'meeting';

    public function label(): string
    {
        return match($this) {
            self::CONFERENCE => 'Konferans',
            self::SEMINAR => 'Seminer',
            self::WORKSHOP => 'Çalıştay',
            self::MEETING => 'Toplantı',
        };
    }

    public static function options(): array
    {
        return [
            self::CONFERENCE->value => self::CONFERENCE->label(),
            self::SEMINAR->value => self::SEMINAR->label(),
            self::WORKSHOP->value => self::WORKSHOP->label(),
            self::MEETING->value => self::MEETING->label(),
        ];
    }
}
