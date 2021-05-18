<?php

namespace OWC\Besluiten\Repositories;

use OWC\Besluiten\Models\Besluit as BesluitModel;
use WP_Post;

class Besluit extends AbstractRepository
{
    protected $posttype = 'public-decision';

    protected static $globalFields = [];

    /**
     * Transform a single WP_Post item.
     *
     * @param WP_Post $post
     *
     * @return array
     */
    public function transform(WP_Post $post): array
    {
        $besluit = BesluitModel::makeFrom($post);

        $data = [
            'id'                => $besluit->getID(),
            'date'              => $besluit->getDateI18n('Y-m-d H:i:s'),
            'portal_url'        => $this->makePortalURL($besluit->getPostName()),
            'title'             => $besluit->getTitle(),
            'image'             => $besluit->getThumbnail(),
            'content'           => $besluit->getContent(),
            'excerpt'           => $besluit->getExcerpt(65),
            'slug'              => $besluit->getPostName(),
            'type'              => $besluit->getPostType()
        ];

        $data = $this->assignFields($data, $post);

        return $data;
    }

    /**
     * Make the portal url used in the portal.
     *
     * @param string $slug
     *
     * @return string
     */
    public function makePortalURL(string $slug): string
    {
        if (empty($this->plugin->settings->getPortalURL()) || empty($this->plugin->settings->getPortalItemSlug())) {
            return '';
        }

        return sprintf('%s/%s/%s', $this->plugin->settings->getPortalURL(), $this->plugin->settings->getPortalItemSlug(), $slug);
    }

    /**
     * Add tax query to current query.
     *
     * @param string $type
     *
     * @return array
     */
    public static function addFilterTypeParameters(string $type = ''): array
    {
        if (empty($type)) {
            return [];
        }

        return [
            'tax_query' => [
                [
                    'taxonomy' => 'press_mailing_list',
                    'terms'    => $type,
                    'field'    => 'slug'
                ]
            ]
        ];
    }
}
