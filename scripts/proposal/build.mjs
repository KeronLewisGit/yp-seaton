// Builds the client proposal (letter-size PDF) from the captured screenshots, in the site's own
// palette and fonts (sea, teal and gold; Epilogue and Libre Franklin).
// Usage: npm run proposal (or node scripts/proposal/build.mjs after a capture).
import puppeteer from 'puppeteer-core';
import fs from 'node:fs';
import path from 'node:path';

const CHROME = process.env.CHROME_PATH ?? '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome';
const ROOT = path.resolve('.');
const SHOTS = path.resolve('dist/proposal/shots');
const chunks = JSON.parse(fs.readFileSync(path.join(SHOTS, 'chunks.json'), 'utf8'));
const OUT_HTML = path.resolve('dist/proposal/proposal.html');
const OUT_PDF = path.resolve('dist/proposal/YP-Seaton-Website-Proposal.pdf');
const MAX_MB = 9.5;
const DATE = new Date().toLocaleDateString('en-GB', { day: 'numeric', month: 'long', year: 'numeric' });
const TESTS = process.env.TEST_COUNT ?? '70';
const img = (f) => 'file://' + f;
const esc = (s) => String(s).replace(/&/g, '&amp;').replace(/</g, '&lt;');

// The site's self-hosted fonts (built by the Vite fonts plugin into public/build/assets).
const ASSETS = path.join(ROOT, 'public/build/assets');
const font = (prefix) => {
  const f = fs.readdirSync(ASSETS).find((n) => n.startsWith(prefix) && n.endsWith('.woff2'));
  if (!f) throw new Error(`Font ${prefix} not found in public/build/assets; run npm run build first.`);
  return 'file://' + path.join(ASSETS, f);
};
const FONTS = [
  ['Epilogue', 700, 'epilogue-700-normal'], ['Epilogue', 800, 'epilogue-800-normal'],
  ['Libre Franklin', 400, 'libre-franklin-400-normal'], ['Libre Franklin', 500, 'libre-franklin-500-normal'],
  ['Libre Franklin', 600, 'libre-franklin-600-normal'], ['Libre Franklin', 700, 'libre-franklin-700-normal'],
].map(([fam, w, p]) => `@font-face { font-family: "${fam}"; font-weight: ${w}; font-style: normal; src: url("${font(p)}") format("woff2"); }`).join('\n');

// The site's redrawn YPS hexagon (after the gold badge on the firm's old logo).
const MARK = (h = 34, ring = '#10232a') => `<span class="mark"><svg viewBox="0 0 48 48" width="${h}" height="${h}"><path d="M24 2 43 13v22L24 46 5 35V13z" fill="#f2c14e" stroke="${ring}" stroke-width="2.5"/><text x="24" y="28.6" text-anchor="middle" font-family="Epilogue" font-weight="800" font-size="12.5" fill="#10232a">YPS</text></svg></span>`;
const WORDMARK = (dark = true) => `<div class="brand">${MARK(dark ? 42 : 32, dark ? '#ffffff' : '#10232a')}<div><span class="n ${dark ? '' : 'ink'}">Y.P. Seaton</span><span class="s ${dark ? '' : 'ink'}">&amp; Associates · Kingston · Since 1969</span></div></div>`;
const plate = (code, label, dark = false) => `<p class="plate ${dark ? 'dark' : ''}"><span class="c">${esc(code)}</span><span class="l">${esc(label)}</span></p>`;

