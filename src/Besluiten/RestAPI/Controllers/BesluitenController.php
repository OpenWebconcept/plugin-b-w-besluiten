<?php

namespace OWC\Besluiten\RestAPI\Controllers;

use OWC\Besluiten\Repositories\Besluit;
use WP_Error;
use WP_REST_Request;

class BesluitenController extends BaseController
{
    public function getItems(WP_REST_Request $request)
    {
        $items = (new Besluit($this->plugin))
            ->query($this->getPaginatorParams($request))
            ->query(Besluit::addFilterExpirationDateParameters());

        $data  = $items->all();
        $query = $items->getQuery();

        return $this->addPaginator($data, $query);
    }

    /**
     * Get an individual post item.
     *
     * @param WP_REST_Request $request $request
     *
     * @return array|WP_Error
     * @throws \OWC\Besluiten\Exceptions\PropertyNotExistsException
     * @throws \ReflectionException
     */
    public function getItem(WP_REST_Request $request)
    {
        $id = (int) $request->get_param('id');

        $item = (new Besluit($this->plugin))
            ->query(Besluit::addFilterExpirationDateParameters())
            ->find($id);

        if (!$item) {
            return new WP_Error('no_item_found', sprintf("Item with ID '%d' not found (anymore)", $id), [
                'status' => 404,
            ]);
        }

        return $item;
    }

    /**
     * Get an individual post item by slug.
     *
     * @param $request $request
     *
     * @return array|WP_Error
     */
    public function getItemBySlug(WP_REST_Request $request)
    {
        $slug = $request->get_param('slug');

        $item = (new Besluit($this->plugin))
            ->query(Besluit::addFilterExpirationDateParameters())
            ->findBySlug($slug);

        if (!$item) {
            return new WP_Error('no_item_found', sprintf("Item with slug '%s' not found", $slug), [
                'status' => 404,
            ]);
        }

        return $item;
    }
}
