<?php

namespace Plugins\AnnouncementBar;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Attributes\Controllers\Middleware;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

// Like the menu item: manage-plugins only (the backend group already requires auth)
#[Middleware('permission:manage-plugins')]
class SettingsController extends Controller
{
    public function edit(): View
    {
        $settings = cms()->settings();

        $values = [];
        foreach (AnnouncementBarServiceProvider::DEFAULTS as $key => $default) {
            // The stored message may be empty; the seeded welcome text is only a default
            $values[$key] = (string) $settings->get('announcement_bar.'.$key, $key === 'message' ? '' : $default);
        }

        return view('announcement-bar::settings', ['ab' => $values]);
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'message' => 'required|string|max:500',
            'bg_color' => ['required', 'regex:/^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/'],
            'text_color' => ['required', 'regex:/^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/'],
            'position' => 'required|in:top,bottom',
            'link_url' => 'nullable|url|max:500',
            'link_text' => 'nullable|string|max:100',
        ]);

        $settings = cms()->settings();

        // boolean() instead of has(): the switch also submits its "off" value
        $settings->set('announcement_bar.enabled', $request->boolean('enabled') ? '1' : '0', 'plugin_setting');
        $settings->set('announcement_bar.message', $request->input('message'), 'plugin_setting');
        $settings->set('announcement_bar.bg_color', $request->input('bg_color'), 'plugin_setting');
        $settings->set('announcement_bar.text_color', $request->input('text_color'), 'plugin_setting');
        $settings->set('announcement_bar.dismissible', $request->boolean('dismissible') ? '1' : '0', 'plugin_setting');
        $settings->set('announcement_bar.position', $request->input('position', 'top'), 'plugin_setting');
        $settings->set('announcement_bar.link_url', (string) $request->input('link_url', ''), 'plugin_setting');
        $settings->set('announcement_bar.link_text', (string) $request->input('link_text', ''), 'plugin_setting');

        return redirect()->route('backend.announcement-bar.settings')
            ->with('success', __('announcement-bar::ab.saved'));
    }
}
