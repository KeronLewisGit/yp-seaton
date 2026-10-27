<?php

namespace Database\Seeders;

use App\Enums\ApplicationStatus;
use App\Enums\DocumentKind;
use App\Enums\EmploymentType;
use App\Enums\EnquiryStatus;
use App\Enums\EnquiryTopic;
use App\Enums\Experience;
use App\Enums\JobCategory;
use App\Enums\JobStatus;
use App\Enums\ProcurementMethod;
use App\Enums\Role;
use App\Enums\RoomCategory;
use App\Enums\TenderStatus;
use App\Enums\VendorStatus;
use App\Enums\VendorType;
use App\Models\DocumentRoom;
use App\Models\Enquiry;
use App\Models\JobApplication;
use App\Models\JobPosting;
use App\Models\Tender;
use App\Models\User;
use App\Models\Vendor;
use App\Models\VendorDocument;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Demo data for the pitch: every organisation, person, tender and vendor here is fictional
 * and labelled "(sample)" or "Sample". Logins: admin|estimating|procurement|hr@ypseaton.test / password.
 * Never run in production.
 */
class DemoSeeder extends Seeder
{
    private const array FIRST = ['Andre', 'Shanique', 'Kemar', 'Tanya', 'Devon', 'Kimberley', 'Rohan', 'Simone', 'Omar', 'Tashana', 'Jermaine', 'Nadine', 'Damion', 'Latoya', 'Ricardo', 'Monique', 'Dwayne', 'Keisha', 'Garfield', 'Renee'];

    private const array LAST = ['Campbell', 'Brown', 'Williams', 'Thompson', 'Reid', 'Clarke', 'Grant', 'Morgan', 'Francis', 'McKenzie', 'Henry', 'Bailey', 'Gordon', 'Lewis', 'Stewart', 'Walker', 'Edwards', 'Palmer'];

    public function run(): void
    {
        // Fictional data and "password" logins: never on the live site. A pitch preview runs
        // APP_ENV=production with YPS_PREVIEW=true, so it is allowed there.
        if (app()->isProduction() && ! yps('preview')) {
            $this->command?->error('DemoSeeder does not run in production unless YPS_PREVIEW=true (a pitch preview).');

            return;
        }
        mt_srand(876);
        $staff = $this->users();
        $this->tenders($staff);
        $this->vendors($staff['procurement']);
        $this->careers();
        $this->enquiries();
        $this->rooms($staff['estimating']);
    }

    /** @return array<string, User> */
    private function users(): array
    {
        $out = [];
        foreach ([
            'admin' => ['Demo Administrator', Role::Admin],
            'estimating' => ['Demo Estimator', Role::Estimating],
            'procurement' => ['Demo Procurement Officer', Role::Procurement],
            'hr' => ['Demo HR Officer', Role::Hr],
        ] as $key => [$name, $role]) {
            $out[$key] = User::updateOrCreate(['email' => $key.'@ypseaton.test'], ['name' => $name, 'password' => Hash::make('password'), 'role' => $role, 'active' => true]);
        }
        $out['estimating2'] = User::updateOrCreate(['email' => 'qs@ypseaton.test'], ['name' => 'Demo Quantity Surveyor', 'password' => Hash::make('password'), 'role' => Role::Estimating, 'active' => true]);

        return $out;
    }

    private function name(): string
    {
        return self::FIRST[mt_rand(0, count(self::FIRST) - 1)].' '.self::LAST[mt_rand(0, count(self::LAST) - 1)];
    }

    private function phone(): string
    {
        return '876-555-'.str_pad((string) mt_rand(100, 9999), 4, '0', STR_PAD_LEFT);
    }

