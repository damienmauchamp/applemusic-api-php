<?php

namespace AppleMusic\API;

use AppleMusic\API\AppleMusicAPI;
use AppleMusic\Request\Response;
use Exception;

class MusicKitAPI extends AppleMusicAPI {

	public function __construct(?string $developer_token = null, ?string $music_user_token = null, ?string $storefront = null) {
		parent::__construct($developer_token, $music_user_token, $storefront);

		$this->music_user_token = $this->music_user_token ?? $_ENV['APPLE_MUSIC_USER_TOKEN'];
		if(!$this->music_user_token) {
			throw new Exception('Developer token is required');
		}
	}

	public function validateMusicUserToken() {
		if(!$this->music_user_token) {
			throw new Exception('Music user token is required');
		}
	}
}