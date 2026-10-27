<?php

namespace App\Enums;

/** A part of the back office. Role::areas() says who works where; policies and the nav read it. */
enum Area: string
{
    case Tenders = 'tenders';
    case Prequal = 'prequal';
    case Careers = 'careers';
    case Enquiries = 'enquiries';
    case Rooms = 'rooms';

    public function label(): string
    {
        return match ($this) {
            self::Tenders => 'Tender invitations',
            self::Prequal => 'Prequalification',
            self::Careers => 'Careers',
            self::Enquiries => 'Enquiries',
            self::Rooms => 'Project documents',
        };
    }

    /** Which NOTIFY_* inbox hears about new submissions in this area. */
    public function inbox(): string
    {
        return $this->value;
    }
}
