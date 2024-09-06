<?php

return [

	// Service Providers.
	'providers' => [
		// Global providers.
		OWC\Besluiten\RestAPI\RestAPIServiceProvider::class,
		OWC\Besluiten\PostType\PostTypeServiceProvider::class,
		OWC\Besluiten\Metabox\MetaboxServiceProvider::class,
		OWC\Besluiten\Settings\SettingsServiceProvider::class,
		OWC\Besluiten\Expiration\ExpirationServiceProvider::class,
		OWC\Besluiten\Taxonomy\TaxonomyServiceProvider::class,
	],

	/**
	 * Dependencies upon which the plugin relies.
	 *
	 * Required: type, label
	 * Optional: message
	 *
	 * Type: plugin
	 * - Optional: version
	 * - Required: file
	 * - Optional: alt_file (alternative file path)
	 *   - This path is checked first and will override the 'file' path if the plugin is activated.
	 *
	 * Type: class
	 * - Required: name
	 */
	'dependencies' => [
		[
			'type' => 'plugin',
			'label' => 'RWMB Metabox',
			'version' => '4.14.0',
			'file' => 'meta-box/meta-box.php',
		],
		[
			'type' => 'plugin',
			'label' => 'Meta Box Group',
			'version' => '1.2.14',
			'file' => 'metabox-group/meta-box-group.php',
			'alt_file' => 'meta-box-group/meta-box-group.php',
		],
	],
];
