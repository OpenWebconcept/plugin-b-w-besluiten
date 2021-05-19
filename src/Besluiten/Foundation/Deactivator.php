<?php

namespace OWC\Besluiten\Foundation;

class Deactivator
{
    public function deactivate(): void
    {
        $this->deactivateCronDeleteExpired();
    }

    /**
     * Unschedule event that will delete expired posts.
     *
     * @return void
     */
    protected function deactivateCronDeleteExpired(): void
    {
        if (!wp_next_scheduled('delete_expired_public_decisions', [])) {
            return;
        }

        wp_clear_scheduled_hook('delete_expired_public_decisions');
    }
}