    /** A tiny valid PDF on the private disk, so "open" works in the demo. */
    private function pdf(string $path, string $title): void
    {
        $text = str_replace(['(', ')', '\\'], '', 'SAMPLE DOCUMENT - '.$title);
        $stream = "BT /F1 18 Tf 72 720 Td ({$text}) Tj ET";
        $objects = [
            '<< /Type /Catalog /Pages 2 0 R >>',
            '<< /Type /Pages /Kids [3 0 R] /Count 1 >>',
            '<< /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Contents 4 0 R /Resources << /Font << /F1 5 0 R >> >> >>',
            '<< /Length '.strlen($stream)." >>\nstream\n{$stream}\nendstream",
            '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>',
        ];
        $pdf = "%PDF-1.4\n";
        $offsets = [];
        foreach ($objects as $i => $obj) {
            $offsets[] = strlen($pdf);
            $pdf .= ($i + 1)." 0 obj\n{$obj}\nendobj\n";
        }
        $xref = strlen($pdf);
        $pdf .= "xref\n0 ".(count($objects) + 1)."\n0000000000 65535 f \n";
        foreach ($offsets as $o) {
            $pdf .= sprintf("%010d 00000 n \n", $o);
        }
        $pdf .= 'trailer << /Size '.(count($objects) + 1)." /Root 1 0 R >>\nstartxref\n{$xref}\n%%EOF";
        Storage::disk('local')->put($path, $pdf);
    }

    private function at(Carbon $time, callable $create): mixed
    {
        Carbon::setTestNow($time);
        try {
            return $create();
        } finally {
            Carbon::setTestNow();
        }
    }

    /** @param array<string, User> $staff */
    private function tenders(array $staff): void
    {
        foreach (self::tenderRows() as $i => [$title, $entity, $sector, $method, $parish, $days, $status, $who]) {
            $due = today()->addDays($days)->setTime([10, 12, 14][$i % 3], 0);
            $received = $days > 0 ? now()->subDays(mt_rand(2, 18))->subHours(mt_rand(0, 8)) : $due->copy()->subDays(mt_rand(20, 35));
            $tender = $this->at($received, fn () => Tender::create([
                'status' => TenderStatus::New, 'sector' => $sector, 'entity_name' => $entity, 'contact_name' => $this->name(), 'contact_role' => 'Procurement Officer',
                'email' => 'procurement'.($i + 1).'@example.org', 'phone' => $this->phone(), 'title' => $title,
                'their_reference' => $sector === 'public' ? strtoupper(Str::substr(Str::slug($entity, ''), 6, 3)).'/'.($method === ProcurementMethod::Quotation ? 'RFQ' : 'ICB').'/2026/'.str_pad((string) (10 + $i), 3, '0', STR_PAD_LEFT) : null,
                'method' => $method, 'parish' => $parish, 'location' => null,
                'scope' => "Sample scope for the demo. Supply of all labour, plant and materials for the works described in the tender documents, including site clearance, excavation, concrete works and reinstatement.\nCompletion period: ".mt_rand(4, 14).' months.',
                'estimated_value' => null, 'submission_due_at' => $due, 'site_visit_at' => $days > 7 ? $due->copy()->subDays(7)->setTime(10, 0) : null,
                'clarification_due_on' => $days > 10 ? $due->copy()->subDays(10) : null, 'bid_security' => $sector === 'public' && $i % 2 === 0,
                'documents_url' => $sector === 'public' && $i % 3 === 0 ? 'https://www.gojep.gov.jm/' : null, 'source_url' => url('/tenders'),
            ]));
            $tender->log('Received from the website.');
            $this->pdf("tenders/{$tender->id}/invitation.pdf", $title);
            $tender->files()->create(['path' => "tenders/{$tender->id}/invitation.pdf", 'original_name' => 'Invitation to bid.pdf', 'mime' => 'application/pdf', 'size' => 1400]);
            if ($who) {
                $tender->assigned_to = $staff[$who]->id;
                $tender->log("Assigned to {$staff[$who]->name}.", 'assign', $staff['admin']);
            }
            if ($status !== TenderStatus::New) {
                $tender->moveTo($status);
                $tender->status_changed_at = $days < 0 ? $due->copy()->addDays(mt_rand(1, 20)) : now()->subDays(1);
                $tender->log('Status changed to '.$status->label().'.', 'status', $staff[$who ?? 'estimating']);
            }
            $tender->save();
        }
        $first = Tender::orderBy('submission_due_at')->where('status', TenderStatus::Pricing)->first();
        $first?->log('Site visit done. Quotes requested from two formwork subcontractors and the ready-mix supplier.', 'note', $staff['estimating']);
    }

