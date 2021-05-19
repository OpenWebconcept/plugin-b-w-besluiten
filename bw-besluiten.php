<?php

/**
 * Plugin Name:       Yard | B&W Besluiten
 * Plugin URI:        https://www.openwebconcept.nl/
 * Description:       Mayor and City Counsel Members decisions plug-in enables municipalities to create posts based on the public decisions taken during their weekly meetings.
 * Version:           1.0.0
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
if (!defined('WPINC')) {
    die;
}

define('BW_DIR', basename(__DIR__));
define('BW_FILE', basename(__FILE__));

/**
 * Manual loaded file: the autoloader.
 */
require_once __DIR__ . '/autoloader.php';
$autoloader = new OWC\Besluiten\Autoloader();

/**
 * Nalopen!!
 * Plugin wordt als laatst opgestart. Omdat de pub eerst geladen moet zijn om de settings pagina te laten werken.
 */
\add_action("activated_plugin", function () {
    $wp_path_to_this_file = preg_replace('/(.*)plugins\/(.*)$/', WP_PLUGIN_DIR . "/$2", __FILE__);
    $this_plugin = plugin_basename(trim($wp_path_to_this_file));
    $active_plugins = get_option('active_plugins');
    $this_plugin_key = array_search($this_plugin, $active_plugins);
    array_splice($active_plugins, $this_plugin_key, 1);
    array_push($active_plugins, $this_plugin);
    update_option('active_plugins', $active_plugins);
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
