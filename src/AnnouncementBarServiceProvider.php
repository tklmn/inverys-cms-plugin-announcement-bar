<?php

namespace Plugins\AnnouncementBar;

use App\Services\Plugins\PluginServiceProvider;
use Illuminate\Support\Facades\Route;

class AnnouncementBarServiceProvider extends PluginServiceProvider
{
    /** Default values of all settings, also used as fallbacks in the views. */
    public const DEFAULTS = [
        'enabled' => '0',
        'message' => 'Welcome to our site!',
        'bg_color' => '#fbbf24',
        'text_color' => '#1c1917',
        'dismissible' => '1',
        'position' => 'top',
        'link_url' => '',
        'link_text' => '',
    ];

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $pluginPath = $this->getPluginPath();

        // Theme-overridable: themes/{theme}/views/plugins/announcement-bar/
        $this->registerPluginViews('announcement-bar', $pluginPath.'/views');
        $this->app['translator']->addNamespace('announcement-bar', $pluginPath.'/lang');

        // Keep the settings out of the public settings API
        $this->extensions()->registerSettingsPrefix('announcement_bar.');

        // Texts visitors see — translatable per language (Multilingual plugin)
        $this->extensions()->registerTranslatableSetting('announcement_bar.message', [
            'label' => 'announcement-bar::ab.message',
            'group' => 'announcement-bar::ab.sidebar_label',
            'type' => 'textarea',
        ]);
        $this->extensions()->registerTranslatableSetting('announcement_bar.link_text', [
            'label' => 'announcement-bar::ab.link_text',
            'group' => 'announcement-bar::ab.sidebar_label',
        ]);

        // Body hook: the bar renders on every frontend page
        $this->extensions()->registerBodyHook('announcement-bar::bar');

        $this->extensions()->registerSidebarItem([
            'label' => 'announcement-bar::ab.sidebar_label',
            'route' => 'backend.announcement-bar.settings',
            'icon' => 'panel-top',
            'active' => 'backend.announcement-bar.*',
            'section' => 'extensions',
            'order' => 40,
            'permission' => 'manage-plugins',
        ]);

        // Backend group: auth, verified, access-dashboard; the controller adds manage-plugins
        $this->routes()->backend('announcement-bar', function () {
            Route::get('settings', [SettingsController::class, 'edit'])
                ->name('backend.announcement-bar.settings');
            Route::post('settings', [SettingsController::class, 'update'])
                ->name('backend.announcement-bar.settings.save');
        });
    }

    public function install(): void
    {
        $descriptions = [
            'enabled' => 'Announcement bar enabled',
            'message' => 'Announcement bar message',
            'bg_color' => 'Announcement bar background color',
            'text_color' => 'Announcement bar text color',
            'dismissible' => 'Announcement bar can be dismissed',
            'position' => 'Announcement bar position (top or bottom)',
            'link_url' => 'Announcement bar link URL',
            'link_text' => 'Announcement bar link text',
        ];

        $defaults = [];
        foreach (self::DEFAULTS as $key => $value) {
            $defaults['announcement_bar.'.$key] = [
                'value' => $value,
                'type' => 'plugin_setting',
                'description' => $descriptions[$key],
            ];
        }

        $this->seedSettings($defaults);
    }

    public function uninstall(): void
    {
        foreach (array_keys(self::DEFAULTS) as $key) {
            $this->settings()->delete('announcement_bar.'.$key);
        }
    }
}
