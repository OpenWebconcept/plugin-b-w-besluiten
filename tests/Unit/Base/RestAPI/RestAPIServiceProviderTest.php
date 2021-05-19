<?php

namespace OWC\Besluiten\Tests\Base\RestAPI;

use Mockery as m;
use OWC\Besluiten\Config;
use OWC\Besluiten\Foundation\Loader;
use OWC\Besluiten\Foundation\Plugin;
use OWC\Besluiten\RestAPI\RestAPIServiceProvider;
use OWC\Besluiten\Tests\TestCase;
use WP_Mock;

class RestAPIServiceProviderTest extends TestCase
{
    protected function setUp(): void
    {
        WP_Mock::setUp();

        \WP_Mock::userFunction('wp_parse_args', [
            'return' => [
                '_owc_setting_portal_url'                       => '',
                '_owc_setting_portal_openpub_item_slug'         => '',
                '_owc_setting_use_portal_url'                   => 0,
                '_owc_setting_use_escape_element'               => 0,
                '_owc_setting_portal_public_decision_item_slug' => '',
                '_owc_setting_additional_message'               => ''
            ]
        ]);

        \WP_Mock::userFunction('get_option', [
            'return' => [
                '_owc_setting_portal_url'                       => '',
                '_owc_setting_portal_openpub_item_slug'         => '',
                '_owc_setting_use_portal_url'                   => 0,
                '_owc_setting_use_escape_element'               => 0,
                '_owc_setting_portal_public_decision_item_slug' => '',
                '_owc_setting_additional_message'               => ''
            ]
        ]);
    }

    protected function tearDown(): void
    {
        WP_Mock::tearDown();
    }

    /** @test */
    public function check_registration_of_rest_endpoints()
    {
        $config = m::mock(Config::class);
        $plugin = m::mock(Plugin::class);

        $plugin->config = $config;
        $plugin->loader = m::mock(Loader::class);

        // use function is_plugin_active
        \WP_Mock::userFunction('is_plugin_active', [
            'return' => true
        ]);

        $service = new RestAPIServiceProvider($plugin);

        $plugin->loader->shouldReceive('addFilter')->withArgs([
            'owc/config-expander/rest-api/whitelist',
            $service,
            'whitelist',
            10,
            1
        ])->once();

        $plugin->loader->shouldReceive('addFilter')->withArgs([
            'rest_api_init',
            $service,
            'registerRoutes'
        ])->once();

        WP_Mock::userFunction(
            'post_type_exists',
            [
                'args'   => [WP_Mock\Functions::anyOf('posttype1', 'posttype2')],
                'times'  => '0+',
                'return' => true
            ]
        );

        WP_Mock::passthruFunction('register_rest_route', [
            'times'  => '0+',
            'return' => true
        ]);

        $config->shouldReceive('get')->withArgs(['api.models'])->andReturn([])->once();

        $service->register();

        $this->assertTrue(true);
    }
}