/** Hand-written captions per slice (key = screen name, index = slice number), from what each slice shows. */
const CAPTIONS = {
  home: [
    'Hero on a rock-revetment photograph, the two actions a procurement officer needs (invite us to tender, download the capability statement) and a title block with the firm\'s founding year, office and telephone. Below it, four figures from the public record, each traced to its source.',
    'The six lines of work, from the firm\'s own service descriptions and the contracts on record.',
    'Featured contracts with value and year as published, then the three things a tender panel can do here.',
    'Subcontractor prequalification and careers, office hours and contact, and the footer.',
  ],
  services: [
    'Services: each line of work with what it covers and, on the right, the contracts on the public record that show it.',
    'Housing infrastructure, roads and drainage, building, and electrical and mechanical engineering (where the firm began in 1969).',
    'Closing call to action: send the invitation to tender.',
  ],
  projects: [
    'Project portfolio header: only contracts that ministries, agencies or the press published under the firm\'s name.',
    'Eight contracts, filterable by sector, each with value and year only where the source states them.',
  ],
  project: [
    'A project page (Norman Manley airport shoreline protection): client, value, year and status in the title block, the scope of works and links to the Jamaica Observer and CVM sources.',
    'A tender call to action and related projects in the same sector.',
  ],
  about: [
    'About: the firm\'s own history and mission from its archived website, the Managing Director as named by the UDC, and a timeline built from the dated contracts.',
    'Links to the capability statement and contact.',
  ],
  capability: [
    'The one-page capability statement, built from the same facts as the website: services, contracts, values and sources. It prints to Letter and downloads as a PDF.',
    'The contract table continues with every source, then how to work with the firm and contact details.',
  ],
  contact: ['Contact: telephone lines, email, address, office hours from the old site, and a message form that issues an EN- reference.'],
  tender: [
    'Invite us to tender: the header explains who it is for and what happens next.',
    'Procuring entity, then the tender itself: title, reference, method, parish and scope. The side panel offers the capability statement.',
    'Key dates (deadline, site visit, clarifications), bid security, and up to five tender documents or a GOJEP link.',
  ],
  prequal: [
    'Subcontractor and supplier prequalification: what to have ready, and the renewal promise.',
    'Company details with the TRN (checked as nine digits) and the contact person.',
    'Trades and supply categories, and the parishes the vendor works in.',
    'Certificates: TCC, NCC/PPC registration (subcontractors only) and public liability insurance, each with its number and expiry date. Expired certificates are refused.',
    'Declaration and consent, then submit.',
  ],
  careers: [
    'Careers: openings by type of work (sample postings here), with location, employment type and closing date.',
    'Why apply, including the firm\'s stated commitment to training young people.',
  ],
  apply: [
    'Job application: site roles apply with a phone number; engineering, QS and office roles must attach a CV.',
    'About the applicant, CV upload and consent.',
  ],
  room: ['A client\'s private project-document page, opened from a signed link that expires. Drawings, reports, minutes and certificates are grouped, and every download is counted.'],
  'admin-login': ['Staff sign-in. Accounts that have been switched off are refused and signed out.'],
  'admin-dashboard': [
    'Overview for an administrator or estimator: the number of tender submissions due in the next seven days comes first, with the closing-soonest list. Figures are from the demo data.',
    'Tiles for every area, tender deadlines by week, and the bid pipeline.',
  ],
  'admin-dashboard-procurement': ['The same overview signed in as procurement: it leads with certificates that have expired or expire within 30 days.'],
  'admin-tenders': [
    'Tender register: open tenders first, ordered by deadline, with status tabs, sector and estimator filters, search and CSV export.',
    'Every invitation with its entity, deadline countdown, status and estimator.',
  ],
  'admin-tender': ['A tender: deadline, method and documents, the bid / no-bid decision and estimator, one-tap call to the procuring entity, and a timeline of every change.'],
  'admin-vendors': [
    'Prequalification register: vendors by status with their certificate state (valid, expiring, expired, missing).',
    'Filters by type and trade, and a "needs renewal" view.',
  ],
  'admin-vendor': [
    'A vendor: each certificate with its number and expiry, opened privately and marked as checked. A vendor cannot be prequalified while a required certificate is missing or expired.',
    'Company details, trades and parishes, and the timeline, including renewal reminders.',
  ],
  'admin-applications': [
    'Applications: status tabs, type of work, posting, "waiting over 3 days" and search.',
    'Each applicant with position, experience, CV and status.',
  ],
  'admin-application': ['An application: one-tap call, the CV (HR and administrators only, every download logged) and the status.'],
  'admin-room': ['A client document room: upload drawings and reports, create a share link valid for 7, 30 or 90 days, email it to the client, and revoke it at any time.'],
  'admin-users': ['Staff accounts with four roles: administrator, estimating and tenders, procurement, and HR.'],
};

/** Screen definitions: section, key, title, bullets. */
const SECTIONS = [
  { id: 'public', eyebrow: 'Part 1', code: '01', title: 'The public website', intro: 'A new ypseaton.com, written from the firm\'s own archived website and from contracts that ministries, agencies and the press have published. Every inner page opens with the same harbour-blue header and drawing title block, and every page works on a phone.', screens: [
    ['home', 'Home page', ['Leads with what the firm builds and the two actions a procurement officer needs.', 'Four figures from the public record, each with its source one click away.']],
    ['services', 'Services', ['Six lines of work, each linked to the contracts that show it.', 'Old addresses such as /water-works and /contact-us redirect to the new pages.']],
    ['projects', 'Project portfolio', ['Only sourced contracts. A value or year appears only where a source states it; an award is never presented as a completion.']],
    ['project', 'Project page', ['One page per contract with client, value, year, status, scope and links to the sources.']],
    ['about', 'About the firm', ['The 1969 story and the mission in the firm\'s own words.']],
    ['capability', 'Capability statement', ['A printable one-page statement that updates itself whenever a project is added, plus a downloadable PDF.']],
    ['contact', 'Contact', ['Telephone, email, address, hours and a message form.']],
  ]},
  { id: 'flows', eyebrow: 'Part 2', code: '02', title: 'Tenders, suppliers and people', intro: 'Four intake flows replace the phone tag that follows a tender notice: invitations to tender, subcontractor and supplier prequalification, job applications and messages. Each gives the sender a reference number on screen and by email and lands in the right team\'s register. A fifth, private flow shares project documents with clients.', screens: [
    ['tender', 'Invite us to tender', ['Deadlines are checked (never in the past) and shown as a countdown in the register.', 'Tender documents are stored privately, outside the public website.']],
    ['prequal', 'Prequalification', ['TCC, NCC/PPC registration and insurance with their expiry dates.', 'Thirty days before a certificate expires, the vendor is emailed a signed renewal link and uploads the new copy themselves.']],
    ['careers', 'Careers', ['Openings posted by HR, with Google job-posting data so they appear in job search.']],
    ['apply', 'Job application', ['No CV needed for site roles; required for engineering, QS and office roles.']],
    ['room', 'Client project documents', ['A private page per contract for the client\'s project team, on a link that expires and can be revoked.']],
  ]},
  { id: 'admin', eyebrow: 'Part 3', code: '03', title: 'The back office', intro: 'A private, role-based back office for estimating, procurement and HR. Each role sees only its own registers, and the overview opens on the one number that role has to act on today.', screens: [
    ['admin-login', 'Staff sign-in', ['Individual accounts with four roles; switched-off accounts are refused.']],
    ['admin-dashboard', 'Overview', ['Estimating sees tender submissions due in the next seven days first.']],
    ['admin-dashboard-procurement', 'Overview for procurement', ['Procurement sees expiring and expired certificates first.']],
    ['admin-tenders', 'Tender register', ['Bid / no-bid, pricing, submitted, won or lost, with an estimator on every tender.']],
    ['admin-tender', 'Tender detail', ['Documents, decision, estimator and notes in one place, with a full timeline.']],
    ['admin-vendors', 'Prequalification register', ['Every vendor\'s certificate state at a glance.']],
    ['admin-vendor', 'Vendor detail', ['Certificates are checked and dated by a named officer; approval is blocked while one is missing or expired.']],
    ['admin-applications', 'Applications', ['Applicants waiting more than three days are flagged.']],
    ['admin-application', 'Applicant detail', ['CVs open for HR and administrators only.']],
    ['admin-room', 'Client document room', ['Share links are signed, expire, and can be revoked in one click.']],
    ['admin-users', 'Staff and roles', ['Add staff, change roles and switch accounts off.']],
  ]},
];
const SCREEN_COUNT = SECTIONS.reduce((n, s) => n + s.screens.length, 0);

