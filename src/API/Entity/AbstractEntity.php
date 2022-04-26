<?php

namespace AppleMusic\API\Entity;

use AppleMusic\API\AppleMusicAPI;
use AppleMusic\API\MusicKitAPI;
use Exception;

class AbstractEntity {

	protected $api;

	/**
	 * @param bool $music_kit
	 * @param string|null $developer_token
	 * @param string|null $music_user_token
	 * @param string|null $storefront
	 * @throws Exception
	 */
	public function __construct(bool $music_kit = false, ?string $developer_token = null, ?string $music_user_token = null, ?string $storefront = null) {
		$this->api = $music_kit ?
			new MusicKitAPI($developer_token, $music_user_token, $storefront) :
			new AppleMusicAPI($developer_token, $music_user_token, $storefront);
	}

	/**
	 * @param string|null $developer_token
	 * @param string|null $music_user_token
	 * @param string|null $storefront
	 * @return AbstractEntity
	 * @throws Exception
	 */
	public static function musicKit(?string $developer_token = null, ?string $music_user_token = null, ?string $storefront = null): AbstractEntity {
		return new self(true, $developer_token, $music_user_token, $storefront);
	}

	/**
	 * @param string|null $developer_token
	 * @param string|null $music_user_token
	 * @param string|null $storefront
	 * @return void
	 * @throws Exception
	 */
	protected function setMusicKitApi(?string $developer_token = null, ?string $music_user_token = null, ?string $storefront = null): void {
		if(get_class($this->api) === MusicKitAPI::class) {
			return;
		}
		$this->api = new MusicKitAPI(
			$developer_token ?? $this->api->getDeveloperToken(),
			$music_user_token ?? $this->api->getMusicUserToken(),
			$storefront ?? $this->api->getStorefront());
	}

	/**
	 * @return void
	 * @throws Exception
	 */
	protected function setAppleMusicApi(?string $developer_token = null, ?string $music_user_token = null, ?string $storefront = null): void {
		if(get_class($this->api) === AppleMusicAPI::class) {
			return;
		}
		$this->api = new AppleMusicAPI(
			$developer_token ?? $this->api->getDeveloperToken(),
			$music_user_token ?? $this->api->getMusicUserToken(),
			$storefront ?? $this->api->getStorefront());
	}

	/**
	 * @param string|null $storefront
	 * @return string
	 */
	protected function fixStoreFront(?string $storefront): string {
		return strtolower($storefront ? $storefront : $this->api->getStoreFront());
	}

	/***********************************/
	/***********************************/

	/**
	 * @return AppleMusicAPI|MusicKitAPI
	 */
	public function getApi(): AppleMusicAPI {
		return $this->api;
	}

	/**
	 * @param string|null $developer_token
	 * @param string|null $music_user_token
	 * @param string|null $storefront
	 * @return MusicKitAPI
	 * @throws Exception
	 */
	public function getMusicKitApi(?string $developer_token = null, ?string $music_user_token = null, ?string $storefront = null): MusicKitAPI {
		$this->setMusicKitApi($developer_token, $music_user_token, $storefront);
		return $this->api;
	}

	/**
	 * @param string|null $developer_token
	 * @param string|null $music_user_token
	 * @param string|null $storefront
	 * @return AppleMusicAPI
	 * @throws Exception
	 */
	public function getAppleMusicApi(?string $developer_token = null, ?string $music_user_token = null, ?string $storefront = null): AppleMusicAPI {
		$this->setAppleMusicApi($developer_token, $music_user_token, $storefront);
		return $this->api;
	}

	public function setApiDeveloperToken(?string $developer_token): void {
		$this->api->setDeveloperToken($developer_token);
	}

	public function setApiMusicUserToken(?string $music_user_token): void {
		$this->api->setMusicUserToken($music_user_token);
	}

	public function setApiStoreFront(?string $storefront): void {
		$this->api->setStoreFront($storefront);
	}

}