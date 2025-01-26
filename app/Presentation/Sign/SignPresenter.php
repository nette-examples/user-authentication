<?php

declare(strict_types=1);

namespace App\Presentation\Sign;

use App\Model\DuplicateNameException;
use App\Model\UserFacade;
use App\Presentation\Accessory\FormFactory;
use Nette;
use Nette\Application\Attributes\Persistent;
use Nette\Application\UI\Form;


/**
 * Presenter for sign-in and sign-up actions.
 */
final class SignPresenter extends Nette\Application\UI\Presenter
{
	/**
	 * Stores the previous page hash to redirect back after successful login.
	 */
	#[Persistent]
	public string $backlink = '';


	// Dependency injection of form factory and user management facade
	public function __construct(
		private UserFacade $userFacade,
		private FormFactory $formFactory,
	) {
	}


	/**
	 * Create a sign-in form with fields for username and password.
	 * On successful submission, the user is redirected to the dashboard or back to the previous page.
	 */
	protected function createComponentSignInForm(): Form
	{
		$form = $this->formFactory->create();
		$form->addText('username', 'Username:')
			->setRequired('Please enter your username.');

		$form->addPassword('password', 'Password:')
			->setRequired('Please enter your password.');

		$form->addSubmit('send', 'Sign in');

		// Handle form submission
		$form->onSuccess[] = function (Form $form, \stdClass $data): void {
			try {
				// Attempt to login user
				$this->getUser()->login($data->username, $data->password);
				$this->restoreRequest($this->backlink);
				$this->redirect('Dashboard:');
			} catch (Nette\Security\AuthenticationException) {
				$form->addError('The username or password you entered is incorrect.');
			}
		};

		return $form;
	}


	/**
	 * Create a sign-up form with fields for username, email, and password.
	 * On successful submission, the user is redirected to the dashboard.
	 */
	protected function createComponentSignUpForm(): Form
	{
		$form = $this->formFactory->create();
		$form->addText('username', 'Pick a username:')
			->setRequired('Please pick a username.');

		$form->addEmail('email', 'Your e-mail:')
			->setRequired('Please enter your e-mail.');

		$form->addPassword('password', 'Create a password:')
			->setOption('description', sprintf('at least %d characters', $this->userFacade::PasswordMinLength))
			->setRequired('Please create a password.')
			->addRule($form::MinLength, null, $this->userFacade::PasswordMinLength);

		$form->addSubmit('send', 'Sign up');

		// Handle form submission
		$form->onSuccess[] = function (Form $form, \stdClass $data): void {
			try {
				// Attempt to register a new user
				$this->userFacade->add($data->username, $data->email, $data->password);
				$this->redirect('Dashboard:');
			} catch (DuplicateNameException) {
				// Handle the case where the username is already taken
				$form['username']->addError('Username is already taken.');
			}
		};

		return $form;
	}


	/**
	 * Logs out the currently authenticated user.
	 */
	public function actionOut(): void
	{
		$this->getUser()->logout();
	}
}
