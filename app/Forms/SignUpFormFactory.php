<?php

declare(strict_types=1);

namespace App\Forms;

use App\Model;
use Nette\Application\UI\Form;


/**
 * Factory for creating user sign-up forms with registration logic.
 */
final class SignUpFormFactory
{
	// Dependency injection of form factory and user management facade
	public function __construct(
		private FormFactory $factory,
		private Model\UserFacade $userFacade,
	) {
	}


	/**
	 * Create a sign-up form with fields for username, email, and password.
	 * Contains logic to handle successful form submissions.
	 */
	public function create(callable $onSuccess): Form
	{
		$form = $this->factory->create();
		$form->addText('username', 'Pick a username:')
			->setRequired('Please pick a username.');

		$form->addEmail('email', 'Your e-mail:')
			->setRequired('Please enter your e-mail.');

		$form->addPassword('password', 'Create a password:')
			->setOption('description', sprintf('at least %d characters', $this->userFacade::PasswordMinLength))
			->setRequired('Please create a password.')
			->addRule($form::MIN_LENGTH, null, $this->userFacade::PasswordMinLength);

		$form->addSubmit('send', 'Sign up');

		// Handle form submission
		$form->onSuccess[] = function (Form $form, \stdClass $data) use ($onSuccess): void {
			try {
				// Attempt to register a new user
				$this->userFacade->add($data->username, $data->email, $data->password);
			} catch (Model\DuplicateNameException $e) {
				// Handle the case where the username is already taken
				$form['username']->addError('Username is already taken.');
				return;
			}
			$onSuccess();
		};

		return $form;
	}
}
