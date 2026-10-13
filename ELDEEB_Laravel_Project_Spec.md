# EL DEEB ELEVATOR & BUILDING SYSTEM
## Full Project Specification — Laravel + Blade, Smooth Motion, Queues, Hardened Security

**Audience:** Antigravity (AI engineering agent / dev team)
**Goal:** Build a production-ready, bilingual (EN LTR / AR RTL), CMS-driven corporate website and admin dashboard. Start implementation directly from this document.
**Design references:** Structure/UX inspired by https://eagle-elevators.com/ (information architecture only). Visual identity is 100% EL DEEB. Never copy Eagle's branding, colors, fonts, imagery.

---

## 0. How to work (instructions to the agent)

1. Read this whole document first, then scaffold the project, then implement phase by phase (Section 19).
2. Everything visible on the public site must be editable from the admin (CMS-first). No hard-coded copy in Blade except UI micro-labels that live in translation files.
3. Do NOT invent company facts: no statistics, certifications, partners, phone numbers, addresses, social accounts, project data. Use clearly marked placeholders (e.g. `[PLACEHOLDER]`) seeded in the DB so the client can replace them from the CMS.
4. Security and performance are first-class requirements, not a final polish step.
5. Commit in small, logical steps. Write tests for security-sensitive code (auth, permissions, uploads, forms).
6. Ask for the following assets if missing, and use the listed fallbacks until they arrive:
   - EL DEEB logo (SVG) → temporary text wordmark "EL DEEB".
   - Centaur (EN) and A Suls (AR) licensed webfont files (WOFF2) → temporary fallbacks: EN `Cormorant Garamond` / Georgia serif; AR `Amiri` / `Noto Naskh Arabic`. Wire fonts through CSS variables so swapping is a one-line change.
   - Photography → neutral architectural placeholders (dark navy blocks with subtle texture), never random stock people.

---

## 1. Tech stack (fixed)

| Layer | Choice |
|---|---|
| Backend | **Laravel 12** (PHP 8.3+), MySQL 8 / MariaDB 10.11 |
| Templating | **Blade** (+ Blade components, anonymous components, layouts, slots). No SPA. |
| Styling | **Tailwind CSS 4** with design tokens as CSS variables; logical properties for RTL |
| Interactivity | **Alpine.js** (small UI state) — no jQuery |
| Motion | **GSAP + ScrollTrigger** + **Lenis** (smooth scrolling) |
| Build | **Vite** |
| Queues | **Redis + Laravel Queues + Horizon** (fallback: database driver for local dev) |
| Cache / Session | Redis |
| Scheduler | Laravel Scheduler (`schedule:run` every minute via cron) |
| Auth | **Laravel Fortify** (Blade views) with mandatory 2FA (TOTP) for admin users |
| RBAC | `spatie/laravel-permission` |
| Media | `spatie/laravel-medialibrary` (conversions to WebP/AVIF, responsive images) |
| Translations of content | `spatie/laravel-translatable` (JSON columns, `en` / `ar`) |
| Activity log | `spatie/laravel-activitylog` |
| Slugs | `spatie/laravel-sluggable` (per-locale slugs) |
| SEO / sitemap | `spatie/laravel-sitemap`, custom SEO model |
| Sanitization | `mews/purifier` (HTMLPurifier) for all rich text |
| CSP | `spatie/laravel-csp` |
| Anti-spam | Honeypot (`spatie/laravel-honeypot`) + **Cloudflare Turnstile** |
| Backups | `spatie/laravel-backup` (encrypted, to off-server storage) |
| Rich-text editor (admin) | **Tiptap** (headless, bundled via Vite) outputting sanitized HTML |
| Testing | Pest + Laravel Dusk (critical flows) |
| Quality | Larastan (level 6+), Laravel Pint, `composer audit`, `npm audit` in CI |

Why custom Blade admin and not Filament/Nova: the client wants the dashboard to carry the EL DEEB identity and be fully designed; build it with Blade components sharing the same design tokens.

---

## 2. Brand identity (use exactly)

### 2.1 Colors (CSS variables + Tailwind theme)

| Token | Hex | Use |
|---|---|---|
| `--c-navy` | `#232E34` | Primary dark, text, dark sections, footer |
| `--c-ivory` | `#EFEBE0` | Primary light background |
| `--c-greige` | `#BDB4A5` | Borders, secondary surfaces, muted elements |
| `--c-slate` | `#5A5E61` | Secondary text, icons, precision UI |
| `--c-champagne` | `#907351` | **Accent only** (links hover, thin rules, small highlights, key numbers). Never a dominant fill. |

Derived neutrals are allowed (e.g. navy at 8/16/64% opacity, ivory lighter/darker by ≤6%) for borders, hover, disabled, overlays. No other hues, except functional status colors in the admin only (success/warning/error), desaturated to sit with the palette.

