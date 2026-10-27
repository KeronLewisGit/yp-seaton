<?php

if (! function_exists('yps')) {
    /** A fact from config/ypseaton.php: yps('phone'), yps('projects'). */
    function yps(string $key, mixed $default = null): mixed
    {
        return config('ypseaton.'.$key, $default);
    }
}

if (! function_exists('us_digits')) {
    /** E.164 digits for a North American (+1, incl. Jamaica 876 and 658) number written any common way, or null. */
    function us_digits(?string $number): ?string
    {
        $digits = preg_replace('/\D+/', '', (string) $number) ?? '';
        if (strlen($digits) === 10) {
            $digits = '1'.$digits;
        }

        return strlen($digits) === 11 && $digits[0] === '1' ? $digits : null;
    }
}

if (! function_exists('tel_href')) {
    function tel_href(?string $number): string
    {
        $digits = us_digits($number);

        return $digits ? 'tel:+'.$digits : 'tel:'.preg_replace('/[^\d+]/', '', (string) $number);
    }
}

if (! function_exists('format_phone')) {
    /** (876) 923-5491 for +1 numbers, the way Jamaican numbers are usually printed; the input unchanged otherwise. */
    function format_phone(?string $number): string
    {
        $digits = us_digits($number);
        if (! $digits) {
            return (string) $number;
        }

        return sprintf('(%s) %s-%s', substr($digits, 1, 3), substr($digits, 4, 3), substr($digits, 7));
    }
}

if (! function_exists('input_string')) {
    /** A request value as a string. Arrays (?type[]=x) and other junk become ''. */
    function input_string(mixed $value): string
    {
        return is_scalar($value) ? trim((string) $value) : '';
    }
}

if (! function_exists('lines_to_array')) {
    /**
     * Textarea with one item per line, bullets optional, to a clean list.
     *
     * @return list<string>
     */
    function lines_to_array(?string $text): array
    {
        $lines = preg_split('/\r\n|\r|\n/', (string) $text) ?: [];
        $clean = array_map(fn (string $l) => trim((string) preg_replace('/^(?:[-*]|•)\s*/u', '', $l)), $lines);

        return array_values(array_filter($clean, fn (string $l) => $l !== ''));
    }
}

if (! function_exists('compact_number')) {
    /** 1,284 → 1.3K, used on stat tiles. */
    function compact_number(int|float $n): string
    {
        return match (true) {
            abs($n) >= 1_000_000 => round($n / 1_000_000, 1).'M',
            abs($n) >= 10_000 => round($n / 1_000).'K',
            default => number_format($n),
        };
    }
}

if (! function_exists('photo')) {
    /**
     * Responsive <img> attributes for a photo in public/img (WebP at 480/960/1920 wide).
     *
     * @return array{src: string, srcset: string, width: int, height: int}
     */
    function photo(string $key): array
    {
        $meta = config('ypseaton.photos.'.$key) ?? ['w' => 1920, 'h' => 1280];
        $url = fn (int $w) => asset("img/{$key}-{$w}.webp");

        return [
            'src' => $url(960),
            'srcset' => $url(480).' 480w, '.$url(960).' 960w, '.$url(1920).' 1920w',
            'width' => (int) $meta['w'],
            'height' => (int) $meta['h'],
        ];
    }
}

if (! function_exists('format_trn')) {
    /** A Jamaican Taxpayer Registration Number as 123-456-789. */
    function format_trn(?string $trn): string
    {
        $d = preg_replace('/\D+/', '', (string) $trn) ?? '';

        return strlen($d) === 9 ? substr($d, 0, 3).'-'.substr($d, 3, 3).'-'.substr($d, 6) : (string) $trn;
    }
}

if (! function_exists('file_size')) {
    /** 2.4 MB, 380 KB */
    function file_size(?int $bytes): string
    {
        $bytes = (int) $bytes;

        return $bytes >= 1_048_576 ? round($bytes / 1_048_576, 1).' MB' : max(1, (int) round($bytes / 1024)).' KB';
    }
}

if (! function_exists('jmd')) {
    /** J$555.9 million: the way the Gleaner and Cabinet notices quote contract values. Null stays null. */
    function jmd(?float $millions): ?string
    {
        if ($millions === null) {
            return null;
        }

        return $millions >= 1000 ? 'J$'.plain_number($millions / 1000, 2).' billion' : 'J$'.plain_number($millions, 1).' million';
    }
}

if (! function_exists('plain_number')) {
    /** 9.50 → "9.5", 9.00 → "9": a figure without trailing zeros. */
    function plain_number(float $n, int $decimals = 2): string
    {
        return rtrim(rtrim(number_format($n, $decimals, '.', ''), '0'), '.');
    }
}
