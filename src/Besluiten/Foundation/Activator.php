<?php

namespace OWC\Besluiten\Foundation;

class Activator
{
    public function activate(): void
    {
        $this->activateCronDeleteExpired();
    }

    /**
     * Schedule event that will delete expired posts.
     *
     * @return void
     */
    protected function activateCronDeleteExpired(): void
    {
        // Prevent double registration of event.
        if (wp_next_scheduled('delete_expired_public_decisions', [])) {
            return;
        }

        wp_schedule_event(strtotime('today midnight'), 'daily', 'delete_expired_public_decisions', [], true);
    }
}
