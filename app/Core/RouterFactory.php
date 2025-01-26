<?php

declare(strict_types=1);

namespace App\Core;

use Nette;
use Nette\Application\Routers\RouteList;


final class RouterFactory
{
	use Nette\StaticClass;

	/**
	 * Creates the main application router with defined routes.
	 */
	public static function createRouter(): RouteList
	{
		$router = new RouteList;
		// Default route that maps to the Dashboard
		$router->addRoute('<presenter>/<action>', 'Dashboard:default');
		return $router;
	}
}