Contrast: body text navy on ivory (passes AA). Champagne on ivory is for large text/graphics only; for small text use navy or slate. Verify all pairs ≥ WCAG AA.

### 2.2 Typography
- EN: **Centaur**. AR: **A Suls**. Self-host WOFF2, `font-display: swap`, preload the primary weights.
- Tokens: `--font-en`, `--font-ar`. Apply by `html[lang]`/`dir`.
- Scale (fluid with `clamp`): Display 56–120, H1 44–72, H2 32–48, H3 24–32, H4 20, Body 17–18, Small 14, Eyebrow 12–13 uppercase with letter-spacing (EN only; no letter-spacing in Arabic).
- Arabic needs larger line-height (≈1.8 body, 1.35 headings), slightly larger font size than EN equivalents, no uppercase, no letter-spacing, and careful wrapping (`text-wrap: balance` for headings).

### 2.3 Spacing / layout tokens
- Spacing scale (4px base): 4, 8, 12, 16, 24, 32, 48, 64, 96, 128, 160.
- Radius: **small** — 0, 2, 4 only (architectural, not bubbly). No pill-shaped cards.
- Shadows: almost none; use hairline borders (1px greige at 40%). One soft shadow token for floating menus/modals.
- Container: 1360px max, side padding 24 (mobile) / 40 (tablet) / 64 (desktop). 12-col grid, 24px gutter.
- Breakpoints: 390 (mobile), 768 (tablet), 1280 (laptop), 1440 (desktop).
- Button heights: 44 (default), 52 (large), 36 (small). Input height 52.
- Icons: 20/24/32 stroke icons, 1.5px stroke (use a single consistent set, e.g. Lucide/Phosphor Light, inline SVG via Blade components).

### 2.4 Visual direction
Premium · Architectural · Engineering · Minimal · Elegant · Trustworthy. Large editorial compositions, strong grid, generous whitespace, thin champagne rules, technical spec tables, big numerals. Avoid gradients, heavy shadows, excess rounding, clutter, generic startup look.

---

## 3. Motion & smoothness (important)

**Principle:** subtle, precise, fast. The site must feel "smooth" like a premium architecture studio — not flashy.

### 3.1 Implementation
- **Lenis** for smooth scrolling (lerp ≈ 0.08–0.1). Disabled when `prefers-reduced-motion` or on touch devices if it harms native feel; integrate with GSAP ticker/ScrollTrigger.
- **GSAP + ScrollTrigger** for reveals. Load via Vite, split into a small `motion.js` module, initialized after DOMContentLoaded; lazy-init per section via IntersectionObserver.
- Respect `prefers-reduced-motion: reduce` → all motion collapses to simple opacity fades or nothing.
- Animate only `transform` and `opacity` (GPU friendly). Never animate layout properties. Avoid layout thrash; no animation on elements that cause CLS.
- **RTL-aware:** horizontal movement uses a CSS variable `--dir: 1` (LTR) / `-1` (RTL) so slide-ins mirror correctly.
- Page transitions: lightweight fade/slide-up of `<main>` between navigations (View Transitions API where supported, graceful fallback to none). Do not break SEO or back/forward navigation.

### 3.2 Animation catalogue
| Where | Effect |
|---|---|
| Header | Transparent over hero → solid navy/ivory on scroll with 300ms transition; hides on scroll-down, shows on scroll-up |
| Hero | Staggered text line reveal (mask/clip from below), image/video slow scale 1.08 → 1 on load, scroll-cue line animation |
| Section headings | Eyebrow line draws in (scaleX), heading lines reveal on enter |
| Images | Clip-path/mask reveal on scroll + subtle parallax (≤ 8%) |
| Cards | Hover: image zoom 1.04, champagne underline draws, arrow nudges (direction mirrors in RTL) |
| Counters | Number count-up when visible (once), tabular numerals |
| Buttons | Hover fill sweep (navy ↔ ivory), arrow slide; focus ring always visible |
| Project grid | Staggered fade-up; filter changes use FLIP-style reorder (GSAP Flip) |
| Accordion (FAQ) | Height + opacity easing, icon rotates |
| Mobile menu | Full-screen panel, staggered link reveal |
| Admin | Only micro-interactions: toasts, drawer/modal slide, skeleton loaders |

Easing: `cubic-bezier(0.22, 1, 0.36, 1)` (expo-out) default; durations 0.5–1.1s for reveals, 0.2–0.3s for hovers.

### 3.3 Performance budget
- LCP < 2.5s, CLS < 0.05, INP < 200ms on mid-range mobile.
- JS for public site (gzipped): < 120KB excluding images. Lazy-load GSAP plugins used below the fold.
- Images: WebP/AVIF, responsive `srcset`/`sizes`, `loading="lazy"` except hero, explicit width/height, blur-up placeholder (low-quality base64 or dominant color).
- Hero video: optional, muted/loop/playsinline, poster image, only loaded on desktop/fast connections; mobile gets the poster.

