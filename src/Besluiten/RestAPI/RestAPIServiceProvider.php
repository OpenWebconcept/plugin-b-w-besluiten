<?php

namespace OWC\Besluiten\RestAPI;

use OWC\Besluiten\Foundation\ServiceProvider;
use OWC\Besluiten\RestAPI\Controllers\BesluitenController;
use WP_REST_Server;

class RestAPIServiceProvider extends ServiceProvider
{
    /**
     * @var string
     */
    private $namespace = 'owc/openpub/v1';

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register(): void
    {
        $this->plugin->loader->addFilter('rest_api_init', $this, 'registerRoutes');
        $this->plugin->loader->addFilter('owc/config-expander/rest-api/whitelist', $this, 'whitelist', 10, 1);

        $this->registerModelFields();
    }

    public function registerRoutes()
    {
        register_rest_route($this->namespace, 'besluiten', [
            'methods'             => WP_REST_Server::READABLE,
            'callback'            => [new BesluitenController($this->plugin), 'getItems'],
            'permission_callback' => '__return_true',
        ]);

        register_rest_route($this->namespace, 'besluiten/(?P<id>\d+)', [
            'methods'             => WP_REST_Server::READABLE,
            'callback'            => [new BesluitenController($this->plugin), 'getItem'],
            'permission_callback' => '__return_true',
        ]);

        register_rest_route($this->namespace, 'besluiten/(?P<slug>[\w-]+)', [
            'methods'             => WP_REST_Server::READABLE,
            'callback'            => [new BesluitenController($this->plugin), 'getItemBySlug'],
            'permission_callback' => '__return_true',
        ]);
    }

    /**
     * Whitelist endpoints within Config Expander.
     *
     * @param array $whitelist
     * @return array
     */
    public function whitelist(array $whitelist): array
    {
        // Remove default root endpoint
        if (!empty($whitelist['wp/v2'])) {
            unset($whitelist['wp/v2']);
        }

        if (empty($whitelist[$this->namespace])) {
            $whitelist[$this->namespace] = [
                'endpoint_stub' => '/' . $this->namespace,
                'methods'       => ['GET'],
            ];
        }

        return $whitelist;
    }

    /**
     * Register fields for all configured posttypes.
     *
     * @return void
     */
    private function registerModelFields(): void
    {
        // Add global fields for all Models.
        foreach ($this->plugin->config->get('api.models') as $posttype => $data) {
            foreach ($data['fields'] as $key => $creator) {
                $class = '\OWC\Besluiten\Repositories\\' . ucfirst($posttype);
                if (class_exists($class)) {
                    $creator = new $creator($this->plugin);
                    $class::addGlobalField($key, $creator, function () use ($creator) {
                        return $creator->executeCondition()();
                    });
                }
            }
        }
    }
}
