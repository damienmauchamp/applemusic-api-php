<?php

namespace AppleMusic\API\Entity;

use AppleMusic\API\AppleMusicAPI;
use AppleMusic\Request\Response;
use Exception;

class Search extends AbstractEntity {

	/**
	 * @param string|null $storefront
	 * @param array $params
	 * @return Response
	 * @throws Exception
	 * @link https://developer.apple.com/documentation/applemusicapi/search_for_catalog_resources
	 */
	public function getCatalogResources(?string $storefront = null, string $term = '', array $params = []): Response {
//		$this->setMusicKitApi();
		$storefront = $this->fixStoreFront($storefront);

		$params['term'] = $term ?? $params['term'];
		return $this->api->get("catalog/{$storefront}/search", $params);
	}

	/**
	 * @param string $term
	 * @param array $params
	 * @return Response
	 * @throws Exception
	 */
	public function getLibraryResources(string $term = '', array $params = []): Response {
		$this->setMusicKitApi();

		$params['term'] = $term ?? $params['term'];
		return $this->api->get("me/library/search", $params);
	}
}