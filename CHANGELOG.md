# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

---

## [1.0.0] - 2026-10-13

### Added
- Announcement bar on every frontend page, injected through the body hook: a message with an optional call-to-action link (text and URL).
- Settings page under **Extensions > Announcement Bar** (permission `manage-plugins`), built from the CMS design-system components in a two-column layout with a live preview; works in light and dark mode.
- Background and text color pickers, position at the top or bottom of the page, and an option that lets visitors dismiss the bar for the current page view.
- Self-contained frontend bar with its own small stylesheet, a Lucide close icon, a translated `aria-label`, and page padding that follows the bar's height when the window is resized.
- Message and link text registered as translatable settings for the Multilingual plugin (*Languages > Translate texts*).
- Preview image (`assets/screenshot.png`, named in `plugin.json`) for the plugin list and the marketplace.
- Quick search (Ctrl K) finds the settings page via `search_keywords`, in English and German.
- Views registered with `registerPluginViews()`, so themes can override the bar under `themes/{theme}/views/plugins/announcement-bar/`.
- Default settings seeded idempotently on install and removed on uninstall; the `announcement_bar.` prefix keeps them out of the public settings API.
- English and German translations.
- Available in the Inverys marketplace (catalog [`tklmn/inverys-marketplace`](https://github.com/tklmn/inverys-marketplace)), as Composer package (`inverys-plugin` type) and as ZIP upload.
- Release package: every release gets `<slug>-<version>.zip` with its SHA-256 checksum attached (workflow), the file marketplace catalogs point to.
- Update source (`repository` in `plugin.json`): the CMS checks for new releases and installs them.

### Security
- Works under the CMS's strict, nonce-based Content Security Policy: no inline event handlers.
- Colors are validated as strict hex values (`#RGB`/`#RRGGBB`) on save and again before they reach the bar's stylesheet.
- The link is only rendered for `http(s)://`, `mailto:`, `tel:` or site-relative addresses.
- Security policy (`SECURITY.md`) with coordinated vulnerability reporting, and a CycloneDX SBOM under `sbom/` (no third-party runtime dependencies).
