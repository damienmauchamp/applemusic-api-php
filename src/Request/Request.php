<?php

namespace AppleMusic\Request;

use AppleMusic\Logger\RequestLogger;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;

class Request {

	private $method;
	private $url;
	private $headers;
	private $body;

	private $logger;
	const LOG_FILE = 'request.log';

	public function __construct(
		string $method,
		string $url,
		array  $body = [],
			   $headers = []) {

		$this->method = strtoupper($method);
		$this->url = $url;
		$this->headers = $headers;
		$this->body = $body;

		$this->logger = new RequestLogger();
//		$this->logger = new Logger('Request');
//		$this->logger->pushHandler(new RotatingFileHandler(__DIR__.'/'.self::LOG_FILE, 7, Logger::API));
	}

	private function prepare() {
		$this->logger->info('Preparing request');
		$this->logger->info("Method: {$this->method}");
		$this->logger->info("URL: {$this->url}");
		$this->logger->info('Headers: '.json_encode($this->headers));
		$this->logger->info('Body: '.json_encode($this->body));


//		'GET', $endpoint.($params ? '?'.http_build_query($params) : '')
	}

	public function run() {
		$this->prepare();
		return $this->request();
	}

	private function request(): Response {
		$curl = curl_init();

		if($this->method == 'GET' && $this->body) {
			$this->url .= '?'.(is_array($this->body) ? http_build_query($this->body) : $this->body);
		}

		$this->logger->info('Request: '.$this->method.' '.$this->url);

		$headers = [
			CURLOPT_URL => $this->url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => $this->method,
			CURLOPT_HTTPHEADER => array_merge([
				'Content-Type: application/json'
			], $this->headers),
		];

		if($this->method == 'POST') {
			$headers[CURLOPT_POSTFIELDS] = is_array($this->body) ? json_encode($this->body) : $this->body;
		}
		
		$this->logger->info('Headers: '.json_encode($headers), $headers);
		$this->logger->info('Body: '.json_encode($this->body), is_array($this->body) ? $this->body : []);

		curl_setopt_array($curl, $headers);
		$response = curl_exec($curl);
		$err = curl_error($curl);
		$infos = curl_getinfo($curl);
		curl_close($curl);

		$this->logger->info('Response: '.($infos['http_code'] ?? '---').' ', json_decode($response, true) ?: []);
		if($err) {
			$this->logger->error('Error: '.$err);
		}
		return new Response($response, $infos, $err);
	}

}