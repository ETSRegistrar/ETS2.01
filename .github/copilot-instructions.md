<!-- Copilot instructions for AI coding agents in this repo -->
# Copilot instructions — ETS (Emmanuel Theological Seminary)

This repository is a predominantly static website (HTML/CSS/JS) with a small PHP contact form. The goal of these instructions is to help AI coding agents be productive quickly by calling out architecture, conventions, and exact places to change behavior.

- Project type: static site + PHP contact handler.
- Live files to inspect: `index.html`, `main.js`, `assets/css/main.css` (primary site stylesheet), `assets/` (images, vendor libs), and `forms/contact.php` (PHP email handler).

Key patterns and where to edit
- Visual/theme variables: `assets/css/main.css` defines CSS custom properties at the top (`:root`). To change global colors or fonts, edit those variables rather than scattering overrides.
- Slider configuration: Swiper instances are initialized by `main.js` reading inline JSON in the page. Look for `<script type="application/json" class="swiper-config">` inside `index.html` and update the JSON to change slides, pagination, or speed.
- Scroll / UI behavior: `main.js` contains scrollspy, mobile nav toggle, AOS init, and video handling. Small behavior tweaks (timings, thresholds) belong here.
- Vendor libs: Local copies live under `assets/vendor/` (Bootstrap, AOS, Swiper, PureCounter) — prefer editing usage or configuration over changing vendor code. If upgrading libraries, replace the specific files in that folder and test UI.

Server-side / form handling
- PHP email helper: `forms/contact.php` and `contact.php` use the `PHP_Email_Form` helper expected at `vendor/php-email-form/php-email-form.php`. If that file is missing, the script will `die()`; add a compatible library or stub for local testing.
- SMTP secrets: The repository currently contains SMTP credentials in `forms/contact.php` (look for `$contact->smtp`). Treat these as secrets: do not hard-code, rotate, or commit new secrets. Replace with environment-based config or a CI secret before production deploy.
- Local PHP testing: run a PHP dev server from the project root to test form handling:

```
php -S 0.0.0.0:8000 -t .
```

Then open `http://localhost:8000/index.html` and submit the form. For purely static preview (no PHP), use `python -m http.server 8000` or your editor's static preview.

Conventions and patterns
- Paths: `index.html` links `assets` using absolute-ish paths (e.g. `/assets/css/main.css`). When editing file references, prefer the same path style used in `index.html` to avoid 404s in different deployment contexts.
- Minified vs source: The repo contains both minified and non-minified vendor files (e.g., `bootstrap.min.css` and `bootstrap.css`). Edit the non-minified source for readability; update minified files when you must ship a change.
- Inline JSON configs: Some components use inline JSON in the DOM (Swiper). Avoid moving those configs into separate files unless updating both `index.html` and `main.js` consistently.
- Accessibility: Interactive elements (nav, accordions) follow Bootstrap/AOS conventions — maintain `data-` attributes and ARIA where present.

Testing & debugging tips
- Static preview: `python -m http.server 8000` (or `live-server`) for fast checks.
- PHP form: use `php -S` to exercise form endpoints. If `vendor/php-email-form/php-email-form.php` is not present, add a small stub that imitates `PHP_Email_Form` interface to allow UI testing.
- JS debug: `main.js` attaches listeners on `DOMContentLoaded` and `load`; load order matters. Open DevTools console to check AOS/Swiper JSON parsing errors and video autoplay logs shown by the script.

PR and edit guidance for agents
- Do not modify files under `assets/vendor/` except to upgrade library versions — prefer configuration changes or file replacement with a tested upgrade.
- Remove any SMTP credentials from code; replace with env-driven config and document where CI/dev secrets live.
- When changing UI behavior, update `main.js` and also any inline config in `index.html` if relevant (e.g., Swiper JSON).

Files to review first (example entry points)
- `index.html` — canonical page structure and inline component configs.
- `assets/css/main.css` — theme variables and global styles.
- `main.js` — UI behavior: nav, scroll, AOS, Swiper init, video handling.
- `forms/contact.php` and `contact.php` — server-side email form wiring and SMTP configuration.

If something is unclear or you need additional runtime details (build/deploy commands, hosting target, where secrets should be stored), ask the repo maintainer for:
- the intended production hosting (static host vs PHP-capable host),
- whether SMTP should be removed from repo and replaced by environment variables or an external email service, and
- any automated test or preview steps they use.

Please review and tell me which sections need more detail (hosting, env conventions, or deploy steps). 
