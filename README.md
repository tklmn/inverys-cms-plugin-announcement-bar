<p align="center">
  <img src="https://img.shields.io/badge/Inverys_CMS-Plugin-6366f1?style=for-the-badge" alt="Inverys CMS Plugin">
  <img src="https://img.shields.io/badge/Version-1.0.0-22c55e?style=for-the-badge" alt="Version 1.0.0">
  <img src="https://img.shields.io/badge/License-MIT-blue?style=for-the-badge" alt="MIT License">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.2+">
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
| :x: | **Dismissible** | Let visitors close the bar (with smooth removal) |
| :globe_with_meridians: | **i18n Ready** | Full English and German translations included |
| :art: | **Live Preview** | See your changes in real-time on the settings page |
| :gear: | **Admin Settings** | Dedicated settings page in the CMS backend |

## :zap: Quick Start

### Option A: ZIP Upload

1. Download the latest release as ZIP
2. Go to **Backend > Plugins > Upload Package**
3. Select the ZIP file and click **Install**
4. Enable the plugin and configure it under **Announcement Bar** in the sidebar

### Option B: Composer

```bash
composer require inverys/announcement-bar
```

The CMS auto-discovers Composer packages with type `inverys-plugin`. Enable the plugin in **Backend > Plugins**.

---

## :wrench: Configuration

After enabling, click **Announcement Bar** in the backend sidebar:

| Setting | Description | Default |
|---------|-------------|---------|
| **Enable** | Show/hide the bar on all frontend pages | Off |
| **Message** | The announcement text (max 500 chars) | `Welcome to our site!` |
| **Background Color** | Bar background color | `#fbbf24` (amber) |
| **Text Color** | Text and icon color | `#1c1917` (stone-900) |
| **Position** | `Top of page` or `Bottom of page` | Top |
| **Dismissible** | Allow visitors to close the bar | Yes |
| **Link Text** | Optional CTA link label | - |
| **Link URL** | Optional CTA link URL | - |

---

## :open_file_folder: File Structure

```
announcement-bar/
├── plugin.json              # Plugin manifest
├── composer.json             # Composer package definition
├── lang/
│   ├── en/ab.php             # English translations
│   └── de/ab.php             # German translations
├── src/
│   ├── AnnouncementBarServiceProvider.php   # Plugin lifecycle & registration
│   └── SettingsController.php               # Admin settings controller
└── views/
    ├── bar.blade.php         # Frontend bar (injected via body hook)
    └── settings.blade.php    # Backend settings form with live preview
```

---

## :book: How It Works

The plugin uses the Inverys CMS Plugin SDK:

- **`registerBodyHook()`** — injects the bar HTML before `</body>` on every frontend page
- **`registerSidebarItem()`** — adds a settings link in the backend sidebar
- **`routes()->backend()`** — registers admin routes with auth middleware
- **`settings()->get/set()`** — reads and writes plugin settings via the CMS settings contract

All settings are stored in the CMS `settings` table with the `announcement_bar.` prefix.

---

## :earth_americas: Translations

The plugin ships with English and German translations. To add a new language, create `lang/{locale}/ab.php` following the existing files.

---

## :page_facing_up: Requirements

- **Inverys CMS** >= 2.0
- **PHP** >= 8.2

## :handshake: Author

**Tom Kilimann** — [tkilimann@icloud.com](mailto:tkilimann@icloud.com)

## :scroll: License

MIT
