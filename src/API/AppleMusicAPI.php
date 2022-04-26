<?php

namespace AppleMusic\API;

use AppleMusic\Logger\AppleMusicAPILogger;
use AppleMusic\Request\Request;
use Dotenv\Dotenv;
use Exception;

class AppleMusicAPI {

	protected $url = 'https://api.music.apple.com/v1';
	protected $storefront;

	protected $developer_token;
	protected $music_user_token;

	protected $logger;

	/**
	 * @throws Exception
	 */
	public function __construct(?string $developer_token = null, ?string $music_user_token = null, ?string $storefront = null) {
		$this->loadEnv();
		$this->developer_token = $developer_token ?? $_ENV['APPLE_MUSIC_DEVELOPER_TOKEN'];
		if(!$this->developer_token) {
			throw new Exception('Developer token is required');
		}
		$this->music_user_token = $music_user_token;
		$this->storefront = $storefront ?? $_ENV['STOREFRONT'] ?: 'us';

		$this->logger = new AppleMusicAPILogger();
	}

	public function getStorefront(): string {
		return $this->storefront;
	}

	public function getDeveloperToken() {
		return $this->developer_token;
	}

	public function getMusicUserToken() {
		return $this->music_user_token;
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

		if($this->isMusicKitAPI() || preg_match('/(^|\/)me\//', $endpoint)) {
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

	public function isMusicKitAPI(): bool {
		return get_class($this) === MusicKitAPI::class;
	}

	public function setDeveloperToken(string $developer_token): void {
		$this->developer_token = $developer_token;

	}

	public function setMusicUserToken(string $music_user_token): void {
		$this->music_user_token = $music_user_token;

	}

	public function setStoreFront(string $storefront): void {
		$this->storefront = $storefront;

	}


}