const FEATURES = [
  ['Public website', ['Services linked to contracts', 'Project portfolio, one page per contract', 'Sources on every project', 'Printable capability statement and PDF', 'About and contact', 'Redirects from the old site\'s links', 'Sitemap and Google structured data', 'Phone action bar on every page']],
  ['Intake', ['Invitation to tender with documents', 'Subcontractor and supplier prequalification', 'Certificate expiry tracking and renewal links', 'Careers with job postings', 'Job applications with CV upload', 'Contact form', 'Reference number on screen and by email', 'Alert email to each team\'s inbox']],
  ['Back office', ['Overview that leads with each role\'s number', 'Tender register with deadlines and bid status', 'Prequalification register and certificate checks', 'Applications and job postings', 'Client document rooms with signed links', 'Notes and a timeline on every record', 'CSV exports', 'Four staff roles']],
  ['Platform', ['Laravel 13 on PHP 8.3', 'HTTPS throughout', 'All uploads stored privately', 'Each team opens only its own files', 'Rate-limited, spam-protected forms', 'Light and dark themes', `${TESTS} automated tests`, 'Packaged for one-zip installation']],
];

/**
 * Pack a screen's slices onto pages. A slice's height ÷ width is its share of a page. Every slice keeps
 * its own caption; slices never break across pages and keep their order. The layout is chosen by cost:
 * one point per page, one more for a page left about a third empty, half a point for shrinking slices
 * below 90% of a 1440px screen to share a page (never below 85%), and a quarter point for moving the
 * bullets off the first page. So a short slice joins its neighbour instead of sitting alone on a
 * half-blank page; ties go to the layout whose emptiest page is fullest.
 */
function pages(c, hasBullets) {
  const sizes = c.sizes ?? c.chunks.map(() => [1440, 1440]);
  // Page capacity as image height ÷ text width: about 1.22 below the heading, 0.98 when bullets sit on top.
  // The estimate leaves out caption height, so a page counts as gappy at 25% estimated (about 35% printed).
  const CAP = 0.08, GOOD_SCALE = 0.9, MIN_SCALE = 0.85, GAP = 0.25;
  const ratios = sizes.map(([w, h]) => h / w);
  const page = (from, to, bullets) => {
    const budget = bullets ? 0.98 : 1.22;
    const sum = ratios.slice(from, to).reduce((a, r) => a + r, 0);
    const n = to - from;
    const scale = Math.min(1, (budget - CAP * n) / sum);
    const readable = scale * 1440 / sizes[from][0]; // narrower captures carry larger type
    if (n > 1 && readable < MIN_SCALE) return null;
    const empty = 1 - (sum * scale + CAP * n) / budget;
    return { items: [...Array(n).keys()].map((k) => from + k), bullets, budget, scale, empty, cost: 1 + (empty > GAP ? 1 : 0) + (readable < GOOD_SCALE ? 0.5 : 0) + (bullets && from > 0 ? 0.25 : 0) };
  };
  // best(i, owed) = cheapest packing of slices i..end, where owed means the bullets still need a page.
  const n = ratios.length;
  const memo = new Map();
  const best = (i, owed) => {
    if (i === n) return owed ? null : { list: [], cost: 0, worst: 0 };
    const key = i + ':' + owed;
    if (memo.has(key)) return memo.get(key);
    let pick = null;
    for (const here of owed ? [true, false] : [false]) {
      for (let j = i + 1; j <= n; j++) {
        const pg = page(i, j, here);
        if (!pg) break;
        const rest = best(j, owed && !here);
        if (!rest) continue;
        const cand = { list: [pg, ...rest.list], cost: pg.cost + rest.cost, worst: Math.max(pg.empty, rest.worst) };
        if (!pick || cand.cost < pick.cost - 1e-9 || (Math.abs(cand.cost - pick.cost) < 1e-9 && cand.worst < pick.worst - 1e-9)) pick = cand;
      }
    }
    memo.set(key, pick);
    return pick;
  };
  return best(0, hasBullets).list;
}

function caption(key, i, c) {
  const text = CAPTIONS[key]?.[i];
  if (!text) return '';
  const n = c.chunks.length > 1 ? `${i + 1}/${c.chunks.length} · ` : '';
  return `<figcaption class="cap"><span class="n">${esc(n)}</span>${esc(text)}</figcaption>`;
}

function screenPages(sec, [key, title, bullets]) {
  const c = chunks[key];
  if (!c) throw new Error(`Screenshot missing: ${key}`);
  return pages(c, bullets.length > 0).map((p, pi) => `
    <section class="page shot">
      <header class="shot-head">
        <div><p class="eyebrow">${esc(sec.title)}${pi ? ' · continued' : ''}</p><h2>${esc(title)}</h2></div>
        <p class="url">${esc(c.url)}</p>
      </header>
      ${p.bullets ? `<ul class="bullets">${bullets.map((b) => `<li>${esc(b)}</li>`).join('')}</ul>` : ''}
      ${p.items.map((i) => `<figure><img style="width:${(p.scale * 100).toFixed(1)}%" src="${img(c.chunks[i])}" alt="${esc(title)}">${caption(key, i, c)}</figure>`).join('')}
      ${foot()}
    </section>`).join('');
}

