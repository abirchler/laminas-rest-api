<?php

namespace RestApi;

use Laminas\Mvc\MvcEvent;
use Laminas\Http\Header;
use Laminas\Http\Headers;

class Module
{

    const VERSION = '3.0.3-dev';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    /**
     *
     * @param \Laminas\Mvc\MvcEvent $e
     */
    public function onBootstrap(MvcEvent $e)
    {

			$response = $e->getResponse();

			if ( ! $response instanceof \Laminas\Console\Response)
			{
				$headers = $response->getHeaders();

				// Allow from any origin
				if (isset($_SERVER['HTTP_ORIGIN'])) {

					$headers->addHeaderLine("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
					$headers->addHeaderLine('Access-Control-Allow-Credentials: true');
					$headers->addHeaderLine('Access-Control-Max-Age: 86400'); // cache for 1 day
				}

				// Access-Control headers are received during OPTIONS requests
				if ($_SERVER['REQUEST_METHOD'] ?? '' == 'OPTIONS') {

					if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
						$headers->addHeaderLine("Access-Control-Allow-Methods: GET, POST, OPTIONS");
					}

					if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
						$headers->addHeaderLine("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
					}
					return $response;
				}
			}
    }

}

