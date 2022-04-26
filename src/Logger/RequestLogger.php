<?php

namespace AppleMusic\Logger;

use Monolog\Logger;

class RequestLogger extends AbstractLogger {

	public function __construct() {
		parent::__construct(
			'Request',
			'request.log',
			7,
			Logger::API
		);
	}

}