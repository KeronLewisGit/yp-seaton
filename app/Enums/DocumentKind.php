<?php

namespace App\Enums;

/** Certificates a subcontractor or supplier files with prequalification. */
enum DocumentKind: string
{
    case Tcc = 'tcc';
    case Registration = 'registration';
    case Insurance = 'insurance';
    case Other = 'other';

    public function label(): string
    {
        return match ($this) {
            self::Tcc => 'Tax Compliance Certificate (TCC)',
            self::Registration => 'NCC / PPC contractor registration',
            self::Insurance => 'Public liability insurance',
            self::Other => 'Other supporting document',
        };
    }

    public function short(): string
    {
        return match ($this) {
            self::Tcc => 'TCC',
            self::Registration => 'NCC/PPC registration',
            self::Insurance => 'Insurance',
            self::Other => 'Other',
        };
    }

    public function numberLabel(): string
    {
        return match ($this) {
            self::Tcc => 'TCC number',
            self::Registration => 'Registration number',
            self::Insurance => 'Insurer and policy number',
            self::Other => 'Description',
        };
    }

    public function hint(): string
    {
        return match ($this) {
            self::Tcc => 'Issued by Tax Administration Jamaica. Upload the current certificate.',
            self::Registration => 'Your current certificate of registration with the National Contracts Commission or the Public Procurement Commission, showing the works category and grade.',
            self::Insurance => 'Certificate or cover note showing the insurer, policy number, limit of indemnity and expiry date.',
            self::Other => 'For example a company registration certificate, NIS compliance letter or references.',
        };
    }

    public function expires(): bool
    {
        return $this !== self::Other;
    }

    /** @return list<self> */
    public static function certificates(): array
    {
        return [self::Tcc, self::Registration, self::Insurance];
    }
}