---

## 4. Internationalization (EN LTR / AR RTL)

- URL strategy: `/en/...` and `/ar/...` (locale prefix). Root `/` redirects by `Accept-Language`, remembers choice in a cookie, defaults to Arabic or English as configured in Settings.
- `<html lang dir>` set from locale. `hreflang` alternates + `x-default` on every page. Language switcher keeps the user on the equivalent page.
- UI strings: Laravel lang files (`lang/en`, `lang/ar`). Content: translatable JSON columns (`title`, `description`, etc.) editable per language in admin with a language tab (EN | AR) on every editor, and completeness indicator ("AR missing").
- Per-locale slugs (e.g. `/en/projects/new-cairo-residence`, `/ar/projects/<arabic-slug>`).
- **Use Tailwind logical utilities** (`ms-*`, `me-*`, `ps-*`, `pe-*`, `start-*`, `end-*`, `text-start`), never hard-coded `left/right` for layout. Icons with direction (arrows, chevrons) flip via `rtl:` variants.
- Arabic is **not** a mirror of English: separate typographic scale, spacing and line-height tokens; verify image/text composition in RTL (focal points, overlapping elements).
- Numbers: support Western digits by default, with a setting to show Arabic-Indic digits on AR pages.
- Dates formatted per locale (Carbon `translatedFormat`).
- Admin dashboard: also bilingual (EN/AR toggle, RTL-capable).

---

## 5. Information architecture & public pages

Routes (all under `/{locale}`):

| Page | Route |
|---|---|
| Home | `/` |
| About | `/about` |
| Elevators (list) | `/elevators` |
| Elevator detail | `/elevators/{slug}` |
| Services | `/services` (+ optional `/services/{slug}`) |
| Projects | `/projects` |
| Project detail | `/projects/{slug}` |
| Blog | `/blog` , `/blog/category/{slug}` |
| Article detail | `/blog/{slug}` |
| FAQ | `/faq` |
| Contact | `/contact` |
| Privacy / Terms | `/privacy`, `/terms` (CMS pages) |
| Sitemap / robots | `/sitemap.xml`, `/robots.txt` |
| 404 / 403 / 419 / 429 / 500 | Designed error pages in brand style |

### 5.1 Global elements
- **Header:** logo, nav (Home, About, Elevators, Services, Projects, Blog, Contact), language switcher, primary CTA ("Request a Consultation"), mobile menu. Transparent → solid on scroll. Menu items and CTA are CMS-editable (Settings → Navigation).
- **Footer:** logo, description, nav columns, products, services, contact info, social links, newsletter (queued double opt-in), copyright, privacy/terms. All CMS-editable.
- **Breadcrumbs** on inner pages with JSON-LD `BreadcrumbList`.
- **Reusable CTA band** section component (title, description, button) editable globally or per page.
- Floating WhatsApp button (CMS toggle + number).

### 5.2 Home — sections (each: enable/disable, reorder, draft/publish)
1. **Hero** — eyebrow, headline, description, primary CTA, secondary CTA, background image **or** video (+ poster), optional 3–4 stats.
2. **About teaser** — title, rich text, image, statistics (repeatable: value, suffix, label), CTA, optional timeline (repeatable: year, title, text).
3. **Elevators / Products** — section title, description, selected categories/products (picked from Elevators module, ordered).
4. **Services** — title, description, selected services.
5. **Featured Projects** — title, selected projects.
6. **Why EL DEEB / Engineering & Safety** — repeatable feature blocks (icon, title, text).
7. **Testimonials** (optional, from Testimonials module).
8. **Partners/Clients logos** (optional, from Partners module).
9. **Latest articles** — auto from Blog (count configurable).
10. **CTA band.**

### 5.3 About
Intro/editorial hero, story (rich text + images), mission/vision/values (repeatable), stats, timeline, team/leadership (optional repeatable), certifications (optional repeatable — **placeholder only**), CTA.

### 5.4 Elevators (products)
- Listing: intro, category filter (tabs), cards (image, title, short description, category, CTA, optional 2–3 spec chips).
- **Detail:** hero image, title, description, gallery (lightbox), **technical specifications table** (repeatable key/value rows: Capacity, Speed, Max Travel, Door Type, Cabin Type, Control System, Safety Features, Customization — admin can add any row), features (repeatable), applications (repeatable), advantages (repeatable), CTA ("Request a Quote" pre-filling the contact form with the product), related products.

### 5.5 Services
List with image/icon/title/description/CTA. Optional detail page with rich content. Fully dynamic (add/remove/reorder).

