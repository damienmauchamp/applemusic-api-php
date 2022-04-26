<?php

namespace AppleMusic\API\Entity;

use AppleMusic\Request\Response;

class Albums extends AbstractEntity {

	/**
	 * Get a Catalog Album
	 * @param string $id
	 * @param string|null $storefront
	 * @param array $params
	 * @return Response
	 * @link https://developer.apple.com/documentation/applemusicapi/get_a_catalog_album
	 */
	public function getCatalogAlbum(string $id, ?string $storefront = null, array $params = []): Response {
		$storefront = $this->fixStoreFront($storefront);
		return $this->api->get("catalog/{$storefront}/albums/{$id}", $params);
	}
}