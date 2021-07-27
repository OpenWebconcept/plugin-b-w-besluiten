<?php

namespace OWC\Besluiten\RestAPI\ItemFields;

use OWC\Besluiten\Support\CreatesFields;
use WP_Post;

class ExpiredField extends CreatesFields
{
    /**
     * Get the expired status to the post.
     */
    public function create(WP_Post $post): array
    {
        return $this->getExpiredStatus($post);
    }

    /**
     * Get expired status of a post, if URL & title are present.
     */
    private function getExpiredStatus(WP_Post $post): array
    {
        $status = \get_post_meta($post->ID, '_owc_public_decisions_expiration_date', true);
        if (empty($status)) {
            return [
                    'status'  => false,
                    'on'      => false
            ];
        }
        $status = explode(' ', $status);

        // If no time is defined, add this for compatibility.
        if (1 >= count($status)) {
            $status[] = ' 00:00:00';
        }
        $timezone = \get_option('timezone_string');
        $date     = \DateTime::createFromFormat('Y-m-d H:i:s', implode('', $status), new \DateTimeZone($timezone));
        $dateNow  = new \DateTime(null, new \DateTimeZone($timezone));

        return [
            'status'  => ($date < $dateNow),
            'on'      => $date
        ];
    }
}
