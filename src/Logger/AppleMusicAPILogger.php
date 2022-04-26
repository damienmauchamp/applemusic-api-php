<?php

namespace AppleMusic\Logger;

use Monolog\Logger;

class AppleMusicAPILogger extends AbstractLogger {

	public function __construct() {
		parent::__construct(
			'Request',
			'applemusic_api.log',
			7,
			Logger::API
		);
	}
}