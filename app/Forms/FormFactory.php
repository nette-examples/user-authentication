<?php

declare(strict_types=1);

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;


final class FormFactory
{
	use Nette\SmartObject;

	private Nette\Security\User $user;


	public function __construct(Nette\Security\User $user)
	{
		$this->user = $user;
	}


	public function create(): Form
	{
		$form = new Form;
		if ($this->user->isLoggedIn()) {
			$form->addProtection();
		}
		return $form;
	}
}