### 5.6 Projects
- Architectural portfolio grid (asymmetric editorial layout, large imagery).
- **Filtering:** category, year, location, status; search; featured projects strip. Filtering server-driven with progressive enhancement (Alpine + fetch partial Blade render; URL query string kept shareable; works without JS).
- Card: cover, title, location, category, year, number of elevators, status.
- **Detail:** hero → overview → **Key Facts** (visually emphasized: Location, Project Type, Completion Date, Elevators, Service Type) → description → technical information → gallery → execution/installation images → related projects → CTA.

### 5.7 Blog
- Listing: featured article, grid, category filter, search, pagination.
- Detail: cover, title, author, date, category, reading time (computed), rich content, related articles, share buttons (copy link, WhatsApp, LinkedIn, X, Facebook — plain links, no tracking scripts), JSON-LD `Article`.

### 5.8 FAQ
Accordion (accessible: `button` + `aria-expanded` + `aria-controls`), optional categories, JSON-LD `FAQPage`.

### 5.9 Contact
Info (phone, email, WhatsApp, address, hours, social), map area (privacy-friendly: static image placeholder that loads the iframe on click — no third-party requests until consent), contact form.

Form fields: Name, Phone, Email, Company, Service/Product (select populated from CMS), Message, Attachment (optional).
States designed and implemented: default, focus, error, success, loading, disabled.

---

## 6. CMS / Admin dashboard

### 6.1 Navigation (sidebar, collapsible, RBAC-aware)
```
Dashboard

Website Content
├── Home
├── About
├── Services
├── Elevators
├── Projects
├── FAQ
├── Contact
└── Website Settings

Content
├── Projects
├── Elevators
├── Services
├── Blog (Articles, Categories, Tags)
├── Testimonials
├── Partners
└── Media Library

Communication
└── Contact Messages

SEO
├── Page SEO
├── Meta Titles / Descriptions
├── Open Graph
└── Sitemap Settings

System
├── Users
├── Roles & Permissions
├── Activity Logs
└── Settings
```
Hide menu items the user has no permission for; enforce on the server too.

### 6.2 Screens required
Login (+ 2FA challenge, forgot/reset password) · Dashboard overview · Home content editor · About/Services/Contact/FAQ page editors · Projects list + editor · Elevators list + editor · Services management · Blog: article list, article editor, categories, tags · Testimonials · Partners · Media Library · Contact Messages (list + detail + status) · SEO (page-level) · Users · Roles & Permissions · Activity Logs · Settings.

### 6.3 Dashboard overview
Cards: total projects, total elevators/products, total services, published articles, unread messages, website status (published/maintenance); recent activity; quick actions (New project, New article, Upload media, View messages). Optional queue health widget (failed jobs count) for Super Admin.

### 6.4 Page/section editor (page-builder-lite)
Every page is a list of **sections**. Each section row has: drag handle (reorder), enable/disable toggle, Edit (opens drawer/panel), Preview, Save draft, Publish. Fields per section are defined in code by a schema (type, label, translatable, validation) so adding a section type is a developer task but editing/reordering/toggling is pure admin.

- Draft vs Published: edits save to draft; **Publish** copies to live. "Preview" opens the public page with a signed, expiring preview URL showing drafts. Keep last N revisions with restore.
- Unsaved-changes warning, autosave drafts, validation messages inline, EN/AR language tabs.

### 6.5 Media library
Upload (drag & drop, multi-file, progress), grid/list toggle, preview modal, search, filters (type, folder/category, date), folders/categories, alt text (EN/AR), filename, dimensions, file size, replace file (keeps ID so all references update), delete (warn if in use), "Select media" picker used across all editors. Queued conversions (WebP/AVIF, responsive sizes, thumbnails). Allowed: JPG, PNG, WebP, AVIF, PDF (documents), MP4 (hero video, size-capped). **SVG uploads disabled** unless sanitized server-side (default: off).

### 6.6 Entity CRUD requirements
Common to Projects, Elevators, Services, Blog, Testimonials, Partners, FAQ:
- List with search, filters, sortable columns, bulk actions, pagination; table collapses into stacked cards on mobile.
- Row actions: View, Edit, Duplicate, Publish/Unpublish, Delete (soft delete + confirm dialog + restore from trash).
- Drag-to-reorder where order matters (`sort_order`).
- Status: draft / published / scheduled (publish_at) / archived.
- SEO panel on every public entity (title, description, OG image, canonical, noindex toggle, slug).

