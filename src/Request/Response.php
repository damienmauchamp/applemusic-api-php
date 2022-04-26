<?php

namespace AppleMusic\Request;

class Response {

	private $response;
	private $infos;
	private $error;

	private $http_code;

	public function __construct($response, $infos, $error) {
		$this->response = $response;
		$this->infos = $infos;
		$this->error = $error;

		$this->http_code = $this->infos['http_code'] ?? null;
	}

	public function getHttpCode() {
		return $this->http_code;
	}

	public function getData(): array {
		return json_decode($this->response, true)['data'] ?? [];
	}

	public function getResponse(): string {
		return $this->response;
	}

	public function getInfos(): array {
		return $this->infos;
	}

	public function getError(): string {
		return $this->error;
	}

}
