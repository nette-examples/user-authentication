<?php

declare(strict_types=1);

// Load the Composer autoloader
if (@!include __DIR__ . '/../vendor/autoload.php') {
	die('Install Nette using `composer update`');
}

// Initialize the application environment
$bootstrap = new App\Bootstrap;

// Create the Dependency Injection container
$container = $bootstrap->bootWebApplication();

// Start the application and handle the incoming request
$application = $container->getByType(Nette\Application\Application::class);
$application->run();