**Project fields:** title, slug, short description, full description (rich), location, category, year, status (completed/ongoing/…), number of elevators, service type, specifications (repeatable key/value), cover image, gallery, execution images, featured flag, SEO.
**Elevator fields:** name, category, short/full description, main image, gallery, technical specifications (repeatable key/value), features, applications, advantages, status, SEO.
**Service fields:** title, description, icon, image, detailed content, CTA (label+URL), order, status, SEO.
**Article fields:** title, slug, excerpt, cover, rich content (Tiptap: headings, paragraphs, images, links, lists, quotes, embedded video via allowlisted providers), author, category, tags, featured, publish scheduling, SEO.

### 6.7 Contact messages
Inbox with unread badge, statuses (new / read / replied / archived / spam), detail view with attachment download (authorized, streamed from private disk), internal notes, export CSV (permission-gated), mark spam. Email notification to configured recipients (queued).

### 6.8 Users, roles, permissions
- Roles seeded: Super Admin, Admin, Content Manager, Editor — **but roles are fully custom** (create/rename/delete roles, assign any permissions).
- Permissions are granular per module: `view`, `create`, `edit`, `delete`, `publish`, `manage media`, `manage users`, `manage settings`, `view messages`, `manage seo` — expressed as `module.action` (e.g. `projects.publish`).
- UI: permission matrix (modules × actions) with select-all per row/column.
- Only Super Admin can manage roles/users/settings; nobody can remove the last Super Admin; a user cannot escalate their own privileges.
- Features: invite user by email (queued, signed link), deactivate user, force password reset, force logout of all sessions, 2FA status, last login.

### 6.9 Activity log
Columns: User, Action, Entity, Date, IP, Status. Filters (user, action, entity, date range). Log: CRUD on all entities, publish/unpublish, media upload/delete, settings changes, login success/failure, role/permission changes, exports. Log old/new values for changes (exclude secrets). Append-only; no edit/delete from UI.

### 6.10 Settings
General (site name, default locale, logo light/dark, favicon), contact info (phone, email, WhatsApp, address, hours, map), social links, navigation & footer content, CTA defaults, SMTP/mail recipients, analytics IDs (loaded only after consent), maintenance mode toggle (uses Laravel maintenance with secret bypass), cookie banner text, robots/sitemap settings, Turnstile keys (stored encrypted).

---

## 7. Data model (suggested; refine as needed)

Use ULIDs or auto-increment + public slugs; `softDeletes`, `timestamps`, `created_by`, `updated_by` on content tables. Translatable fields are JSON (`{"en": "...", "ar": "..."}`).

```
users, password_reset_tokens, sessions, roles, permissions, model_has_*  (spatie)
pages              (id, key, status, published_at)                 // home, about, services, contact, faq...
page_sections      (id, page_id, type, data JSON, draft_data JSON, is_enabled, sort_order)
page_revisions     (id, subject_type, subject_id, data JSON, user_id, created_at)
elevator_categories(id, name JSON, slug JSON, image, sort_order, status)
elevators          (id, category_id, name JSON, slug JSON, short_description JSON, description JSON,
                    specifications JSON, features JSON, applications JSON, advantages JSON,
                    status, publish_at, sort_order, is_featured)
services           (id, title JSON, slug JSON, description JSON, content JSON, icon, cta JSON, sort_order, status)
project_categories (id, name JSON, slug JSON, sort_order)
projects           (id, category_id, title JSON, slug JSON, short_description JSON, description JSON,
                    location JSON, year, status, elevators_count, service_type JSON,
                    specifications JSON, is_featured, status_publish, publish_at, sort_order)
articles           (id, category_id, author_id, title JSON, slug JSON, excerpt JSON, content JSON,
                    is_featured, status, publish_at, reading_time)
article_categories, tags, article_tag
testimonials       (id, name, role JSON, company, quote JSON, avatar, sort_order, status)
partners           (id, name, logo, url, sort_order, status)
faqs, faq_categories (question JSON, answer JSON, sort_order, status)
contact_messages   (id, name, phone, email, company, subject_ref, message, attachment_path, status,
                    ip_hash, user_agent, notes, created_at)
newsletter_subscribers (id, email, token, confirmed_at, unsubscribed_at)
seo_meta           (morph: seoable_*, title JSON, description JSON, og_image, canonical, robots)
media (spatie)     + media_folders
settings           (key, value JSON, is_encrypted)
activity_log       (spatie)
```
Add indexes on slug lookups, status+publish_at, sort_order, and foreign keys. Enforce foreign keys.

---

## 8. Queues (Laravel Queues + Horizon)

Run Horizon with separate queues: `critical`, `default`, `media`, `mail`, `low`. Supervisor keeps workers alive; failed jobs table + alerting.