    /** @return list<array{string, string, string, ProcurementMethod, string, int, TenderStatus, string|null}> */
    private static function tenderRows(): array
    {
        return [
            // title, entity, sector, method, parish, due in days, status, assignee
            ['Rehabilitation of drains and culverts, Spanish Town (sample)', 'Sample Municipal Corporation', 'public', ProcurementMethod::Open, 'St. Catherine', 2, TenderStatus::Pricing, 'estimating'],
            ['Shoreline revetment repairs, 600 m (sample)', 'Sample Port Agency', 'public', ProcurementMethod::Restricted, 'Kingston', 4, TenderStatus::Reviewing, 'estimating2'],
            ['Sewer main replacement and manholes (sample)', 'Sample Water Utility', 'public', ProcurementMethod::Open, 'St. Andrew', 6, TenderStatus::New, null],
            ['Two-storey classroom block, foundations and frame (sample)', 'Sample Education Agency', 'public', ProcurementMethod::Quotation, 'Clarendon', 6, TenderStatus::Pricing, 'estimating'],
            ['Housing scheme infrastructure, 120 lots (sample)', 'Sample Housing Developer Ltd.', 'private', ProcurementMethod::Private, 'St. Catherine', 13, TenderStatus::Reviewing, 'estimating2'],
            ['Road resurfacing and kerbs, 3.2 km (sample)', 'Sample Roads Agency', 'public', ProcurementMethod::Open, 'Manchester', 19, TenderStatus::New, null],
            ['Gabion river training works (sample)', 'Sample Parish Council', 'public', ProcurementMethod::Quotation, 'St. Thomas', 26, TenderStatus::New, null],
            ['Warehouse slab and site works (sample)', 'Sample Logistics Ltd.', 'private', ProcurementMethod::Private, 'St. Catherine', 33, TenderStatus::Reviewing, 'estimating'],
            ['Sewage treatment plant upgrade, civil works (sample)', 'Sample Development Agency', 'public', ProcurementMethod::Open, 'St. Catherine', 41, TenderStatus::New, null],
            ['Box culvert replacement (sample)', 'Sample Roads Agency', 'public', ProcurementMethod::Open, 'St. Mary', -6, TenderStatus::Submitted, 'estimating'],
            ['Seawall extension, phase 2 (sample)', 'Sample Port Agency', 'public', ProcurementMethod::Restricted, 'Kingston', -40, TenderStatus::Won, 'estimating2'],
            ['Community water supply pipeline (sample)', 'Sample Water Utility', 'public', ProcurementMethod::Open, 'St. Elizabeth', -55, TenderStatus::Lost, 'estimating'],
            ['Apartment complex foundations (sample)', 'Sample Property Developer', 'private', ProcurementMethod::Private, 'St. Andrew', -20, TenderStatus::Declined, 'estimating2'],
            ['Retaining wall and slope stabilisation (sample)', 'Sample Municipal Corporation', 'public', ProcurementMethod::Quotation, 'Portland', -90, TenderStatus::Won, 'estimating'],
        ];
    }

