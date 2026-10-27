# Y.P. Seaton & Associates

Website and back office for Y.P. Seaton & Associates Company Limited (also "Y.P. Seaton Group"), civil engineering and building contractors at 52c Molynes Road, Kingston 10, Jamaica (since 1969). The firm's own site, ypseaton.com, is an expired Squarespace page (HTTP 404, checked 26 October 2026).

## What it does

- **Public site.** Home, services (six lines of work, each linked to its contracts), a project portfolio with a page per contract (client, value, year, status, scope and links to the published sources), about, a print-styled one-page capability statement with a downloadable PDF, contact and hours, privacy notice, photo credits and a site map. Mobile-first, 17px body text, light and dark themes, and every page and form works without JavaScript. Links from the old WordPress site (`/contact-us`, `/water-works` and the rest) redirect to the new pages.
- **Four intake flows, each with a reference number and an email confirmation.**
  - Invitation to tender / RFQ (`TI-26-00014`): procuring entity, tender title and reference, method, parish, scope, submission deadline (never in the past) with time, site visit and clarification dates, bid security, up to 5 documents (PDF, Word, Excel, ZIP) or a GOJEP link.
  - Subcontractor and supplier prequalification (`PQ-…`): company, TRN (9 digits), trades, parishes served, and the TCC, NCC/PPC registration (subcontractors) and public liability insurance, each with its number and expiry date. Expired certificates are refused.
  - Job application (`JA-…`): for a posted opening or a general application. Site roles need only a phone number; professional and office roles must attach a CV.
  - Contact form (`EN-…`).
  All uploads go to the private `local` disk (`storage/app/private/{tenders,vendors,cvs,rooms}`), never the public web root. If a form comes back with an error, the files that passed are kept (`storage/app/private/held`, keyed to the visitor's session, shown as "Attached: …") so nobody attaches them twice; leftovers are pruned after 24 hours.
- **Certificate renewals.** `php artisan app:remind-expiring` (scheduled daily at 07:00 Jamaica time) emails each prequalified vendor whose certificate expires within 30 days a signed link to upload the renewed copy. The link works for 30 days and only until the certificates it was sent for have been renewed, and not for a vendor who has been declined. The old copy is kept as superseded.
- **Client document rooms.** Staff create a room per contract, upload drawings, reports, programmes, minutes and certificates, and share a signed link that expires after 7, 30 or 90 days. Revoking rotates the room's key, so every link already sent stops working. Pages and downloads are `noindex` and `no-referrer`, and downloads are counted.
- **Back office** at `/admin`, with four roles:
  - **Admin**: everything, including staff accounts.
  - **Estimating / tenders**: the tender register, enquiries and client document rooms.
  - **Procurement**: the prequalification register and certificates.
  - **HR**: applications, CVs and job postings.

  The overview leads with the one number for the signed-in role: tender submissions due in the next 7 days (estimating and admin), certificates expired or expiring within 30 days on prequalified vendors (procurement), or applications waiting more than 3 days (HR). Then tiles, a weekly chart and the bid pipeline. Each register has status tabs, filters, search (press `/`) and CSV export (formula-safe). Every record has a notes timeline. A vendor cannot be prequalified while a required certificate is missing or expired, and certificates are marked checked by a named officer. Every opening of a private file is logged.

## Requirements

PHP 8.3 or 8.4, Composer 2, Node 20+ for building assets (and Chrome for the capability PDF and proposal), and SQLite locally or MySQL in production.

## Local setup

```sh
composer install
cp .env.example .env && php artisan key:generate
php artisan migrate --seeder=DemoSeeder   # demo staff, 14 tenders, 12 vendors, 5 postings, 22 applications, 2 document rooms
npm install && npm run build
php artisan serve --port=8110
npm run capability                        # optional: public/downloads/YP-Seaton-Capability-Statement.pdf
```

Demo logins all use the password `password`: `admin@ypseaton.test`, `estimating@ypseaton.test`, `procurement@ypseaton.test`, `hr@ypseaton.test` (and `qs@ypseaton.test`, a second estimator). Every demo organisation, tender, vendor and applicant is fictional and marked "(sample)". `DatabaseSeeder` only creates the first admin from `ADMIN_*`.

## Checks

```sh
php artisan test                 # feature tests for every flow, role, policy and private document
vendor/bin/phpstan analyse       # Larastan level 6, analysed as PHP 8.3
vendor/bin/pint --test
```

The suite also passes on MySQL (`DB_CONNECTION=mysql … php artisan test`).

## Deploying

See [INSTALL-HOSTINGER.md](INSTALL-HOSTINGER.md). `scripts/package-hostinger.sh` builds `dist/yps-hostinger.zip`, which extracts straight into `public_html/`, with the app in `yps-app/`. One cron job (`schedule:run` every minute) is needed for the renewal reminders. Mail for ypseaton.com is on Microsoft 365, so send through an M365 mailbox and leave the MX and SPF records alone when pointing the domain at Hostinger.

## Proposal

With the dev server on 8110 and demo data loaded, `npm run proposal` captures every screen and builds `dist/proposal/YP-Seaton-Website-Proposal.pdf` (Letter; the build fails if it is over 9.5 MB).

## Before launch: confirm with the client

- **Contact details.** The phone comes from the old site, which printed "923-5491-5" (read here as lines 923-5491 to 5495) and, in 2022, +1 (876) 923-5491. Fax (876) 923-5788 and the hours (Monday to Thursday 8:30–5:30, Friday 8:30–4:30) are from the 2015–2019 site only; weekend hours were never published, so none are shown. `info@ypseaton.com` has a working mail route (MX to Microsoft 365, SPF for Outlook, checked 26 October 2026), but the mailbox itself was not tested. The old footer also listed `seaton@cwjamaica.com`; it is not used.
- **The principal.** Shown as "York Seaton, Managing Director", as the UDC named him in April 2015. That he is the "Y.P." of the firm's name is not stated by any source, so it is not shown. The PIOJ named a different director as signatory of the 2020 Buff Bay contract. Confirm the name and title he wants used. No other staff are named.
- **Founding date.** 1969 is from both versions of the firm's site. A directory gives 13 February 1969; not used.
- **Projects.** Every contract is from a dated public source and is labelled with what the source confirms. Only Aston Ridge Road is reported as completed; confirm completion (and final values) for the others:
  - Norman Manley airport shoreline protection: J$555.9M, Cabinet approval 2021 (Observer), works under way November 2021 (CVM).
  - Caymanas Estate sewage conveyance: J$624M, signed 28 April 2015 (UDC). The Gleaner headline says J$600M.
  - Whitehall Phase 2 housing infrastructure: JIS printed "$283,737,461 million"; shown as J$283.7M. JIS says the scheme is developed by the Housing Agency of Jamaica, shown as the client.
  - Seven Rivers irrigation: approved by Cabinet (JIS, February 2004).
  - Annotto Bay shoreline (J$179.5M, 2021), Buff Bay shoreline (J$40.9M, 2020), Stokes Hall biodigester (about J$47.7M, 2014), Seven Rivers irrigation (J$23.8M, 2004).
  - Aston Ridge Road retaining wall: J$9.6M final against a revised J$10.5M. The ministry page was posted in January 2015 but describes a tour on 20 June after Tropical Storm Gustav (August 2008), so the work was finished by June 2009; no year is shown until confirmed. The client is not stated (NWA officials led the tour).
  - The NMIA sources: the Observer item is a post-Cabinet roundup headlined about another contract, and the CVM report covers Port Royal utility outages during the works. Both are factual and name the firm, but the firm may prefer other citations (for example the OPM post-Cabinet report for 13 April 2021).
- **Not listed until confirmed:** the Rio Cobre Dam (Mr Seaton's own mention in the UDC's April 2015 release; no independent source), Bank of Jamaica works (the 2022 site's only photo is titled "BOJ Completion Photo"), an NWA contract at Woodhall–Belfield (search summary only; the page was gone), and the "35 government contracts worth J$2.7 billion, 2001–2010" figure (left out because of the context it was reported in).
- **Services.** The service lines are the firm's own (2014–2019 site); the items under them are limited to what the firm's site or a project source describes. Add rock armour, sea walls, culverts or river works only if the firm confirms them.
- **"Combined published value".** The capability statement adds the eight published contract sums (J$1.77 billion). It mixes Cabinet approvals, signed contracts and one final cost across 2004–2021. Confirm the firm is happy with that line, or drop it.
- **Certifications.** No NCC/PPC registration category or grade was found publicly, so none is claimed. Ask for it, and for the firm's actual prequalification requirements (the document list on `/prequalification` is a reasonable default).
- **The "partnerships with international companies"** on the old site are unnamed; not repeated.
- **Logo.** The header redraws the gold "YPS" hexagon from the 2014–2019 logo as SVG. Ask for the vector artwork.
- **Photos.** The Bank of Jamaica photo on `/about` is the firm's own (2022 site). Every other photo is from Wikimedia Commons (credited on `/photo-credits`), shows no Y.P. Seaton project, and is labelled illustrative on project pages. Replace them with the firm's site photos.
- **Privacy notice and retention periods** (12 months for applications) need the firm's sign-off.
- **Inboxes** for `YPS_NOTIFY_*`, the staff list and their roles.
