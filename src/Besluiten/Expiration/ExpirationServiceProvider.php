<?php

namespace OWC\Besluiten\Expiration;

use OWC\Besluiten\Foundation\ServiceProvider;

class ExpirationServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->plugin->loader->addAction('updated_post_meta', new ExpirationController(), 'afterMetaUpdate', 10, 4);
    }
}
