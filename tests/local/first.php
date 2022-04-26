<?php

require __DIR__.'/../../vendor/autoload.php';

//$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../../');
//$dotenv->load();

//echo '<pre>'.print_r($_ENV, true).'</pre>';

$albums = new \AppleMusic\API\Entity\Albums();
$response = $albums->getCatalogAlbum('1614478361');
echo '<pre>'.print_r([
		'http_code' => $response->getHttpCode(),
		'data' => $response->getData(),
	], true).'</pre>';