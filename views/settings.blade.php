<x-app-layout>
    <x-slot name="header">{{ __('announcement-bar::ab.settings_title') }}</x-slot>

    @php
        $val = fn (string $key) => old($key, $ab[$key]);
        $isOn = fn (string $key) => in_array((string) old($key, $ab[$key]), ['1', 'on', 'true'], true);
        $published = $ab['enabled'] === '1';
    @endphp

    <x-ui.page :title="__('announcement-bar::ab.heading')" :lead="__('announcement-bar::ab.page_lead')">
        <x-slot:actions>
            <x-ui.button variant="primary" size="md" icon="check" type="submit" form="ab-settings-form">{{ __('translation.save') }}</x-ui.button>
        </x-slot:actions>

        {{-- Settings on the left, live preview on the right (narrow: below) --}}
        <div class="ui-split">
            <form id="ab-settings-form" action="{{ route('backend.announcement-bar.settings.save') }}" method="POST" class="ui-split-main">
                @csrf

                <x-ui.card :title="__('announcement-bar::ab.content_heading')" icon="message-square" tone="accent">
                    <div class="flex flex-col gap-4">
                        <x-ui.switch-row
                            name="enabled"
                            :label="__('announcement-bar::ab.enable')"
                            :hint="__('announcement-bar::ab.enable_hint')"
                            :checked="$isOn('enabled')"
                            on-value="1"
                            off-value="0"
                        />

                        <x-ui.field name="message" :label="__('announcement-bar::ab.message')" :help="__('announcement-bar::ab.message_help')">
                            <x-ui.input id="message" name="message" maxlength="500" data-count-max="500" required :value="$val('message')" />
                        </x-ui.field>

                        <div class="ui-grid">
                            <x-ui.field name="link_text" :label="__('announcement-bar::ab.link_text')" optional>
                                <x-ui.input id="link_text" name="link_text" maxlength="100" :value="$val('link_text')" />
                            </x-ui.field>

                            <x-ui.field name="link_url" :label="__('announcement-bar::ab.link_url')" :help="__('announcement-bar::ab.link_url_help')" optional>
                                <x-ui.input id="link_url" name="link_url" type="url" icon="link" maxlength="500" :placeholder="__('announcement-bar::ab.link_url_placeholder')" :value="$val('link_url')" />
                            </x-ui.field>
                        </div>
                    </div>
                </x-ui.card>

                <x-ui.card :title="__('announcement-bar::ab.appearance_heading')" icon="palette" tone="violet">
                    <div class="flex flex-col gap-4">
                        <div class="ui-grid">
                            <x-ui.field name="bg_color" :label="__('announcement-bar::ab.bg_color')">
                                <x-ui.color name="bg_color" :value="$val('bg_color')" />
                            </x-ui.field>

                            <x-ui.field name="text_color" :label="__('announcement-bar::ab.text_color')">
                                <x-ui.color name="text_color" :value="$val('text_color')" />
                            </x-ui.field>
                        </div>

                        <x-ui.field name="position" :label="__('announcement-bar::ab.position')">
                            <x-ui.select id="position" name="position">
                                <option value="top" @selected($val('position') === 'top')>{{ __('announcement-bar::ab.position_top') }}</option>
                                <option value="bottom" @selected($val('position') === 'bottom')>{{ __('announcement-bar::ab.position_bottom') }}</option>
                            </x-ui.select>
                        </x-ui.field>

                        <x-ui.switch-row
                            name="dismissible"
                            :label="__('announcement-bar::ab.dismissible')"
                            :hint="__('announcement-bar::ab.dismissible_hint')"
                            :checked="$isOn('dismissible')"
                            on-value="1"
                            off-value="0"
                        />
                    </div>

                    <x-slot:foot>
                        <div class="flex justify-end">
                            <x-ui.button variant="primary" size="md" icon="check" type="submit">{{ __('translation.save') }}</x-ui.button>
                        </div>
                    </x-slot:foot>
                </x-ui.card>
            </form>

            <div class="ui-split-aside">
                <x-ui.card :title="__('announcement-bar::ab.preview')" icon="eye" tone="teal">
                    <x-slot:head>
                        <x-ui.badge :tone="$published ? 'positive' : 'neutral'">
                            {{ $published ? __('announcement-bar::ab.status_visible') : __('announcement-bar::ab.status_hidden') }}
                        </x-ui.badge>
                    </x-slot:head>

                    <div class="flex flex-col gap-3">
                        {{-- A sketch of a page: the bar moves to the top or bottom with the position --}}
                        <div class="flex flex-col gap-3 rounded-lg border border-dashed border-line bg-surface-sunken p-3" data-ab-frame>
                            {{-- Colours come from data attributes, applied by the script below --}}
                            <div
                                class="flex items-center gap-2 rounded-md px-4 py-2 text-sm shadow-sm"
                                data-ab-preview
                                data-bg="{{ $val('bg_color') }}"
                                data-fg="{{ $val('text_color') }}"
                            >
                                <span class="min-w-0 flex-1 break-words text-center">
                                    <span data-ab-preview-message>{{ $val('message') }}</span>
                                    <span class="font-medium underline {{ filled($val('link_text')) && filled($val('link_url')) ? '' : 'hidden' }}" data-ab-preview-link>{{ $val('link_text') }}</span>
                                </span>
                                <span class="shrink-0 {{ $isOn('dismissible') ? '' : 'hidden' }}" data-ab-preview-dismiss role="img" aria-label="{{ __('announcement-bar::ab.dismiss') }}">
                                    <x-ui.icon name="x" />
                                </span>
                            </div>

                            <div class="p-6 text-center text-xs text-fg-muted" data-ab-preview-page>
                                {{ __('announcement-bar::ab.preview_page') }}
                            </div>
                        </div>

                        <p class="ui-help">{{ __('announcement-bar::ab.preview_hint') }}</p>
                    </div>
                </x-ui.card>
            </div>
        </div>
    </x-ui.page>

    @push('scripts')
    <script @cspNonce>
    document.addEventListener('DOMContentLoaded', function () {
        var form = document.getElementById('ab-settings-form');
        var preview = document.querySelector('[data-ab-preview]');
        if (!form || !preview) return;

        var frame = preview.closest('[data-ab-frame]');
        var message = preview.querySelector('[data-ab-preview-message]');
        var link = preview.querySelector('[data-ab-preview-link]');
        var dismiss = preview.querySelector('[data-ab-preview-dismiss]');
        var hex = /^#([0-9a-f]{3}|[0-9a-f]{6})$/i;

        function value(name) {
            var field = form.querySelector('[name="' + name + '"]:not([type="hidden"])');
            return field ? field.value.trim() : '';
        }

        function checked(name) {
            var field = form.querySelector('input[type="checkbox"][name="' + name + '"]');
            return !!(field && field.checked);
        }

        function color(name, fallback) {
            var picked = value(name);
            return hex.test(picked) ? picked : fallback;
        }

        function render() {
            preview.style.backgroundColor = color('bg_color', preview.dataset.bg);
            preview.style.color = color('text_color', preview.dataset.fg);

            message.textContent = value('message');
            link.textContent = value('link_text');
            link.classList.toggle('hidden', !(value('link_text') && value('link_url')));
            dismiss.classList.toggle('hidden', !checked('dismissible'));

            if (frame) {
                if (value('position') === 'bottom') {
                    frame.appendChild(preview);
                } else {
                    frame.insertBefore(preview, frame.firstChild);
                }
            }
        }

        form.addEventListener('input', render);
        form.addEventListener('change', render);
        render();
    });
    </script>
    @endpush
</x-app-layout>