| Job | Queue | Notes |
|---|---|---|
| `SendContactNotification` (admin email) | mail | retries 3, backoff 30/120/600 |
| `SendContactAutoReply` (to visitor) | mail | optional, toggle in settings |
| `SendNewsletterConfirmation` | mail | double opt-in |
| `SendUserInvitation` / password reset | mail | |
| Media conversions (WebP/AVIF/responsive) | media | via medialibrary queued conversions |
| `ScanUploadedFile` (ClamAV hook if available) | media | quarantine on failure |
| `PublishScheduledContent` | scheduler → default | runs every minute, flips `scheduled` → `published`, clears cache |
| `RegenerateSitemap` | low | on publish + nightly |
| `PruneOldData` (logs, tokens, spam) | low | |
| `BackupRun` / `BackupClean` | low | nightly, encrypted, off-server |
| `WarmCache` | low | after publish |

All jobs: idempotent, `ShouldBeUnique` where appropriate, timeouts set, `failed()` handler logging to activity/Sentry. The contact form must **never block** on mail sending — it stores the message, dispatches jobs, returns success immediately.

---

## 9. Security (top priority — harden against OWASP Top 10)

### 9.1 Application
- `APP_DEBUG=false`, `APP_ENV=production`, strong `APP_KEY`, secrets only in `.env` (never committed), config cached.
- **Authentication:** Fortify; passwords hashed with **Argon2id**; min length 12 + breached-password check (`Password::uncompromised()`); login throttling per email+IP; **mandatory TOTP 2FA for all admin users** with recovery codes; session regenerated on login; idle timeout (e.g. 30 min) and absolute timeout; "log out other devices"; optional IP allowlist for `/admin`; admin login URL not indexed.
- **Sessions/cookies:** `HttpOnly`, `Secure`, `SameSite=Lax` (Strict for admin where feasible), `__Host-` prefix where possible, Redis driver.
- **CSRF:** enabled on all state-changing routes; no CSRF exclusions except signed webhooks (if any).
- **Authorization:** Laravel **Policies** for every model + `can:` middleware on every admin route; deny-by-default; test that each route rejects unauthorized roles. Prevent IDOR (always scope queries / use policies, never trust IDs from the client).
- **Mass assignment:** explicit `$fillable` (never `$guarded = []`); use FormRequest `validated()` only.
- **Validation:** FormRequest classes for every input; strict types, max lengths, enum/exists rules; never trust client-side validation alone.
- **SQL injection:** Eloquent/query builder with bindings only; no raw string concatenation (`whereRaw` only with bindings). Lint for raw queries in CI.
- **XSS:** Blade `{{ }}` escaping by default; `{!! !!}` only for rich text that has passed **HTMLPurifier** with a strict allowlist (no `script`, `iframe` except allowlisted video embeds, no inline event handlers, `rel="noopener noreferrer"` on external links). Sanitize on save **and** treat as untrusted on output where cheap.
- **Content Security Policy** (spatie/laravel-csp) with **nonces** for inline scripts; `default-src 'self'`; explicitly allowlist only required hosts (Turnstile, video embeds, analytics if enabled). Start in report-only, then enforce.
- **Security headers (middleware):** `Strict-Transport-Security` (preload-ready), `X-Content-Type-Options: nosniff`, `X-Frame-Options: DENY` (or CSP `frame-ancestors 'none'`), `Referrer-Policy: strict-origin-when-cross-origin`, `Permissions-Policy` (disable camera/mic/geolocation etc.), `Cross-Origin-Opener-Policy: same-origin`, remove `X-Powered-By` / server version.
- **Rate limiting:** named limiters — login (5/min), password reset, contact form (e.g. 5/hour/IP), newsletter, search, API-ish endpoints, admin uploads. 429 designed page.
- **Anti-spam / bots:** honeypot + minimum-fill-time + Cloudflare Turnstile on contact & newsletter & login (after failures).
- **Open redirect / SSRF:** validate redirect targets against internal routes only; no server-side fetching of user-supplied URLs.
- **Mail header injection:** use Mailables with validated inputs; never put raw user input into headers.
- **Logging/monitoring:** structured logs, never log passwords/tokens/PII beyond need; Sentry (or equivalent) for exceptions; alert on repeated auth failures.
- **Dependency hygiene:** `composer audit` + `npm audit` in CI, Dependabot/Renovate, lockfiles committed, pin major versions, remove unused packages.

