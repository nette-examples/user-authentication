<?php

declare(strict_types=1);

namespace App\UI\Accessory;

use Nette;
use Nette\Application\UI\Form;


/**
 * Factory for creating general forms with optional CSRF protection.
 */
final class FormFactory
{
	// Dependency injection of the current user session
	public function __construct(
		private Nette\Security\User $user,
	) {
	}


	/**
	 * Create a new form instance. If user is logged in, add CSRF protection.
	 */
	public function create(): Form
	{
		$form = new Form;
		if ($this->user->isLoggedIn()) {
			$form->addProtection();
		}
		return $form;
	}
}
