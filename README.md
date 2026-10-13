<p align="center">
  <img src="https://img.shields.io/badge/Inverys_CMS-Plugin-6366f1?style=for-the-badge" alt="Inverys CMS Plugin">
  <img src="https://img.shields.io/badge/Version-1.0.0-22c55e?style=for-the-badge" alt="Version 1.0.0">
  <img src="https://img.shields.io/badge/License-MIT-blue?style=for-the-badge" alt="MIT License">
  <img src="https://img.shields.io/badge/PHP-8.4+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.4+">
</p>

# :loudspeaker: Announcement Bar

A fully configurable announcement bar plugin for [Inverys CMS](https://github.com/tklmn/inverys-cms). Display important messages, promotions, or alerts at the top or bottom of every frontend page.

---

## :sparkles: Features

| | Feature | Description |
|---|---|---|
| :paintbrush: | **Custom Colors** | Pick any background and text color via color pickers |
| :round_pushpin: | **Position** | Show the bar at the top or bottom of the page |
| :link: | **Optional Link** | Add a call-to-action link with custom text |
| :x: | **Dismissible** | Let visitors close the bar for the current page view |
| :art: | **Live Preview** | The settings page shows a preview that follows every change |
| :globe_with_meridians: | **Multilingual** | Message and link text are translatable with the Multilingual plugin |
| :mag: | **Quick Search** | The settings page is found via Ctrl K (English and German keywords) |
| :shield: | **Strict CSP** | Nonce-based scripts, no inline event handlers |
| :jigsaw: | **Theme Overrides** | Themes can replace the bar's markup |

## :zap: Quick Start

### Option A: Marketplace

1. Go to **Extensions > Plugins > Marketplace**
2. Click **Install** on *Announcement Bar*
3. Click **Enable** and configure it under **Extensions > Announcement Bar** in the sidebar

### Option B: ZIP Upload

1. Download the latest release as ZIP
2. Go to **Extensions > Plugins > Upload Package**
3. Select the ZIP file and click **Install**
4. Enable the plugin and configure it under **Extensions > Announcement Bar** in the sidebar

### Option C: Composer

```bash
composer config repositories.announcement-bar vcs https://github.com/tklmn/inverys-cms-plugin-announcement-bar
composer require inverys/announcement-bar
```

The CMS auto-discovers Composer packages with type `inverys-plugin`. Enable the plugin in **Extensions > Plugins**.

---

## :wrench: Configuration

After enabling, open **Extensions > Announcement Bar** in the backend sidebar (or search for "announcement" with Ctrl K). The page needs the `manage-plugins` permission.

| Setting | Description | Default |
|---------|-------------|---------|
| **Show the announcement bar** | Show/hide the bar on all frontend pages | Off |
| **Message** | The announcement text (max 500 chars) | `Welcome to our site!` |
| **Link text** | Optional call-to-action label (max 100 chars) | - |
| **Link URL** | Optional call-to-action URL | - |
| **Background color** | Bar background color | `#fbbf24` (amber) |
| **Text color** | Text, link and icon color | `#1c1917` (stone-900) |
| **Position** | `Top of page` or `Bottom of page` | Top |
| **Dismissible** | Allow visitors to close the bar | Yes |

The link is shown only when both text and URL are set, and only for `http(s)://`, `mailto:`, `tel:` or site-relative (`/…`) addresses.

---

## :open_file_folder: File Structure

```
announcement-bar/
├── plugin.json              # Plugin manifest (settings route, quick-search keywords)
├── composer.json            # Composer package definition
├── lang/
│   ├── en/ab.php            # English translations
│   └── de/ab.php            # German translations
├── src/
│   ├── AnnouncementBarServiceProvider.php   # Plugin lifecycle & registration
│   └── SettingsController.php               # Admin settings controller
└── views/
    ├── bar.blade.php        # Frontend bar (injected via body hook)
    └── settings.blade.php   # Backend settings page with live preview
```

---

## :book: How It Works

The plugin uses the Inverys CMS Plugin SDK:

- **`registerPluginViews()`** — registers the `announcement-bar` view namespace with theme-override support
- **`registerBodyHook()`** — injects the bar before `</body>` on every frontend page
- **`registerSidebarItem()`** — adds the settings link to the **Extensions** section of the sidebar
- **`registerTranslatableSetting()`** — makes the message and link text translatable (Multilingual plugin, *Languages > Translate texts*)
- **`registerSettingsPrefix()`** — keeps the `announcement_bar.` settings out of the public settings API
- **`routes()->backend()`** — registers the admin routes; the controller requires `manage-plugins`

All settings are stored in the CMS `settings` table with the `announcement_bar.` prefix.

The backend page is built from the CMS design system (`x-ui.page`, `x-ui.card`, `x-ui.field`, `x-ui.color`, `x-ui.switch-row`) and works in light and dark mode. The frontend bar brings its own small stylesheet, so it does not depend on the theme's CSS; colors are validated as hex values before they reach the stylesheet.

### Theme overrides

Place a file at `themes/{theme}/views/plugins/announcement-bar/bar.blade.php` to replace the bar's markup in that theme.

---

## :earth_americas: Translations

The plugin ships with English and German translations. To add a new language, create `lang/{locale}/ab.php` following the existing files.

---

## :page_facing_up: Requirements

- **Inverys CMS** 1.0 or newer
- **PHP** >= 8.4

## :handshake: Author

**Tom Kilimann** — [tkilimann@icloud.com](mailto:tkilimann@icloud.com)

## :scroll: License

MIT
