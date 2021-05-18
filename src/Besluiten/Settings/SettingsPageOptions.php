<?php

namespace OWC\Besluiten\Settings;

use OWC\Besluiten\Traits\CheckPluginActive;

class SettingsPageOptions
{
    /**
     * Settings defined on settings page.
     *
     * @var array
     */
    private $settings;

    public function __construct(array $settings)
    {
        $this->settings = $settings;
    }

    /**
     * URL to the portal website.
     *
     * @return string
     */
    public function getPortalURL(): string
    {
        return $this->settings['_owc_setting_portal_url'] ?? '';
    }

    public function getPortalItemSlug(): string
    {
        return $this->settings['_owc_setting_portal_public_decision_item_slug'] ?? '';
    }

    public static function make(): self
    {
        $defaultSettings = [
            '_owc_setting_portal_url'                        => '',
            '_owc_setting_portal_public_decision_item_slug'  => ''
        ];

        $options = get_option('_owc_public_decisions_settings', []);

        if (CheckPluginActive::isPluginOpenPubBaseActive()) {
            // include openpub-base settings.
            $options = array_merge($options, get_option('_owc_openpub_base_settings', []));
        };

        return new static(wp_parse_args($options, $defaultSettings));
    }
}
