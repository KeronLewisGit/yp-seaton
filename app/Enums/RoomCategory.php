<?php

namespace App\Enums;

enum RoomCategory: string
{
    case Drawings = 'drawings';
    case Reports = 'reports';
    case Programme = 'programme';
    case Certificates = 'certificates';
    case Minutes = 'minutes';
    case Photos = 'photos';
    case Other = 'other';

    public function label(): string
    {
        return match ($this) {
            self::Drawings => 'Drawings',
            self::Reports => 'Progress reports',
            self::Programme => 'Programme of works',
            self::Certificates => 'Payment and completion certificates',
            self::Minutes => 'Site meeting minutes',
            self::Photos => 'Site photographs',
            self::Other => 'Other',
        };
    }
}