    private function vendors(User $officer): void
    {
        $rows = [
            // company, type, trades, status, days to earliest expiry
            ['Blue Mountain Formwork Ltd. (sample)', VendorType::Subcontractor, ['formwork', 'steel'], VendorStatus::Approved, 9],
            ['Harbour Marine Works Ltd. (sample)', VendorType::Subcontractor, ['marine', 'earthworks'], VendorStatus::Approved, -4],
            ['Liguanea Ready-Mix Co. (sample)', VendorType::Supplier, ['concrete'], VendorStatus::Approved, 22],
            ['Rio Cobre Quarry Supplies (sample)', VendorType::Supplier, ['aggregates', 'armour'], VendorStatus::Approved, 150],
            ['St. Catherine Plant Hire Ltd. (sample)', VendorType::PlantHire, ['plant', 'haulage'], VendorStatus::Approved, 27],
            ['Corporate Area Pipe & Drainage (sample)', VendorType::Supplier, ['pipes'], VendorStatus::Approved, 210],
            ['Island Survey Associates (sample)', VendorType::Consultant, ['survey'], VendorStatus::Approved, 95],
            ['Clarendon Masonry Contractors (sample)', VendorType::Subcontractor, ['masonry', 'finishing'], VendorStatus::Reviewing, 180],
            ['Portmore Electrical Services (sample)', VendorType::Subcontractor, ['electrical'], VendorStatus::New, 240],
            ['Westmoreland Haulage Ltd. (sample)', VendorType::PlantHire, ['haulage'], VendorStatus::New, 120],
            ['Materials Testing Lab JA (sample)', VendorType::Consultant, ['testing'], VendorStatus::Approved, 300],
            ['Northcoast Steel Fixers (sample)', VendorType::Subcontractor, ['steel'], VendorStatus::Declined, 60],
        ];
        $parishes = (array) yps('parishes');
        foreach ($rows as $i => [$company, $type, $trades, $status, $days]) {
            $vendor = $this->at(now()->subDays(mt_rand(20, 300)), fn () => Vendor::create([
                'status' => VendorStatus::New, 'type' => $type, 'company_name' => $company, 'trn' => (string) mt_rand(100000000, 999999999),
                'year_established' => mt_rand(1985, 2020), 'address' => mt_rand(1, 90).' Sample Road', 'parish' => $parishes[$i % count($parishes)],
                'contact_name' => $this->name(), 'contact_role' => 'Director', 'email' => 'vendor'.($i + 1).'@example.com', 'phone' => $this->phone(),
                'trades' => $trades, 'parishes_served' => array_slice($parishes, 0, mt_rand(3, 8)), 'employees' => array_keys(Vendor::EMPLOYEE_BANDS)[mt_rand(0, 3)],
                'registration_grade' => $type === VendorType::Subcontractor ? 'Sample: Civil engineering works, grade '.mt_rand(2, 4) : null,
                'experience' => 'Sample entry for the demo: recent subcontracts on drainage, housing and road projects.', 'consented_at' => now(),
            ]));
            $vendor->log('Received from the website.');
            foreach ($type->requiredDocuments() as $k => $kind) {
                $path = "vendors/{$vendor->id}/{$kind->value}.pdf";
                $this->pdf($path, $kind->label().' - '.$company);
                $vendor->documents()->create([
                    'kind' => $kind, 'path' => $path, 'original_name' => $kind->short().'.pdf', 'mime' => 'application/pdf', 'size' => 1400,
                    'number' => $kind === DocumentKind::Insurance ? 'Sample Insurance Co. / PL-'.mt_rand(10000, 99999) : 'S-'.mt_rand(100000, 999999),
                    'expires_on' => today()->addDays($days + $k * 47),
                    'verified_at' => $status === VendorStatus::Approved ? now()->subDays(mt_rand(5, 60)) : null,
                    'verified_by' => $status === VendorStatus::Approved ? $officer->id : null,
                ]);
            }
            if ($status !== VendorStatus::New) {
                $vendor->moveTo($status);
                $vendor->reviewed_by = $officer->id;
                $vendor->save();
                $vendor->log('Status changed to '.$status->label().'.', 'status', $officer);
            }
        }
        // One renewal already in: the superseded copy stays on file.
        $renewed = Vendor::where('company_name', 'like', 'Rio Cobre%')->first();
        if ($renewed) {
            /** @var VendorDocument $tcc */
            $tcc = $renewed->documents()->where('kind', DocumentKind::Tcc)->firstOrFail();
            $old = $tcc->replicate(['expires_on', 'superseded_at']);
            $old->fill(['expires_on' => today()->subDays(30), 'superseded_at' => now()->subDays(35)])->save();
            $renewed->log('Vendor uploaded 1 renewed certificate through the renewal link.');
        }
    }

