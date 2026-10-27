<?php

namespace App\Enums;

enum EnquiryTopic: string
{
    case Project = 'project';
    case General = 'general';
    case Media = 'media';
    case Other = 'other';

    public function label(): string
    {
        return match ($this) {
            self::Project => 'A project or works we could quote for',
            self::General => 'General question',
            self::Media => 'Media or community',
            self::Other => 'Something else',
        };
    }
}
