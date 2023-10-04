<?php

declare(strict_types=1);

namespace App\Module\Auxiliary\Presenters;

use Nette;


/**
 * Handles 4xx HTTP error responses, such as 403 Forbidden or 404 Not Found.
 */
final class Error4xxPresenter extends Nette\Application\UI\Presenter
{
	/**
	 * Ensures the request is a forward (internal redirect).
	 */
	public function startup(): void
	{
		parent::startup();
		if (!$this->getRequest()->isMethod(Nette\Application\Request::FORWARD)) {
			$this->error();
		}
	}


	/**
	 * Renders the appropriate error template based on the HTTP status code.
	 */
	public function renderDefault(Nette\Application\BadRequestException $exception): void
	{
		$file = __DIR__ . "/templates/Error/{$exception->getCode()}.latte";
		$this->template->setFile(is_file($file) ? $file : __DIR__ . '/templates/Error/4xx.latte');
	}
}
