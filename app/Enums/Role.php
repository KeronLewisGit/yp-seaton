<?php

namespace App\Enums;

enum Role: string
{
    case Admin = 'admin';
    case Estimating = 'estimating';
    case Procurement = 'procurement';
    case Hr = 'hr';

    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Administrator',
            self::Estimating => 'Estimating & tenders',
            self::Procurement => 'Procurement',
            self::Hr => 'Human resources',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::Admin => 'Everything, including staff accounts.',
            self::Estimating => 'Tender invitations, enquiries and client document rooms.',
            self::Procurement => 'Subcontractor and supplier prequalification and their certificates.',
            self::Hr => 'Job postings, applications and CVs.',
        };
    }

    /**
     * Back-office areas this role works in.
     *
     * @return list<Area>
     */
    public function areas(): array
    {
        return match ($this) {
            self::Admin => Area::cases(),
            self::Estimating => [Area::Tenders, Area::Enquiries, Area::Rooms],
            self::Procurement => [Area::Prequal],
            self::Hr => [Area::Careers],
        };
    }
}
