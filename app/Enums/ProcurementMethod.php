<?php

namespace App\Enums;

/** Procurement methods as Jamaican procuring entities name them (Public Procurement Act, 2015). */
enum ProcurementMethod: string
{
    case Open = 'open';
    case Restricted = 'restricted';
    case Quotation = 'rfq';
    case Direct = 'direct';
    case Private = 'private';

    public function label(): string
    {
        return match ($this) {
            self::Open => 'Open tender (national or international competitive bidding)',
            self::Restricted => 'Restricted bidding (invited bidders)',
            self::Quotation => 'Request for quotation',
            self::Direct => 'Direct contracting / single source',
            self::Private => 'Private-sector invitation',
        };
    }

    public function short(): string
    {
        return match ($this) {
            self::Open => 'Open tender',
            self::Restricted => 'Restricted',
            self::Quotation => 'RFQ',
            self::Direct => 'Direct',
            self::Private => 'Private',
        };
    }
}
