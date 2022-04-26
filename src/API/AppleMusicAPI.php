<?php

namespace AppleMusic\API;

use AppleMusic\Logger\AppleMusicAPILogger;
use AppleMusic\Request\Request;
use Dotenv\Dotenv;

class AppleMusicAPI {

	private $url = 'https://api.music.apple.com/v1';
	private $storefront;

	private $developer_token;
	private $music_user_token;

	private $logger;

	/**
	 * @throws \Exception
	 */
	public function __construct(?string $developer_token = null, ?string $music_user_token = null, ?string $storefront = null) {
		$this->loadEnv();
		$this->developer_token = $developer_token ?? $_ENV['APPLE_MUSIC_DEVELOPER_TOKEN'];
		if(!$this->developer_token) {
			throw new \Exception('Developer token is required');
		}
		$this->music_user_token = $music_user_token;
		$this->storefront = $storefront ?? $_ENV['STOREFRONT'] ?: 'us';

		$this->logger = new AppleMusicAPILogger();
	}

	public function getStorefront(): string {
		return $this->storefront;
	}

	public function get(string $endpoint, array $params = []): \AppleMusic\Request\Response {
		return $this->request('GET', $endpoint.($params ? '?'.http_build_query($params) : ''));
	}

	public function post(string $endpoint, array $params = []): \AppleMusic\Request\Response {
		return $this->request('POST', $endpoint, $params);
	}

	public function request(string $method, string $endpoint, array $params = []): \AppleMusic\Request\Response {

		$headers = [];
		if($this->developer_token) {
			$headers[] = "Authorization: Bearer {$this->developer_token}";
		}
		if(strstr($endpoint, '/me/')) {
			$headers[] = "Music-User-Token: {$this->music_user_token}";
		}

		$request = new Request($method,
			"{$this->url}/".preg_replace('/^[\s\/]*/', '', $endpoint),
			$params,
			$headers
		);
		return $request->run();
	}

	/**
	 * Loads environment variables from .env file
	 * @return void
	 */
	private function loadEnv() {
		$dir = dirname(__DIR__, strstr(__DIR__, 'vendor') ? 4 : 2);
		$dotenv = Dotenv::createImmutable($dir);
		$dotenv->load();
	}

}