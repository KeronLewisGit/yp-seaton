<?php

namespace App\Support;

use Illuminate\Support\Collection;

/**
 * The project portfolio in config/ypseaton.php. Only projects from the firm's own (archived)
 * site, the Gleaner/Observer or government notices are listed, and a value or year appears
 * only where a source states it.
 *
 * @phpstan-type Project array{slug: string, title: string, client?: string|null, location: string, parish?: string|null, sector: string, year?: int|null, year_label?: string|null, value?: float|null, value_label?: string|null, status?: string|null, summary: string, scope?: list<string>, photo: string, photo_alt: string, sources?: list<array{label: string, url: string, date?: string|null}>, featured?: bool}
 */
final class Portfolio
{
    /** @return Collection<string, Project> */
    public static function all(): Collection
    {
        /** @var array<string, array<string, mixed>> $projects */
        $projects = (array) yps('projects', []);

        /** @var Collection<string, Project> */
        return collect($projects)->map(fn (array $p, string $slug) => ['slug' => $slug] + $p);
    }

    /** @return Project|null */
    public static function find(string $slug): ?array
    {
        return self::all()->get($slug);
    }

    /** @return Collection<string, Project> */
    public static function featured(): Collection
    {
        return self::all()->filter(fn (array $p) => ! empty($p['featured']));
    }

    /** @return Collection<string, Project> */
    public static function inSector(?string $sector): Collection
    {
        return $sector ? self::all()->filter(fn (array $p) => $p['sector'] === $sector) : self::all();
    }

    /** @return array<string, string> key => label, for sectors that have projects */
    public static function sectors(): array
    {
        $used = self::all()->pluck('sector')->unique()->all();

        return collect((array) yps('sectors', []))->only($used)->map(fn (array $s) => (string) $s['label'])->all();
    }

    public static function sectorLabel(string $key): string
    {
        return (string) (yps('sectors.'.$key.'.label') ?? ucfirst($key));
    }

    /**
     * The other projects to show under one: same sector first.
     *
     * @return Collection<string, Project>
     */
    public static function related(string $slug, int $limit = 3): Collection
    {
        $project = self::find($slug);
        $others = self::all()->except($slug);

        return $others->sortBy(fn (array $p) => $project && $p['sector'] === $project['sector'] ? 0 : 1)->take($limit);
    }
}
