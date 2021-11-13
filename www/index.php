<?php

declare(strict_types=1);

if (@!include __DIR__ . '/../vendor/autoload.php') {
	die('Install Nette using `composer update`');
}

$configurator = App\Bootstrap::boot();
$container = $configurator->createContainer();
$application = $container->getByType(Nette\Application\Application::class);
$application->run();
