<?php

namespace App\Domain\Meeting\Enums;

enum MeetingStatusEnum: int
{
    case INACTIVE = 0;
    case ACTIVE = 1;

    public function label(): string
    {
        return match($this) {
            self::INACTIVE => 'Pasif',
            self::ACTIVE => 'Aktif',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::INACTIVE => 'danger',
            self::ACTIVE => 'success',
        };
    }

    public static function options(): array
    {
        return [
            self::INACTIVE->value => self::INACTIVE->label(),
            self::ACTIVE->value => self::ACTIVE->label(),
        ];
    }
}
