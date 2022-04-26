<?php

namespace AppleMusic\Logger;

use Dotenv\Dotenv;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;

class AbstractLogger {

	protected $logger;

	public function __construct(string $name, string $log_file, int $max_files = 7, int $level = Logger::DEBUG) {
		$this->loadEnv();
		$log_dir = $_ENV['LOG_DIR'] ?? 'logs';
		$this->logger = new Logger($name);
		$this->logger->pushHandler(new RotatingFileHandler(
			$this->getDirectory()."/{$log_dir}/{$log_file}",
			$max_files,
			$level));
	}

	public function getDirectory(): string {
		if(strstr(__DIR__, 'vendor')) {
			return dirname(__DIR__, 4);
		}
		return dirname(__DIR__, 2);
	}

	public function info(string $message, array $context = []) {
		$this->logger->info($message, $context);
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