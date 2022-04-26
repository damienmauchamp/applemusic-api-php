<?php

namespace Tests\AppleMusicAPI\API\Entity;

use AppleMusic\API\Entity\Albums;
use PHPUnit\Framework\TestCase;

class AlbumsTest extends TestCase {

	/**
	 * @var Albums
	 */
	private $albums;

	private function init() {
		$this->albums = new Albums();
	}

	private function getCatalogAlbumHttpCode(string $id) {
		$this->init();
		$response = $this->albums->getCatalogAlbum($id);
		return $response->getHttpCode();
	}

	public function testGetCatalogAlbumFound(): void {
		$result = $this->getCatalogAlbumHttpCode('1614478361');
		$this->assertEquals(200, $result);
		echo "getCatalogAlbum 200: {$result}\n";
	}

	public function testGetCatalogAlbumNotFound(): void {
		$result = $this->getCatalogAlbumHttpCode('123456789');
		$this->assertEquals(404, $result);
		echo "getCatalogAlbum 404: {$result}\n";
	}

}