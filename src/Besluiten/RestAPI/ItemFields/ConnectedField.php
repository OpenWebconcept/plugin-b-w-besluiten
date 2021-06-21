<?php

namespace OWC\Besluiten\RestAPI\ItemFields;

use OWC\Besluiten\Foundation\Plugin;
use OWC\Besluiten\Models\Besluit as BesluitModel;
use OWC\Besluiten\Repositories\Besluit;
use OWC\Besluiten\Support\CreatesFields;
use WP_Post;
use WP_Query;

class ConnectedField extends CreatesFields
{
    /**
     * Instance of the Plugin.
     *
     * @var Plugin
     */
    protected $plugin;

    /**
     * @param Plugin $plugin
     */
    public function __construct(Plugin $plugin)
    {
        $this->plugin      = $plugin;
        $this->respository = new Besluit($plugin);
    }

    /**
     * Creates an array of connected posts.
     *
     * @param WP_Post $post
     *
     * @return array
     */
    public function create(WP_Post $post): array
    {
        $besluit       = BesluitModel::makeFrom($post);
        $categoriesIDs = $this->getCategoriesIDs($besluit);

        return $this->getConnectedItems($categoriesIDs, $besluit->getID());
    }

    /**
     * @param BesluitModel $besluit
     *
     * @return array
     */
    protected function getCategoriesIDs(BesluitModel $besluit): array
    {
        $terms = $besluit->getTerms('public-decision-category');

        if (!is_array($terms)) {
            return [];
        }

        return array_map(function ($term) {
            return $term->term_id;
        }, $terms);
    }

    /**
     * Get connected items and exclude current post.
     *
     * @param array $categoriesIDs
     * @param integer $besluitID
     *
     * @return array
     */
    protected function getConnectedItems(array $categoriesIDs, int $besluitID): array
    {
        $items = $this->query($categoriesIDs, $besluitID);

        if (empty($items)) {
            return [];
        }

        return array_map(function (WP_Post $post) {
            $besluit = BesluitModel::makeFrom($post);

            return [
                'id'                => $besluit->getID(),
                'date'              => $besluit->getDateI18n('Y-m-d H:i:s'),
                'portal_url'        => $this->respository->makePortalURL($besluit->getPostName()),
                'title'             => $besluit->getTitle(),
                'image'             => $besluit->getThumbnail(),
                'content'           => $besluit->getContent(),
                'excerpt'           => $besluit->getExcerpt(),
                'slug'              => $besluit->getPostName(),
                'type'              => $besluit->getPostType()
            ];
        }, $items);
    }

    /**
     * Get connected items based on taxonomy.
     *
     * @param array $categoriesIDs
     * @param integer $besluitID
     *
     * @return array
     */
    protected function query(array $categoriesIDs, int $besluitID): array
    {
        $args = [
            'post_type' => 'public-decision',
            'tax_query' => [
                [
                    'taxonomy' => 'public-decision-category',
                    'field'    => 'term_id',
                    'terms'    => $categoriesIDs,
                ]
            ],
            'post__not_in' => [$besluitID]
        ];

        $query = new WP_Query($args);

        return $query->posts;
    }
}
