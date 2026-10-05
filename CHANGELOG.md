# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

---

## [2.0.0] - 2026-10-05

### Changed
- **Breaking:** renamed for Inverys CMS. The package is now `inverys/announcement-bar` with the Composer type `inverys-plugin`, and its settings live under `extra.inverys`. Requires Inverys CMS; for older CMS versions stay on 1.x.

## [1.0.3] - 2026-07-10

### Added
- Security policy (`SECURITY.md`) with coordinated vulnerability reporting, and a CycloneDX SBOM under `sbom/` (this package has no third-party runtime dependencies). Brings the plugin to supply-chain/CRA parity with the CMS core.

---

## [1.0.2] - 2026-07-08

### Changed
- CSP compatibility: inline `<script>` tags now carry the `@cspNonce` directive, and the inline event handlers (the bar's dismiss button, color-picker mirroring in the settings) were switched to `addEventListener`. This makes it work under the CMS's strict, nonce-based Content Security Policy.

---

## [1.0.1] - 2026-07-08

### Security
- Settings page is now protected by `permission:manage-plugins` — previously any logged-in backend user could change the site-wide Announcement Bar.

### Fixed
- Strict hex validation for `bg_color`/`text_color` (`#RGB`/`#RRGGBB`) instead of a mere length check — prevents CSS injection via the color fields.

---

## [1.0.0] - 2026-03-21

### :tada: Initial Release

#### Added
- Configurable announcement bar for all frontend pages
- Admin settings page with live preview
- Custom background and text colors via color pickers
- Position setting: top or bottom of page
- Optional call-to-action link (text + URL)
- Dismissible option for visitors
- Fixed positioning with automatic body padding
- Full English and German translations
- Composer package support (`inverys-plugin` type)
- ZIP upload support for manual installation
