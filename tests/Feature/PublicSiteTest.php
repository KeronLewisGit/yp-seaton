<?php

namespace Tests\Feature;

use App\Models\JobPosting;
use App\Support\Portfolio;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
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

    #[DataProvider('pages')]
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
        foreach (array_merge(['/', '/about', '/projects', '/services', '/capability-statement', '/contact', '/tenders', '/prequalification', '/careers'], Portfolio::all()->keys()->map(fn ($s) => '/projects/'.$s)->all()) as $url) {
            $html = strtolower(strip_tags((string) $this->get($url)->getContent()));
            foreach (['arbitration', 'lawsuit', 'litigation', 'dispute', 'claim', 'sued', 'court', 'judgment', 'privy council', 'contractor general', 'ocg'] as $word) {
                $this->assertDoesNotMatchRegularExpression('/\\b'.$word.'/', $html, "{$url} mentions {$word}");
            }
        }
        // Nor the proposal or the capability statement PDF that go to the firm.
        $text = strtolower((string) file_get_contents(base_path('scripts/proposal/build.mjs')).file_get_contents(base_path('scripts/capability-pdf.mjs')));
        foreach (['arbitration', 'lawsuit', 'litigation', 'dispute', 'privy council', 'contractor general'] as $word) {
            $this->assertStringNotContainsString($word, $text, "the proposal mentions {$word}");
        }
    }

    public function test_every_public_page_has_a_photo_and_stock_photos_are_labelled(): void
    {
        foreach (self::pages() as [$url]) {
            if (in_array($url, ['/login', '/capability-statement'], true)) {
                continue; // the sign-in screen and the printable one-pager
            }
            $html = (string) $this->get($url)->getContent();
            $this->assertMatchesRegularExpression('/<img [^>]*src="[^"]+\/img\//', $html, "{$url} has no photograph");
        }
        $this->get('/thanks')->assertRedirect('/'); // no submission: covered by the form tests
        $this->get('/')->assertSee('Illustrative photo');
        $this->get('/projects')->assertSee('Illustrative photo');
        $this->get('/services')->assertSee('Illustrative photo');
        $this->get('/no-such-page')->assertNotFound()->assertSee('Illustrative photo');
        // The Bank of Jamaica photo on /about is the firm's own: no label in the header.
        $this->assertStringNotContainsString('Illustrative photo', (string) $this->get('/about')->getContent());
    }

    public function test_submit_buttons_read_correctly_without_javascript(): void
    {
        $html = (string) $this->get('/contact')->getContent();
        $this->assertMatchesRegularExpression('/<span hidden[^>]*>Sending…<\/span>/u', $html);
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

    public function test_capability_statement_lists_every_project_with_its_source(): void
    {
        $res = $this->get('/capability-statement')->assertOk()->assertSee(config('ypseaton.name'));
        foreach (Portfolio::all() as $p) {
            $res->assertSee($p['title'])->assertSee($p['sources'][0]['label']);
            if (! empty($p['value'])) {
                $res->assertSee(jmd($p['value']), false);
            }
        }
        foreach ((array) config('ypseaton.services') as $service) {
            $res->assertSee($service['title']);
        }
    }

    public function test_project_pages_say_the_photo_is_illustrative_and_never_invent_a_year(): void
    {
        foreach (Portfolio::all() as $slug => $p) {
            $res = $this->get('/projects/'.$slug)->assertSee('Illustrative photo');
            if (empty($p['year'])) {
                $res->assertSee('Not published');
            }
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