const foot = () => `<footer class="foot"><span class="fl">${MARK(14)}Y.P. Seaton &amp; Associates · Website proposal</span><span>Code Canvas Consultants Ltd · ${esc(DATE)}</span></footer>`;
const notes = (list) => `<div class="phone-notes">${list.map(([t, d]) => `<div><b>${esc(t)}</b>${esc(d)}</div>`).join('')}</div>`;
const phones = (list) => `<div class="phones">${list.map(([k, c]) => `<figure><img src="${img(chunks[k].chunks[0])}" alt="${esc(c)}"><figcaption>${esc(c)}</figcaption></figure>`).join('')}</div>`;

const html = `<!doctype html><html lang="en"><head><meta charset="utf-8"><title>Y.P. Seaton &amp; Associates – Website Proposal</title>
<style>

  ${FONTS}
  @page { size: Letter; margin: 0.5in 0.6in 0.55in; }
  :root { --graphite: #0a2730; --graphite-950: #071c23; --gm: #123844; --bg: #f4f3ef; --surface-2: #e9e7e0; --ink: #10232a; --ink-2: #33494f; --ink-3: #4d6268; --line: #d3d7d2; --coral: #f2c14e; --coral-text: #0d6a73; --coral-soft: #e4f0ef; --green: #1f7a43; }
  * { box-sizing: border-box; }
  html, body { margin: 0; padding: 0; font-family: "Libre Franklin", system-ui, sans-serif; color: var(--ink); font-size: 10.5pt; line-height: 1.45; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
  h1, h2, h3, .display { font-family: "Epilogue", system-ui, sans-serif; font-weight: 700; letter-spacing: -0.03em; color: var(--ink); margin: 0; line-height: 1.05; }
  h3 { font-family: "Libre Franklin", system-ui, sans-serif; letter-spacing: 0; font-size: 12pt; }
  .page { page-break-after: always; break-after: page; height: 9.95in; display: flex; flex-direction: column; overflow: hidden; }
  .page:last-child { page-break-after: auto; }
  .eyebrow { font-size: 8pt; font-weight: 700; letter-spacing: .16em; text-transform: uppercase; color: var(--coral-text); margin: 0 0 5px; }
  .muted { color: var(--ink-3); }
  /* number-plate label, as on the site */
  .plate { align-self: flex-start; display: inline-flex; border: 1.5px solid currentColor; border-radius: 3px; padding: 2px; font-size: 7.5pt; font-weight: 700; letter-spacing: .14em; text-transform: uppercase; line-height: 1; color: var(--ink-2); margin: 0 0 12px; }
  .plate span { display: inline-flex; align-items: center; padding: 5px 7px 4px; border-radius: 3px; }
  .plate .c { background: var(--ink); color: var(--bg); font-family: "Epilogue"; font-weight: 800; letter-spacing: .04em; }
  .plate .l { box-shadow: inset 0 0 0 1px rgba(0,0,0,.18); margin-left: 2px; }
  .plate.dark { color: rgba(255,255,255,.85); } .plate.dark .c { background: var(--coral); color: var(--graphite); } .plate.dark .l { box-shadow: inset 0 0 0 1px rgba(255,255,255,.28); }
  .ticks { height: 6px; background: linear-gradient(var(--green), var(--green)) top / 100% 3px no-repeat, linear-gradient(var(--coral), var(--coral)) bottom / 100% 3px no-repeat; }
  /* cover and dividers: the site's graphite hero band */
  .dark-page { background: var(--graphite); color: #fff; border-radius: 3px; padding: 0.6in 0.6in 0.5in; position: relative; overflow: hidden; }
  .dark-page h1 { color: #fff; }
  .cover { justify-content: space-between; background-image: linear-gradient(180deg, rgba(7,28,35,.5), rgba(7,28,35,.95) 62%), url("${img(path.join(ROOT, 'public/img/revetment-1920.webp'))}"); background-size: cover; background-position: 40% 0; }
  .cover h1 { font-size: 40pt; margin: 14px 0 16px; max-width: 6.2in; }
  .cover .accent { color: var(--coral); }
  .cover .lead { color: rgba(255,255,255,.85); font-size: 13pt; max-width: 5.8in; margin: 0; }
  .cover .meta { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; border-top: 1px solid rgba(255,255,255,.18); padding-top: 16px; font-size: 9.5pt; color: rgba(255,255,255,.8); }
  .cover .meta b { display: block; color: #fff; font-size: 9pt; letter-spacing: .14em; text-transform: uppercase; margin-bottom: 4px; }
  .brand { display: flex; align-items: center; gap: 10px; } .brand .n { display: block; font-family: "Epilogue"; font-weight: 700; font-size: 17pt; color: #fff; line-height: 1; letter-spacing: -0.02em; } .brand .s { display: block; margin-top: 4px; font-size: 7pt; font-weight: 600; letter-spacing: .16em; text-transform: uppercase; color: rgba(255,255,255,.7); }
  .mark { display: inline-flex; align-items: center; flex: none; background: #fff; border-radius: 5px; } .mark img { display: block; width: auto; }
  .brand .ink { color: var(--ink); } .brand .s.ink { color: var(--ink-3); }
  .divider { justify-content: center; }
  .divider h1 { font-size: 38pt; margin: 6px 0 18px; } .divider p.intro { color: rgba(255,255,255,.85); font-size: 12.5pt; max-width: 6in; margin: 0; }
  .divider ol { color: rgba(255,255,255,.85); columns: 2; font-size: 10pt; margin: 26px 0 0; padding-left: 18px; } .divider li { break-inside: avoid; margin: 3px 0; }
  .divider .note { margin-top: 22px; font-size: 9pt; color: rgba(255,255,255,.65); max-width: 6in; }
  .divider .ticks, .cover .ticks { position: absolute; left: 0; right: 0; bottom: 0; }
  /* text pages */
  .prose h1 { font-size: 24pt; margin-bottom: 12px; }
  .prose h2 { font-size: 13pt; margin: 16px 0 6px; letter-spacing: -0.01em; }
  .prose p { margin: 0 0 8px; }
  .prose ul.plain { margin: 0 0 8px; padding-left: 16px; } .prose ul.plain li { margin: 2px 0; }
  .cols { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
  .card { border: 1px solid var(--line); border-radius: 3px; padding: 11px 13px; background: #fff; break-inside: avoid; }
  .card h3 { margin-bottom: 5px; }
  .card ul { margin: 0; padding-left: 15px; } .card li { margin: 2px 0; font-size: 9.6pt; }
  .evidence { border-left: 4px solid var(--coral-text); background: var(--bg); border-radius: 0 10px 10px 0; padding: 10px 14px 10px 30px; margin: 8px 0 10px; }
  .evidence li { margin: 3px 0; }
  .src { font-size: 8pt; color: var(--ink-3); }
  .stat-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin: 12px 0 6px; }
  .stat { background: var(--graphite); color: #fff; border-radius: 3px; padding: 12px 12px 11px; }
  .stat b { display: block; font-family: "Epilogue"; font-weight: 800; font-size: 22pt; line-height: 1; letter-spacing: -0.03em; color: #fff; border-left: 3px solid var(--coral); padding-left: 8px; }
  .stat span { display: block; margin-top: 8px; font-size: 8.5pt; color: rgba(255,255,255,.78); line-height: 1.3; }
  table.feat { width: 100%; border-collapse: collapse; font-size: 9.5pt; }
  table.feat th, table.feat td { border-bottom: 1px solid var(--line); padding: 8px 8px; text-align: left; vertical-align: top; }
  table.feat th { background: var(--surface-2); font-size: 8pt; text-transform: uppercase; letter-spacing: .1em; color: var(--ink-3); }
  .pill-row { display: flex; flex-wrap: wrap; gap: 5px; } .pill { border: 1px solid #a9cfcc; background: var(--coral-soft); color: var(--coral-text); border-radius: 3px; padding: 2px 9px; font-size: 8.5pt; font-weight: 600; }
  /* screenshot pages */
  .shot-head { display: flex; justify-content: space-between; align-items: flex-end; gap: 12px; border-bottom: 2px solid var(--ink); padding-bottom: 6px; margin-bottom: 7px; }
  .shot-head h2 { font-size: 16pt; } .url { font-family: Menlo, Consolas, monospace; font-size: 8pt; color: var(--ink-3); margin: 0; white-space: nowrap; }
  .bullets { margin: 0 0 7px; padding-left: 16px; font-size: 9.3pt; } .bullets li { margin: 1px 0; } .bullets li::marker { color: var(--coral-text); }
  figure { margin: 0 0 8px; display: block; text-align: center; }
  figure img { display: block; margin: 0 auto; border: 1px solid var(--line); border-radius: 3px; }
  .cap { text-align: left; margin: 5px 0 0; font-size: 8.6pt; line-height: 1.35; color: var(--ink-2); border-left: 3px solid var(--coral-text); padding-left: 8px; }
  .cap .n { font-weight: 700; color: var(--ink-3); }
  .phones { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-top: 12px; }
  .phones figure { margin: 0; }
  .phones img { width: 100%; border-radius: 3px; border: 7px solid var(--graphite); }
  .phone-notes { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-top: 14px; }
  .phone-notes div { background: var(--bg); border-radius: 3px; padding: 9px 12px; font-size: 9pt; color: var(--ink-2); }
  .phone-notes b { display: block; color: var(--ink); font-size: 9.5pt; margin-bottom: 2px; }
  .phones figcaption { text-align: center; font-size: 9pt; color: var(--ink-2); margin-top: 6px; font-weight: 600; }
  /* investment */
  .price { display: grid; grid-template-columns: 1.45fr 1fr; gap: 14px; align-items: stretch; margin: 6px 0 4px; }
  .price .big { background: var(--graphite); color: #fff; border-radius: 3px; padding: 16px 18px; }
  .price .big .amt { white-space: nowrap; font-family: "Epilogue"; font-weight: 700; font-size: 26pt; line-height: 1; color: #fff; } .price .big .amt small { font-size: 11pt; font-weight: 500; color: rgba(255,255,255,.75); }
  .price .big p { color: rgba(255,255,255,.82); margin: 8px 0 0; font-size: 9.6pt; }
  .price .year { border: 2px solid var(--coral-text); border-radius: 3px; padding: 14px 16px; background: var(--coral-soft); }
  .price .year div { display: flex; justify-content: space-between; gap: 8px; padding: 4px 0; border-bottom: 1px dotted #8fbdb9; font-size: 10pt; } .price .year div:last-child { border: 0; }
  .price .year b { font-family: "Epilogue"; font-weight: 700; }
  .terms li { margin: 3px 0; font-size: 9.6pt; }
  .sla { width: 100%; border-collapse: collapse; font-size: 9pt; margin-top: 4px; } .sla td, .sla th { border-bottom: 1px solid var(--line); padding: 4px 6px; text-align: left; } .sla th { font-size: 7.8pt; letter-spacing: .1em; text-transform: uppercase; color: var(--ink-3); background: var(--surface-2); }
  .weeks { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin: 6px 0 10px; }
  .week { border: 1px solid var(--line); border-radius: 3px; padding: 10px 12px; background: #fff; }
  .week b { display: inline-block; font-family: "Epilogue"; font-weight: 700; font-size: 8.5pt; background: var(--ink); color: var(--bg); border-radius: 4px; padding: 3px 6px; margin-bottom: 5px; }
  .week p { margin: 0; font-size: 9.5pt; }
  footer.foot { margin-top: auto; padding-top: 6px; font-size: 7.8pt; color: #8a939d; display: flex; justify-content: space-between; border-top: 1px solid var(--line); align-items: center; } footer.foot .fl { display: inline-flex; align-items: center; gap: 6px; }

  .phones img { border-radius: 14px; }
  .dark-page { border-radius: 0; }

</style></head><body>

<section class="page dark-page cover">
  ${WORDMARK()}
  <div>
    ${plate('YPS', 'Website proposal · ' + DATE, true)}
    <h1>Be found, prequalified and invited <span class="accent">before the tender closes.</span></h1>
    <p class="lead">A new ypseaton.com with a project portfolio and capability statement built from the public record, online invitations to tender, subcontractor prequalification with certificate tracking, careers, private client document rooms, and a back office for estimating, procurement and HR.</p>
  </div>
  <div class="meta">
    <div><b>Prepared for</b>Y.P. Seaton &amp; Associates Company Limited<br>52c Molynes Road<br>Kingston 10, Jamaica</div>
    <div><b>Prepared by</b>Keron Lewis, Code Canvas Consultants Ltd<br>Port of Spain · codecanvastt.com<br>info@codecanvastt.com</div>
  </div>
  <div class="ticks"></div>
</section>

<section class="page prose">
  ${plate('01', 'Executive summary')}
  <h1>Why rebuild now</h1>
  <p>Y.P. Seaton &amp; Associates has been contracting in Jamaica since 1969, and its name is on public works the island depends on: Cabinet approved a J$555.9 million contract for shoreline protection at Norman Manley International Airport in 2021, and the UDC signed a J$624 million sewage conveyance contract at Caymanas Estate in 2015. Ministries, agencies and developers who search for the firm today find none of that. When we checked on 26 October 2026:</p>
  <ul class="evidence">
    <li><b>ypseaton.com does not load.</b> It returns an HTTP 404 page reading "Squarespace - Website Expired".</li>
    <li><b>Before it expired, the site was a single page.</b> The April 2022 version (Wayback Machine) had one photograph, an about section and contact details: no projects, no services detail and no capability statement.</li>
    <li><b>The track record exists only in other people's pages:</b> Cabinet briefings, JIS, the UDC, the PIOJ and the newspapers. A procurement officer has to piece it together.</li>
  </ul>
  <p class="src">Sources: ypseaton.com, checked 26 October 2026; Wayback Machine snapshots of ypseaton.com, 2015–2022; Jamaica Observer, 14 April 2021; Urban Development Corporation, 28 April 2015.</p>
  <p>This proposal replaces the expired site with one built for a tender-driven contractor: a sourced project portfolio and a capability statement a panel can download, an invitation-to-tender form that issues a reference number, prequalification that tracks every subcontractor's TCC, NCC/PPC registration and insurance, careers for site and office roles, and private document rooms for clients. A working demo is built and can be shown live, on a laptop or a phone.</p>
  <div class="stat-grid">
    <div class="stat"><b>${SCREEN_COUNT}</b><span>screens designed, built and shown in this proposal</span></div>
    <div class="stat"><b>8</b><span>sourced contracts in the portfolio, each with its own page</span></div>
    <div class="stat"><b>4</b><span>staff roles, each seeing only its own registers</span></div>
    <div class="stat"><b>${TESTS}</b><span>automated tests run before every release</span></div>
  </div>
  <h2>What the firm gains</h2>
  <div class="cols">
    <div class="card"><h3>Clients and procuring entities</h3><ul><li>A credible first impression when they look the firm up</li><li>The capability statement in one click</li><li>Tender invitations acknowledged with a reference number</li></ul></div>
    <div class="card"><h3>Estimating, procurement and HR</h3><ul><li>Every tender deadline in one register, with a seven-day warning</li><li>Certificates that remind vendors before they expire</li><li>Applicants by trade, with CVs kept private</li></ul></div>
  </div>
  ${foot()}
</section>

<section class="page prose">
  ${plate('02', 'At a glance')}
  <h1>What is included</h1>
  <table class="feat"><thead><tr><th style="width:20%">Area</th><th>Features</th></tr></thead><tbody>
    ${FEATURES.map(([a, f]) => `<tr><td><b>${esc(a)}</b></td><td><div class="pill-row">${f.map((x) => `<span class="pill">${esc(x)}</span>`).join('')}</div></td></tr>`).join('')}
  </tbody></table>
  <h2>How a tender flows</h2>
  <p>A procurement officer at a parish municipal corporation sends an invitation with the bidding documents and a deadline. The form checks the deadline is in the future, issues a reference such as <b>TI-26-00014</b>, emails the officer and alerts the estimating inbox. In the tender register it shows as New with a countdown. An estimator is assigned, records the bid / no-bid decision, moves it to Pricing while subcontractor quotes come in from prequalified vendors, then Submitted, and finally Won or Lost. Seven days before the deadline it moves to the top of the overview.</p>
  <h2>Content and imagery</h2>
  <p>The history, mission and service lines come from the firm's own website as archived between 2015 and 2022. The eight contracts come from the Jamaica Observer, CVM, the UDC, JIS, the PIOJ, the Office of the Prime Minister and the Ministry of Transport. Nothing is invented: no values, awards, certifications, staff or testimonials, and an award is never described as a completion. The photograph of the Bank of Jamaica tower is the firm's own; the construction photographs are licensed from Wikimedia Commons, credited on the site, and labelled as illustrative until the firm supplies its own. Tenders, vendors and applicants in these screenshots are clearly marked samples with fictitious names.</p>
  ${foot()}
</section>

${SECTIONS.map((sec) => `
<section class="page dark-page divider">
  ${plate(sec.code, sec.eyebrow, true)}
  <h1>${esc(sec.title)}</h1>
  <p class="intro">${esc(sec.intro)}</p>
  <ol>${sec.screens.map((s) => `<li>${esc(s[1])}</li>`).join('')}</ol>
  <p class="note">Screens are from the working demo at 1440 pixels wide (back office at 1280). Tenders, vendors, applicants, staff names and figures are sample data.</p>
  <div class="ticks"></div>