    private function careers(): void
    {
        $jobs = [
            ['Site foreman, coastal works (sample)', JobCategory::Supervisor, EmploymentType::Project, 'Palisadoes, Kingston', 1, 'Lead a crew placing rock armour and building a revetment on a live shoreline project.', "Plan the day's work with the site engineer\nRun toolbox talks and keep the site diary\nCheck rock grading and placement against the drawings", "5 years or more as a civil foreman\nMarine or coastal experience preferred\nAble to read construction drawings"],
            ['Excavator operator (sample)', JobCategory::Operator, EmploymentType::Project, 'Kingston and St. Catherine', 3, 'Operate 20 to 35 tonne excavators on drainage, earthworks and coastal projects.', "Bulk and trench excavation\nPlace armour stone to profile\nDaily pre-start checks", "Proven excavator experience\nValid driver's licence\nSafe working record"],
            ['Masons and steel fixers (sample)', JobCategory::Trades, EmploymentType::Project, 'Various sites, Jamaica', 8, 'Skilled tradesmen for housing and drainage projects starting this quarter.', "Blockwork, rendering and concrete finishing\nCut, bend and fix reinforcement", "Trade experience on construction sites\nHEART/NSTA Trust certificate an advantage"],
            ['Quantity surveyor (sample)', JobCategory::Professional, EmploymentType::FullTime, '52c Molynes Road, Kingston 10', 1, 'Price tenders and manage valuations and variations on public and private contracts.', "Take-offs and bills of quantities\nSubcontractor quotes and comparisons\nMonthly valuations and final accounts", "Degree in quantity surveying or construction management\n3 years in a contractor's office\nFluent with Excel and CostX or similar"],
            ['Tipper truck driver (sample)', JobCategory::Driver, EmploymentType::Temporary, 'Kingston', 2, 'Haul aggregates and excavated material between sites and quarries.', "Load, haul and tip safely\nKeep trip logs", "General driver's licence with the right class\nClean driving record"],
        ];
        $posts = [];
        foreach ($jobs as [$title, $cat, $type, $loc, $openings, $summary, $duties, $req]) {
            $posts[] = JobPosting::create(['slug' => Str::slug(str_replace(' (sample)', '', $title)), 'title' => $title, 'category' => $cat, 'employment_type' => $type, 'status' => JobStatus::Open,
                'location' => $loc, 'openings' => $openings, 'summary' => $summary, 'duties' => $duties, 'requirements' => $req, 'closes_on' => today()->addDays(mt_rand(14, 45)), 'is_demo' => true]);
        }
        JobPosting::create(['slug' => 'site-engineer-closed', 'title' => 'Site engineer (sample, closed)', 'category' => JobCategory::Professional, 'employment_type' => EmploymentType::FullTime,
            'status' => JobStatus::Closed, 'location' => 'Kingston', 'openings' => 1, 'summary' => 'Closed sample posting.', 'is_demo' => true]);

        $statuses = [ApplicationStatus::New, ApplicationStatus::New, ApplicationStatus::New, ApplicationStatus::Reviewing, ApplicationStatus::Interview, ApplicationStatus::Hired, ApplicationStatus::Declined];
        $parishes = (array) yps('parishes');
        for ($i = 0; $i < 22; $i++) {
            $job = $i % 5 === 4 ? null : $posts[$i % count($posts)];
            $cat = $job->category ?? JobCategory::Trades;
            [$first, $last] = explode(' ', $this->name());
            $status = $statuses[$i % count($statuses)];
            $app = $this->at(now()->subDays(mt_rand(0, 50))->subHours(mt_rand(0, 10)), fn () => JobApplication::create([
                'job_posting_id' => $job?->id, 'category' => $cat, 'status' => ApplicationStatus::New, 'first_name' => $first, 'last_name' => $last,
                'phone' => $this->phone(), 'email' => $cat->needsCv() || $i % 2 ? strtolower($first.'.'.$last.$i).'@example.com' : null,
                'parish' => $parishes[$i % count($parishes)], 'experience' => Experience::cases()[mt_rand(1, 4)],
                'qualifications' => $cat->isSite() ? 'Sample: site experience on drainage and housing projects.' : 'Sample: BSc, 4 years in a contractor\'s office.',
                'available_from' => today()->addDays(mt_rand(3, 30)), 'consented_at' => now(),
            ]));
            if ($cat->needsCv() || $i % 3 === 0) {
                $path = 'cvs/demo-'.$app->id.'.pdf';
                $this->pdf($path, 'CV - '.$app->full_name);
                $app->forceFill(['cv_path' => $path, 'cv_name' => 'CV.pdf', 'cv_mime' => 'application/pdf', 'cv_size' => 1400])->save();
            }
            $app->log('Received from the website.');
            if ($status !== ApplicationStatus::New) {
                $app->moveTo($status);
                $app->save();
            }
        }
    }