### 9.2 File uploads (high-risk area)
- Validate by **real MIME + extension allowlist + size cap** (server-side; don't trust `Content-Type`).
- Re-encode images through Intervention/GD/Imagick (strips EXIF, polyglot payloads); randomize stored filenames; never use user filenames in paths.
- Store uploads on a **private disk** by default; public media served via controlled route or a separate non-executable storage path. **No PHP execution** in upload/storage dirs (web server config).
- Contact-form attachments: strict allowlist (PDF, JPG, PNG, DOCX optional), ≤ 5–10 MB, virus-scan job (ClamAV if available), delivered to admins only via authorized streamed download — never as a public URL.
- SVG disabled (or sanitized with a dedicated library if later required).
- Prevent zip bombs / image bombs (max dimensions & pixel count).

### 9.3 Infrastructure (document + provide configs)
- HTTPS only, TLS 1.2+, HTTP→HTTPS redirect, HSTS.
- Nginx hardening: hide version, deny dotfiles (`.env`, `.git`), deny direct access to `storage`, `vendor`, `composer.*`, limit request body size, timeouts, gzip/brotli; `public/` is the only web root.
- PHP-FPM: `expose_php=Off`, `disable_functions` for dangerous functions, `open_basedir`, OPcache, separate unprivileged user.
- DB: dedicated least-privilege user, not exposed publicly, strong password, backups encrypted.
- Redis: bound to localhost/private network, password-protected.
- Firewall (UFW) open only 80/443/SSH; SSH key-only, fail2ban, no root login.
- Cloudflare (or similar) in front: WAF, bot management, DDoS protection, rate rules for `/admin` and `/login`.
- Automated encrypted off-site backups with **tested restores**; documented recovery runbook.
- Secrets rotation procedure; separate `.env` per environment.

### 9.4 Privacy & compliance
- Cookie/consent banner (bilingual); analytics/third-party only after consent.
- Store IP as hash for contact messages unless needed; retention policy (auto-prune spam/old messages configurable).
- Privacy Policy & Terms editable in CMS.

### 9.5 Security testing (acceptance)
- Pest feature tests: auth required on all admin routes, role matrix enforced, IDOR attempts rejected, upload abuse rejected, XSS payloads sanitized, rate limits trigger, CSRF required.
- Run Larastan, `composer audit`, and a basic OWASP ZAP baseline scan against staging before launch.
- Final checklist signed off in `docs/SECURITY.md`.

---

## 10. SEO

- Per-page and per-entity: meta title/description (translatable), canonical, robots (index/noindex), Open Graph (title, description, image) + Twitter cards, `hreflang`.
- Clean URLs, 301 on slug changes (store slug history), auto breadcrumbs.
- JSON-LD: `Organization`, `LocalBusiness` (from settings), `BreadcrumbList`, `Article`, `FAQPage`, `Product`/`Service` where relevant, `ImageObject` for projects.
- `sitemap.xml` (per-locale alternates) regenerated by queue on publish; `robots.txt` editable from Settings; admin pages `noindex`.
- Semantic HTML: single `h1`, logical heading order, landmarks, descriptive alt text from Media Library.
- Core Web Vitals within budget (Section 3.3).

---

## 11. Accessibility (WCAG 2.2 AA)

- Contrast verified for all token pairs; focus-visible ring (champagne 2px + offset) on every interactive element; skip-to-content link.
- Full keyboard navigation (menus, accordion, modals with focus trap & `Esc`, media picker, drag-reorder has keyboard alternative).
- Labels tied to inputs, error text linked via `aria-describedby`, `aria-live` for toasts and form results, no color-only meaning.
- Target size ≥ 44px on touch; reduced-motion support; alt text required for images (warn in admin when empty); proper `lang` on mixed-language content.
- RTL verified with screen reader basics.

---

## 12. Responsive behavior

Design/verify at **1440, 1280, 768, 390** and fluid between.
- Mobile navigation: full-screen overlay menu, large touch targets, language switcher + CTA pinned.
- Cards reflow 3 → 2 → 1 columns; images keep consistent aspect ratios (`aspect-ratio` utility: 4/3, 3/2, 16/9, 3/4 for vertical project shots).
- Spec tables become stacked definition lists on mobile.
- Admin tables → stacked cards on mobile; sidebar → drawer; editors single column; sticky save bar.
- Forms remain usable with on-screen keyboards (no fixed elements covering inputs).

---

## 13. Component library (Blade components + a `/styleguide` page, admin-only)

Build as reusable anonymous/class components in `resources/views/components/`:

- **Buttons:** primary, secondary, ghost, outline, icon, danger — states: default, hover, active, focus, disabled, loading.
- **Inputs:** text, email, phone, select, textarea, search, date, file upload (drag & drop) — states: default, focus, filled, error, success, disabled.
- **Cards:** product, service, project, article, stat, testimonial.
- **Navigation:** desktop navbar, mobile menu, breadcrumbs, pagination, tabs.
- **Feedback:** toast, alert, modal, confirm dialog, empty state, skeleton/loading, error state.
- **Layout:** section wrapper (spacing, background variants ivory/navy/greige), container, grid, eyebrow, section heading, spec table, key-facts bar, stat counter, accordion, gallery/lightbox, media picker.

Provide `/admin/styleguide` rendering every component and state for visual QA.

---

## 14. Suggested project structure

```
app/
  Http/Controllers/Site/        // public
  Http/Controllers/Admin/       // admin
  Http/Requests/                // FormRequests (all validation)
  Http/Middleware/              // SetLocale, SecurityHeaders, EnsureTwoFactor, AdminIpAllowlist
  Models/  Policies/  Jobs/  Services/  Support/  View/Components/
config/  database/{migrations,seeders,factories}/
resources/
  css/ (tokens.css, app.css, admin.css)
  js/  (app.js, motion.js, admin.js, editor.js)
  views/
    layouts/ (site.blade.php, admin.blade.php)
    components/ (ui/*, site/*, admin/*)
    site/ (home, about, elevators/*, services, projects/*, blog/*, faq, contact, errors)
    admin/ (dashboard, pages/*, projects/*, elevators/*, services/*, blog/*, media, messages, seo, users, roles, logs, settings)
  lang/{en,ar}/
routes/{web.php, admin.php}
tests/{Feature,Unit}/
docs/{SECURITY.md, DEPLOYMENT.md, CMS_GUIDE.md}
```

---

## 15. Seed data (placeholders only)

Seed a working demo using clearly marked placeholders: sample categories (Passenger, Home, Hospital, Freight, Panoramic, Other), 6 projects, 6 elevators, 6 services, 4 articles, 8 FAQs, stats set to `[PLACEHOLDER]`, contact details `[PLACEHOLDER]`. Create default roles/permissions and one Super Admin via artisan command (`php artisan eldeeb:create-admin`) — no default password in code; password set interactively and 2FA enforced on first login.

---

## 16. Hero example content (editable defaults — replace via CMS)

- Eyebrow: `EL DEEB ELEVATOR & BUILDING SYSTEM`
- Headline: `Moving People. Building Confidence.`
- Description: `Premium elevator and building solutions engineered for safety, reliability and long-term performance.`
- CTA 1: `Explore Our Solutions` · CTA 2: `Request a Consultation`
- Arabic equivalents must be provided/reviewed by a native Arabic copywriter (mark as `[AR-REVIEW]`).

---

## 17. Quality bar (definition of done)

- All pages listed in Section 5 and all admin screens in Section 6.2 implemented, bilingual, responsive.
- Every visible content element editable from admin (audit checklist in `docs/CMS_GUIDE.md`).
- Draft/publish/schedule/revisions working; queues running under Horizon; failed-job handling verified.
- Security checklist (Section 9) fully implemented and tested; no critical/high findings in ZAP baseline.
- Lighthouse (mobile) ≥ 90 Performance/ 100 Accessibility/ 100 Best Practices/ 100 SEO on Home, Project detail, Article detail.
- Motion tested with `prefers-reduced-motion` and in RTL; no CLS from animations.
- Empty, loading, and error states exist for lists, forms, media, and dashboards.
- Pest test suite green; Larastan clean; Pint formatted.
- Documentation delivered: README, DEPLOYMENT, SECURITY, CMS_GUIDE.

---

## 18. Deployment

- Target: Ubuntu LTS VPS (or managed PHP host) with Nginx, PHP-FPM 8.3, MySQL, Redis, Supervisor (Horizon), cron (scheduler).
- Zero-downtime deploy script (`composer install --no-dev --optimize-autoloader`, `npm ci && npm run build`, `php artisan migrate --force`, `config:cache route:cache view:cache event:cache`, `horizon:terminate`, `storage:link`).
- Environments: local, staging (password-protected, noindex), production. CI pipeline: tests → static analysis → audit → build → deploy.
- Monitoring: uptime check, Sentry, disk/queue alerts, backup success alerts.

---

## 19. Delivery phases

1. **Foundation:** Laravel setup, Vite/Tailwind tokens, fonts, i18n/RTL infrastructure, layouts, security headers, auth (Fortify + 2FA), RBAC, activity log.
2. **Design system & components:** all Blade components + styleguide, motion module (Lenis/GSAP) with reduced-motion + RTL support.
3. **Admin core:** dashboard shell, media library, settings, users/roles, activity log.
4. **Content modules:** Elevators, Services, Projects, Blog, FAQ, Testimonials, Partners — CRUD, SEO panel, drafts/scheduling, queues.
5. **Page builder:** Home/About/Contact/etc. section editor with reorder/toggle/preview/publish/revisions.
6. **Public site:** all pages, filters/search, forms, contact messages flow, newsletter.
7. **SEO & performance:** schema, sitemap, image pipeline, Web Vitals tuning.
8. **Hardening & QA:** security tests, ZAP scan, accessibility audit, RTL audit, cross-browser/device testing.
9. **Docs & launch:** seed content handoff, documentation, deployment, backup restore test.

**Start with Phase 1 now.** After each phase, summarize what was built, what's pending, and any assets/decisions needed from the client (logo, fonts, photography, real copy, Arabic copy review).