</section>
${sec.screens.map((s) => screenPages(sec, s)).join('')}
`).join('')}

<section class="page">
  <header class="shot-head"><div><p class="eyebrow">Responsive design</p><h2>Built for phones first</h2></div><p class="url">390 × 844</p></header>
  <p style="margin:0 0 4px">Site supervisors, subcontractors and job seekers mostly arrive on a phone. Every page adapts to a small screen, and a bar with Call, Email and Invite to tender stays within thumb reach.</p>
  ${phones([['m-home', 'Home'], ['m-project', 'Project page'], ['m-tender', 'Invitation to tender']])}
  ${notes([['Thumb-sized controls', 'Every button and choice is at least 44 pixels tall.'], ['The right keyboard', 'Phone and TRN fields open the number pad; contact fields fill in from the phone\'s saved details.'], ['Light on data', 'Photos are served as WebP in three sizes, so a phone downloads the small one.']])}
  ${foot()}
</section>
<section class="page">
  <header class="shot-head"><div><p class="eyebrow">Responsive design · continued</p><h2>Prequalification and the back office on a phone</h2></div><p class="url">390 × 844</p></header>
  <p style="margin:0 0 4px">A subcontractor can photograph a certificate and upload it from site, and an estimator can check what is due from the road.</p>
  ${phones([['m-prequal', 'Prequalification'], ['m-admin-dashboard', 'Back-office overview'], ['m-admin-vendor', 'Vendor certificates']])}
  ${notes([['Upload from site', 'Certificates can be PDFs or phone photos (JPG or PNG).'], ['Due first', 'The overview opens on what is due this week.'], ['One tap to call', 'Call or email the procuring entity, vendor or applicant from the record.']])}
  ${foot()}
</section>

<section class="page prose">
  ${plate('04', 'Technology, hosting & security')}
  <h1>Built properly, hosted for you</h1>
  <div class="cols">
    <div class="card"><h3>Platform</h3><ul><li>Laravel 13 on PHP 8.3 with a MySQL database: open-source and widely supported, with no proprietary page builder</li><li>Tailwind CSS and Alpine.js; fonts served from your own site, not a third-party font service</li><li>No background servers; emails send directly and one daily task sends certificate reminders</li><li>${TESTS} automated tests cover every form, role, register and private document</li></ul></div>
    <div class="card"><h3>Security and privacy</h3><ul><li>HTTPS enforced, with security headers on every page</li><li>Tender documents, certificates, CVs and client documents are stored outside the public website and served only to signed-in staff with the right role</li><li>Every opening of a private file is logged</li><li>Client and renewal links are signed, expire, and are never indexed</li><li>Forms are rate-limited and spam-trapped; login throttling and individual staff accounts</li></ul></div>
    <div class="card"><h3>Speed and search</h3><ul><li>Responsive WebP photography</li><li>XML sitemap, and schema.org data for the firm and every job posting</li><li>The old WordPress addresses redirect permanently to the new pages</li><li>Accessible: 17px body text, keyboard navigation, labelled forms, contrast checked in light and dark themes, and every form works without JavaScript</li></ul></div>
    <div class="card"><h3>Ownership</h3><ul><li>Your content, photos, domain and data are always yours</li><li>Staff manage tenders, vendors, postings, document rooms and users themselves</li><li>Hosting, backups, monitoring and updates are handled by Code Canvas under the monthly plan</li><li>Your Microsoft 365 email stays exactly where it is</li></ul></div>
  </div>
  <h2>Emails included</h2>
  <p>Every submission sends the sender a confirmation with their reference number and what happens next, and alerts the right team's inbox (estimating, procurement or HR) with a link to the record. Vendors receive renewal reminders 30 days before a certificate expires, and clients receive their document-room link by email. Private files are never attached to emails.</p>
  ${foot()}
</section>

<section class="page prose">
  ${plate('05', 'Investment')}
  <h1>The US$1,000 a month plan</h1>
  <div class="price">
    <div class="big"><div class="amt">US$1,000 <small>per month</small></div><p><b>US$0 for design and development.</b> No setup fee and no deposit. Invoiced in US dollars. Billing starts at the end of the month in which the site launches, prorated for the days it was live; monthly invoices are due within 14 days.</p></div>
    <div class="year"><div><span>Year one</span><b>US$12,000</b></div><div><span>Or prepaid annually (10% off)</span><b>US$10,800</b></div><div><span>Build cost</span><b>US$0</b></div></div>
  </div>
  <div class="cols" style="margin-top:8px">
    <div class="card"><h3>Included every month</h3><ul>
      <li>The complete design and build shown in this proposal</li>
      <li>Managed hosting with CDN and SSL</li>
      <li>Daily backups plus a weekly off-site copy</li>
      <li>Security patches and software updates</li>
      <li>24/7 uptime monitoring</li>
      <li><b>Up to 10 hours a month</b> of content changes and small improvements, such as adding projects</li>
      <li>Staff training</li>
      <li>Google Analytics, Search Console and a monthly summary</li>
      <li>Support by email, WhatsApp and phone, plus a quarterly review call</li>
      <li>A 30-day post-launch warranty</li>
    </ul></div>
    <div class="card"><h3>Terms</h3><ul class="terms">
      <li>No minimum term. 30 days' notice by email from either side.</li>
      <li>Price fixed for the first 24 months.</li>
      <li>Optional annual prepayment at 10% off: US$10,800 a year.</li>
      <li><b>Handover fee US$7,000, only if you leave.</b> It buys the website outright and moves it to hosting in Y.P. Seaton &amp; Associates' name. It is waived if Code Canvas stops trading.</li>
      <li>Your content, domain and data are always yours.</li>
    </ul>
    <h3 style="margin-top:8px">Quoted separately, only with your approval</h3><ul>
      <li>Work beyond 10 hours in a month: US$50 an hour, or a fixed quote</li>
      <li>SMS reminders for tender deadlines or certificate renewals</li>
      <li>Integrations with an estimating, accounting or document-control system</li>
      <li>A full vendor portal with logins; paid advertising and SEO campaigns; professional site photography or drone footage</li>
    </ul></div>
  </div>
  <h2>Service levels</h2>
  <table class="sla"><thead><tr><th>Issue</th><th>Response</th><th>Fix target</th></tr></thead><tbody>
    <tr><td>Site down or forms not sending</td><td>1 hour, any day</td><td>4 hours</td></tr>
    <tr><td>Something on a page is broken</td><td>4 business hours</td><td>1 business day</td></tr>
    <tr><td>Content changes (text, photos, projects, postings)</td><td>Acknowledged in 1 business day</td><td>Done in 2 business days</td></tr>
  </tbody></table>
  ${foot()}
</section>

<section class="page prose">
  ${plate('06', 'Timeline')}
  <h1>Six weeks to launch</h1>
  <div class="weeks">
    <div class="week"><b>Week 1</b><p>Kick-off, brand assets and content: your logo files, project photos and confirmation of every fact on the site.</p></div>
    <div class="week"><b>Week 2</b><p>Revision round 1. Forms, emails and staff roles configured with your real inboxes.</p></div>
    <div class="week"><b>Week 3</b><p>Content load: further projects with their values, open job postings, prequalification requirements.</p></div>
    <div class="week"><b>Week 4</b><p>Revision round 2.</p></div>
    <div class="week"><b>Week 5</b><p>Formal testing with your estimating, procurement and HR staff on every form and screen.</p></div>
    <div class="week"><b>Week 6</b><p>Launch on HTTPS, redirects from the old addresses, Search Console, and staff training.</p></div>
  </div>
  <h2>What we need from Y.P. Seaton &amp; Associates</h2>
  <ul class="plain">
    <li>Your logo as a vector file (the demo redraws the YPS hexagon from the old website) and any brand guidelines.</li>
    <li>Photos from your own sites, so the illustrative photographs can be replaced.</li>
    <li>Confirmation of the facts and contracts shown, and any further projects you want listed, with the values you are happy to publish.</li>
    <li>Your prequalification requirements and NCC/PPC registration details, if you want them on the site.</li>
    <li>The staff who need accounts and their roles, and the inboxes for tenders, procurement and HR.</li>
    <li>Access to the ypseaton.com domain settings at Squarespace (your Microsoft 365 email records stay untouched).</li>
  </ul>
  <h2>When billing starts</h2>
  <p>Not on signing. The build, both revision rounds, testing and the preview site cost nothing. Billing starts at the end of the month in which the site launches, prorated for the days it was live. Nothing goes live until you approve it in writing.</p>
  ${foot()}
</section>

<section class="page prose">
  ${plate('07', 'Next steps')}
  <h1>From proposal to launch</h1>
  <ol class="plain" style="padding-left:18px">
    <li style="margin:5px 0"><b>See the demo live.</b> We walk through the website and the back office together, on a laptop and a phone.</li>
    <li style="margin:5px 0"><b>Tell us what to change.</b> Pages, wording, roles or the intake flows; revision round 1 opens straight away.</li>
    <li style="margin:5px 0"><b>Sign a one-page agreement</b> with the terms in this proposal: US$1,000 a month, month to month on 30 days' notice, US$0 build cost, and a US$7,000 handover fee only if you leave.</li>
    <li style="margin:5px 0"><b>Kick-off the same week</b>, with launch six weeks later.</li>
  </ol>
  <div class="card" style="margin-top:18px; max-width:4.6in">
    <h3>Contact</h3>
    <p style="margin:0">Keron Lewis, Director<br>Code Canvas Consultants Ltd, Port of Spain<br>codecanvastt.com<br><a href="mailto:info@codecanvastt.com">info@codecanvastt.com</a><br><a href="https://calendly.com/keronlewis/30min">Book a call: calendly.com/keronlewis/30min</a></p>
  </div>
  <div style="margin-top:auto; margin-bottom:12px">${WORDMARK(false)}</div>
  ${foot()}
</section>
</body></html>`;

fs.writeFileSync(OUT_HTML, html);
const browser = await puppeteer.launch({ executablePath: CHROME, headless: 'new', args: ['--no-sandbox', '--allow-file-access-from-files'] });
const page = await browser.newPage();
await page.goto('file://' + OUT_HTML, { waitUntil: 'networkidle0' });
await page.evaluate(() => document.fonts.ready);
await page.pdf({ path: OUT_PDF, format: 'Letter', printBackground: true, preferCSSPageSize: true, displayHeaderFooter: false });
await browser.close();
const mb = Math.round(fs.statSync(OUT_PDF).size / 1024 / 1024 * 10) / 10;
console.log('PDF written:', OUT_PDF, mb + ' MB');
if (mb > MAX_MB) {
  console.error(`The PDF is over ${MAX_MB} MB, too large for most email attachments. Lower the JPEG quality in capture.mjs.`);
  process.exit(1);
}