    private function enquiries(): void
    {
        $rows = [
            [EnquiryTopic::Project, 'Sample Church Building Committee', 'We are planning a hall extension and car park and would like a contractor to price the civil works.', EnquiryStatus::New],
            [EnquiryTopic::Project, 'Sample Strata Corporation', 'Our boundary wall and drainage need repair after the rains. Can you visit?', EnquiryStatus::New],
            [EnquiryTopic::General, null, 'Do you carry out soil testing, or should we hire a lab separately?', EnquiryStatus::Answered],
            [EnquiryTopic::Media, 'Sample Community Newsletter', 'We would like a short interview about local hiring on your current project.', EnquiryStatus::Answered],
            [EnquiryTopic::Other, null, 'Lost and found: a hard hat was left at our gate on Molynes Road.', EnquiryStatus::Closed],
        ];
        foreach ($rows as $i => [$topic, $org, $message, $status]) {
            $e = $this->at(now()->subDays($i * 3 + 1), fn () => Enquiry::create(['topic' => $topic, 'name' => $this->name(), 'organisation' => $org, 'email' => 'enquiry'.($i + 1).'@example.com', 'phone' => $this->phone(), 'message' => $message.' (sample)', 'status' => $status]));
            $e->log('Received from the website.');
        }
    }

    private function rooms(User $estimator): void
    {
        $rooms = [
            ['Sample: Shoreline revetment repairs', 'Sample Port Agency', [['Drawing C-101 rev B, revetment typical section', RoomCategory::Drawings], ['Drawing C-102 rev A, plan and chainages', RoomCategory::Drawings], ['Progress report, month 3', RoomCategory::Reports], ['Programme of works rev 2', RoomCategory::Programme], ['Site meeting minutes no. 7', RoomCategory::Minutes], ['Interim payment certificate no. 3', RoomCategory::Certificates]]],
            ['Sample: Housing infrastructure, 120 lots', 'Sample Housing Developer Ltd.', [['Road and drainage layout rev C', RoomCategory::Drawings], ['Progress report, week 14', RoomCategory::Reports]]],
        ];
        foreach ($rooms as $i => [$name, $client, $docs]) {
            $room = DocumentRoom::create(['name' => $name, 'client_name' => $client, 'client_contact' => $this->name(), 'client_email' => 'client'.($i + 1).'@example.org',
                'description' => 'Sample room for the demo. Documents here are placeholders.', 'created_by' => $estimator->id, 'is_demo' => true]);
            $room->log('Room created.', 'system', $estimator);
            foreach ($docs as [$title, $cat]) {
                $path = "rooms/{$room->id}/".Str::slug($title).'.pdf';
                $this->pdf($path, $title);
                $room->documents()->create(['title' => $title, 'category' => $cat, 'path' => $path, 'original_name' => Str::slug($title).'.pdf', 'mime' => 'application/pdf', 'size' => 1400, 'uploaded_by' => $estimator->id]);
            }
            if ($i === 0) {
                $room->shareLink(30);
                $room->forceFill(['last_opened_at' => now()->subHours(5)])->save();
                $room->log('Share link created, valid until '.$room->link_expires_at?->format('j M Y').'.', 'system', $estimator);
                $room->log('Opened by the client link.');
            }
        }
    }
}
