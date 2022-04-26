<?php

namespace Tests\AppleMusicAPI\API\Entity;

use AppleMusic\API\Entity\Search;
use PHPUnit\Framework\TestCase;

class SearchTest extends TestCase {

	/**
	 * @var Search
	 */
	private $search;

	private function init() {
		$this->search = new Search();
	}

	public function testGetCatalogResourcesFound(): void {
		$this->init();
		$response = $this->search->getCatalogResources('fr', 'kendrick lamar', []);
		$result = $response->getHttpCode();
		$this->assertEquals(200, $result);
		echo "getCatalogResources 200: {$result}\n";
	}

	public function testGetLibraryResourcesFound(): void {
		$this->init();
		$response = $this->search->getLibraryResources('kendrick lamar', ['l' => 'fr']);
		$result = $response->getHttpCode();
		$this->assertEquals(200, $result);
		echo "getCatalogResources 200: {$result}\n";
	}
}