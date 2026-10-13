@php
    $abSettings = cms()->settings();
    $abEnabled = (string) $abSettings->get('announcement_bar.enabled', '0') === '1';
    $abMessage = (string) $abSettings->get('announcement_bar.message', '');

    // Colours go into CSS: only strict hex values, never raw input
    $abColor = fn (string $value, string $fallback) => preg_match('/^#([0-9a-f]{3}|[0-9a-f]{6})$/i', $value) ? $value : $fallback;
    $abBg = $abColor((string) $abSettings->get('announcement_bar.bg_color', '#fbbf24'), '#fbbf24');
    $abText = $abColor((string) $abSettings->get('announcement_bar.text_color', '#1c1917'), '#1c1917');

    $abBottom = $abSettings->get('announcement_bar.position', 'top') === 'bottom';
    $abDismissible = (string) $abSettings->get('announcement_bar.dismissible', '1') === '1';

    // Only web, mail and phone links or site-relative paths — never javascript: and the like
    $abLinkUrl = (string) $abSettings->get('announcement_bar.link_url', '');
    $abLinkText = (string) $abSettings->get('announcement_bar.link_text', '');
    $abShowLink = $abLinkUrl !== '' && $abLinkText !== '' && preg_match('#^(https?://|mailto:|tel:|/(?!/))#i', $abLinkUrl);
@endphp

@if($abEnabled && $abMessage !== '')
{{-- Self-contained styles: the theme's CSS does not know this package's classes --}}
<style>
#announcement-bar {
    --ab-bg: {{ $abBg }};
    --ab-fg: {{ $abText }};
    position: fixed;
    left: 0;
    right: 0;
    {{ $abBottom ? 'bottom' : 'top' }}: 0;
    z-index: 50;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.5rem 1rem;
    background: var(--ab-bg);
    color: var(--ab-fg);
    font-size: 0.875rem;
    line-height: 1.4;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.08);
}
#announcement-bar .ab-text {
    flex: 1;
    min-width: 0;
    text-align: center;
    overflow-wrap: anywhere;
}
#announcement-bar .ab-link {
    margin-inline-start: 0.5rem;
    color: inherit;
    font-weight: 500;
    text-decoration: underline;
}
#announcement-bar .ab-link:hover,
#announcement-bar .ab-dismiss:hover {
    opacity: 0.7;
}
#announcement-bar .ab-dismiss {
    flex-shrink: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 1.75rem;
    height: 1.75rem;
    padding: 0;
    border: 0;
    border-radius: 0.375rem;
    background: transparent;
    color: inherit;
    cursor: pointer;
    transition: opacity 0.15s ease;
}
#announcement-bar .ab-dismiss:focus-visible {
    outline: 2px solid currentColor;
    outline-offset: 2px;
}
#announcement-bar .ab-dismiss svg {
    width: 1rem;
    height: 1rem;
}
</style>

<div id="announcement-bar" role="region" aria-label="{{ __('announcement-bar::ab.region_label') }}" data-ab-position="{{ $abBottom ? 'bottom' : 'top' }}">
    <div class="ab-text">
        <span>{{ $abMessage }}</span>
        @if($abShowLink)
            <a href="{{ $abLinkUrl }}" class="ab-link">{{ $abLinkText }}</a>
        @endif
    </div>
    @if($abDismissible)
        <button type="button" class="ab-dismiss" data-ab-dismiss aria-label="{{ __('announcement-bar::ab.dismiss') }}">
            <x-ui.icon name="x" />
        </button>
    @endif
</div>

<script @cspNonce>
(function () {
    var bar = document.getElementById('announcement-bar');
    if (!bar) return;

    // Keep the page content clear of the fixed bar
    var side = bar.getAttribute('data-ab-position') === 'bottom' ? 'paddingBottom' : 'paddingTop';
    var original = document.body.style[side];

    function reserve() {
        document.body.style[side] = bar.offsetHeight + 'px';
    }

    reserve();
    window.addEventListener('resize', reserve);

    var dismiss = bar.querySelector('[data-ab-dismiss]');
    if (dismiss) {
        dismiss.addEventListener('click', function () {
            window.removeEventListener('resize', reserve);
            bar.remove();
            document.body.style[side] = original;
        });
    }
})();
</script>
@endif
