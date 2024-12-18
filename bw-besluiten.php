<?php

/**
 * Plugin Name:       Yard | B&W Besluiten
 * Plugin URI:        https://www.openwebconcept.nl/
 * Description:       Mayor and City Counsel Members decisions plug-in enables municipalities to create posts based on the public decisions taken during their weekly meetings.
 * Version:           1.1.1
 * Author:            Yard | Digital Agency
 * Author URI:        https://www.yard.nl/
 * License:           GPL-3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       public-decisions
 * Domain Path:       /languages
 */

/**
 * If this file is called directly, abort.
 */
if (! defined('WPINC')) {
	die;
}

define('BW_DIR', basename(__DIR__));
define('BW_FILE', basename(__FILE__));
define('BW_VERSION', '1.1.1');

/**
 * Manual loaded file: the autoloader.
 */
require_once __DIR__ . '/autoloader.php';
$autoloader = new OWC\Besluiten\Autoloader();

/**
 * Plugin will be activated as last.
 * If the openpub-base plugin is used it should be activated first for the combined settings page to work.
 */
\add_action("activated_plugin", function () {
	$currentFile = preg_replace('/(.*)plugins\/(.*)$/', WP_PLUGIN_DIR . "/$2", __FILE__);
	$plugin = plugin_basename(trim($currentFile));
	$activePlugins = get_option('active_plugins');
	$pluginKey = array_search($plugin, $activePlugins);

	array_splice($activePlugins, $pluginKey, 1);
	array_push($activePlugins, $plugin);
	update_option('active_plugins', $activePlugins);
});

/**
 * Register activation and de-activation hook.
 */
OWC\Besluiten\Foundation\Plugin::setupAndTeardown();

/**
 * Begin execution of the plugin
 *
 * This hook is called once any activated plugins have been loaded. Is generally used for immediate filter setup, or
 * plugin overrides. The plugins_loaded action hook fires early, and precedes the setup_theme, after_setup_theme, init
 * and wp_loaded action hooks.
 */
\add_action('plugins_loaded', function () {
	$plugin = new OWC\Besluiten\Foundation\Plugin(__DIR__);
	$plugin->boot();
}, 10);
