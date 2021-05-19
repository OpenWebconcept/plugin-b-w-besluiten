<?php

namespace OWC\Besluiten\Expiration;

class ExpirationController
{
    /**
     * Handle the expiration date of an item.
     *
     * @param integer $metaID
     * @param integer $postID
     * @param string $metaKey
     * @param string $metaValue
     * 
     * @return void
     */
    public function afterMetaUpdate(int $metaID, int $postID, string $metaKey, string $metaValue): void
    {
        $post = get_post($postID);

        if ($post->post_type !== 'public-decision' || wp_is_post_revision($postID) || (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)) {
            return;
        }

        /**
         * When the post is not published, clear the expiration and deletion date.
         */
        if (in_array($post->post_status, ['draft', 'pending', 'auto-draft'])) {
            update_post_meta($postID, '_owc_public_decisions_expiration_date', '');
            update_post_meta($postID, '_owc_public_decisions_delete_date', '');
            return;
        }

        /**
         * When the post is published but there is no expiration date set, use 'now' plus four weeks.
         */
        if (empty(get_post_meta($postID, '_owc_public_decisions_expiration_date', true))) {
            update_post_meta($postID, '_owc_public_decisions_expiration_date', (new \DateTime('now', new \DateTimeZone('Europe/Amsterdam')))->modify('+4 week')->format('Y-m-d H:i:s'));
        }

        /**
         * When the post is published update the deletion date.
         */
        update_post_meta($postID, '_owc_public_decisions_delete_date', (new \DateTime(get_post_meta($postID, '_owc_public_decisions_expiration_date', true), new \DateTimeZone('Europe/Amsterdam')))->modify('+4 week')->format('Y-m-d H:i:s'));
    }

    /**
     * Used in scheduled event that runts on plugin activation.
     *
     * @return void
     */
    public static function deleteExpiredPosts(): void
    {
        if (!class_exists('\WP_Query')) {
            return;
        }

        $args = [
            'post_type' => 'public-decision',
            'post_status' => 'publish',
            'meta_query' => [
                'relation' => 'AND',
                [
                    'key' => '_owc_public_decisions_delete_date',
                    'value' => date('Y-m-d H:i:s'),
                    'compare' => '<=',
                    'type' => 'DATE'
                ],
                [
                    'key' => '_owc_public_decisions_delete_date',
                    'compare' => 'EXISTS',
                ],
                [
                    'key' => '_owc_public_decisions_expiration_date',
                    'compare' => 'EXISTS',
                ],
            ]
        ];

        $query = new \WP_Query($args);

        if (empty($query->posts)) {
            return;
        }

        foreach ($query->posts as $post) {
            \wp_delete_post($post->ID, true);
        }
    }
}
