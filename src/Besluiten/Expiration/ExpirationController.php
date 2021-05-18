<?php

namespace OWC\Besluiten\Expiration;

use \WP_Post;

class ExpirationController
{
    protected function getMeta($post)
    {
        var_dump(get_post_meta($post->ID, '_owc_public_decisions_expiration_date', true));
        die;
    }

    /**
     * Update the post modified dates on conditional
     * 
     * @param integer $metaID
     * @param integer $postID
     * @param string $metaKey
     * @param $metaValue
     * 
     * @return void
     */
    public function afterMetaUpdate(int $metaID, int $postID, string $metaKey, $metaValue): void
    {
        $post      = get_post($postID);
        $postTypes = ['public-decision'];
        $postType  = $post->post_type;

        if (!in_array($postType, $postTypes) || wp_is_post_revision($postID) || (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)) {
            return;
        }

        if (in_array($post->post_status, ['draft', 'pending', 'auto-draft'])) {
            update_post_meta($postID, '_owc_public_decisions_expiration_date', '');
            return;
        }

        if (empty(get_post_meta($postID, '_owc_public_decisions_expiration_date', true))) {
            update_post_meta($postID, '_owc_public_decisions_expiration_date', (new \DateTime('now', new \DateTimeZone('Europe/Amsterdam')))->modify('+4 week')->format('d-m-Y H:i'));
        }
    }
}
