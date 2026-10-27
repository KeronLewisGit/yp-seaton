<?php

namespace Tests\Feature;

use App\Models\JobPosting;
use App\Support\Portfolio;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicSiteTest extends TestCase
{
    use RefreshDatabase;

    /** @return array<string, array{string}> */
    public static function pages(): array
    {
        return [
            'home' => ['/'], 'services' => ['/services'], 'projects' => ['/projects'], 'about' => ['/about'],
            'capability' => ['/capability-statement'], 'contact' => ['/contact'], 'tenders' => ['/tenders'],
            'prequal' => ['/prequalification'], 'careers' => ['/careers'], 'apply' => ['/careers/apply'],
            'privacy' => ['/privacy'], 'credits' => ['/photo-credits'], 'sitemap' => ['/sitemap'], 'login' => ['/login'],
        ];
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('pages')]
    public function test_public_pages_render(string $url): void
    {
        $this->get($url)->assertOk()->assertSee('Y.P. Seaton', false);
    }

    public function test_every_inner_page_opens_with_the_shared_hero(): void
    {
        foreach (array_keys(self::pages()) as $name) {
            $url = self::pages()[$name][0];
            if (in_array($url, ['/', '/login', '/capability-statement'], true)) {
                continue;
            }
            $this->get($url)->assertSee('armour on-sea', false)->assertSee('class="titleblock', false);
        }
        foreach (Portfolio::all()->keys() as $slug) {
            $this->get('/projects/'.$slug)->assertSee('armour on-sea', false);
        }
    }

    public function test_every_project_has_a_page_with_photo_and_sources(): void
    {
        $this->assertGreaterThanOrEqual(3, Portfolio::all()->count());
        foreach (Portfolio::all() as $slug => $p) {
            $res = $this->get(route('projects.show', $slug))->assertOk()->assertSee($p['title'], false);
            $this->assertNotEmpty($p['sources'] ?? [], "{$slug} needs at least one source");
            $this->assertFileExists(public_path('img/'.$p['photo'].'-960.webp'), "{$slug} photo missing");
            if (! empty($p['value'])) {
                $res->assertSee(jmd($p['value']), false);
            }
        }
        $this->get('/projects/not-a-project')->assertNotFound();
    }

    public function test_project_filter_by_sector_ignores_junk(): void
    {
        $sector = array_key_first(Portfolio::sectors());
        $this->get('/projects?sector='.$sector)->assertOk()->assertSee('aria-current="true"', false);
        $this->get('/projects?sector[]=x')->assertOk();
    }

    public function test_every_photo_is_credited_and_exists(): void
    {
        $credits = config('photo-credits');
        foreach (array_keys((array) config('ypseaton.photos')) as $key) {
            $this->assertArrayHasKey($key, $credits, "{$key} has no credit");
            foreach ([480, 960, 1920] as $w) {
                $this->assertFileExists(public_path("img/{$key}-{$w}.webp"));
            }
        }
        $this->get('/photo-credits')->assertSee('Wikimedia Commons');
    }

    public function test_site_never_mentions_disputes_or_claims(): void
    {
        foreach (['/', '/about', '/projects', '/services', '/capability-statement'] as $url) {
            $html = strtolower(strip_tags((string) $this->get($url)->getContent()));
            foreach (['arbitration', 'lawsuit', 'dispute', 'sued', 'court'] as $word) {
                $this->assertStringNotContainsString($word, $html, "{$url} mentions {$word}");
            }
        }
    }

    public function test_legacy_squarespace_urls_redirect(): void
    {
        foreach ((array) config('ypseaton.legacy_redirects') as $from => $to) {
            $this->get($from)->assertRedirect($to)->assertStatus(301);
        }
    }

    public function test_open_jobs_list_and_closed_jobs_404(): void
    {
        $open = JobPosting::factory()->create(['title' => 'Steel fixer']);
        $closed = JobPosting::factory()->create(['title' => 'Old role', 'closes_on' => today()->subDay()]);

        $this->get('/careers')->assertSee('Steel fixer')->assertDontSee('Old role');
        $this->get('/careers/'.$open->slug)->assertOk()->assertSee('JobPosting', false);
        $this->get('/careers/'.$closed->slug)->assertNotFound();
    }

    public function test_sitemap_lists_projects_and_jobs(): void
    {
        $job = JobPosting::factory()->create();
        $xml = $this->get('/sitemap.xml')->assertOk()->assertHeader('Content-Type', 'application/xml')->getContent();
        foreach (Portfolio::all()->keys() as $slug) {
            $this->assertStringContainsString(route('projects.show', $slug), (string) $xml);
        }
        $this->assertStringContainsString(route('careers.show', $job), (string) $xml);
    }

    public function test_capability_pdf_downloads_or_falls_back_to_the_print_page(): void
    {
        $res = $this->get('/capability-statement.pdf');
        if (is_file(public_path('downloads/'.config('ypseaton.capability_pdf')))) {
            $res->assertOk()->assertHeader('Content-Type', 'application/pdf');
        } else {
            $res->assertRedirect('/capability-statement');
        }
    }

    public function test_preview_mode_adds_banner_and_noindex(): void
    {
        config(['ypseaton.preview' => true]);
        $this->get('/')->assertSee('Concept preview')->assertHeader('X-Robots-Tag', 'noindex, nofollow');
    }

    public function test_security_headers(): void
    {
        $this->get('/')->assertHeader('X-Content-Type-Options', 'nosniff')->assertHeader('X-Frame-Options', 'SAMEORIGIN');
    }
}
