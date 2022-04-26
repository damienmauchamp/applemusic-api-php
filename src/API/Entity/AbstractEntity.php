<?php

namespace AppleMusic\API\Entity;

use AppleMusic\API\AppleMusicAPI;

class AbstractEntity {

	protected $api;

	public function __construct() {
		$this->api = new AppleMusicAPI();
	}

	protected function fixStoreFront(?string $storefront): string {
		return strtolower($storefront ? $storefront : $this->api->getStoreFront());
	}

}