<?php

namespace OWC\Besluiten\Traits;

trait CheckPluginActive
{
    public static function isPluginActive(string $file): bool
    {
        if (!function_exists('is_plugin_active')) {
            include_once ABSPATH . 'wp-admin/includes/plugin.php';
        }

        return is_plugin_active($file);
    }

    public static function isPluginOpenPubBaseActive(): bool
    {
        return self::isPluginActive('openpub-base/openpub-base.php');
    }
}
