<?php

namespace App\Enums;

enum JobCategory: string
{
    case Trades = 'trades';
    case Operator = 'operator';
    case Driver = 'driver';
    case Supervisor = 'supervisor';
    case Professional = 'professional';
    case Office = 'office';

    public function label(): string
    {
        return match ($this) {
            self::Trades => 'Site labour and trades',
            self::Operator => 'Plant operator',
            self::Driver => 'Driver',
            self::Supervisor => 'Foreman / site supervisor',
            self::Professional => 'Engineer, QS or surveyor',
            self::Office => 'Office and administration',
        };
    }

    /** A CV matters for professional and office roles; site labour can apply without one. */
    public function needsCv(): bool
    {
        return in_array($this, [self::Professional, self::Office], true);
    }

    public function isSite(): bool
    {
        return in_array($this, [self::Trades, self::Operator, self::Driver, self::Supervisor], true);
    }
}
