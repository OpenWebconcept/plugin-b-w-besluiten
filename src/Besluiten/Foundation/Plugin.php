<?php

namespace OWC\Besluiten\Foundation;

use OWC\Besluiten\Expiration\ExpirationController;

/**
 * BasePlugin which sets all the serviceproviders.
 */
class Plugin
{
    /**
     * Name of the plugin.
     *
     * @var string
     */
    const NAME = 'bw-besluiten';

    /**
     * Version of the plugin.
     * Used for setting versions of enqueue scripts and styles.
     *
     * @var string VERSION
     */
    const VERSION = '1.0.0';

    /**
     * Path to the root of the plugin.
     *
     * @var string $rootPath
     */
    protected $rootPath;

    /**
     * Instance of the configuration repository.
     *
     * @var Config
     */
    public $config;

    /**
     * Instance of the Hook loader.
     *
     * @var Loader
     */
    public $loader;

    /**
     * Constructor of the BasePlugin
     *
     * @param string $rootPath
     *
     * @return void
     */
    public function __construct(string $rootPath)
    {
        $this->rootPath = $rootPath;
        load_plugin_textdomain($this->getName(), false, $this->getName() . '/languages/');

        $this->loader = new Loader;

        $this->config = new Config($this->rootPath . '/config');
        $this->config->setProtectedNodes(['core']);
        $this->config->boot();
    }

    public static function setupAndTeardown(): void
    {
        /**
         * The code that runs during plugin activation.
         */
        \register_activation_hook(BW_DIR . '/' . BW_FILE, function () {
            (new Activator())->activate();
        });

        \add_action('delete_expired_public_decisions', [ExpirationController::class, 'deleteExpiredPosts'], 10, 0);

        /**
         * The code that runs during plugin deactivation.
         */
        \register_deactivation_hook(BW_DIR . '/' . BW_FILE, function () {
            (new Deactivator())->deactivate();
        });
    }

    /**
     * Boot the plugin.
     *
     * @hook plugins_loaded
     *
     * @return bool
     */
    public function boot(): bool
    {
        $dependencyChecker = new DependencyChecker($this->config->get('core.dependencies'));

        if ($dependencyChecker->failed()) {
            $dependencyChecker->notify();
            deactivate_plugins(plugin_basename($this->rootPath . '/' . $this->getName() . '.php'));

            return false;
        }

        // Set up service providers.
        $this->callServiceProviders('register');

        // Boot service providers.
        $this->callServiceProviders('boot');

        // Register the Hook loader.
        $this->loader->addAction('init', $this, 'filterPlugin', 4);
        $this->loader->register();

        return true;
    }

    /**
     * Allows for hooking into the plugin name.
     *
     * @return void
     */
    public function filterPlugin()
    {
        do_action('owc/' . self::NAME . '/plugin', $this);
    }

    /**
     * Call method on service providers.
     *
     * @param string $method
     * @param string $key
     *
     * @return void
     *
     * @throws \Exception
     */
    public function callServiceProviders($method, $key = '')
    {
        $offset   = $key ? "core.providers.{$key}" : 'core.providers';
        $services = $this->config->get($offset);

        foreach ($services as $service) {
            if (is_array($service)) {
                continue;
            }

            $service = new $service($this);

            if (!$service instanceof ServiceProvider) {
                throw new \Exception('Provider must be an instance of ServiceProvider.');
            }

            if (method_exists($service, $method)) {
                $service->$method();
            }
        }
    }

    /**
     * Get the name of the plugin.
     *
     * @return string
     */
    public function getName()
    {
        return static::NAME;
    }

    /**
     * Get the version of the plugin.
     *
     * @return string
     */
    public function getVersion()
    {
        return static::VERSION;
    }

    /**
     * Return root path of plugin.
     *
     * @return string
     */
    public function getRootPath(): string
    {
        return $this->rootPath;
    }
}
