<?php

declare(strict_types=1);

namespace App\Module\Admin\Presenters;

use App\Forms;
use Nette;
use Nette\Application\Attributes\Persistent;
use Nette\Application\UI\Form;


final class SignPresenter extends Nette\Application\UI\Presenter
{
	#[Persistent]
	public string $backlink = '';


	public function __construct(
		private Forms\SignInFormFactory $signInFactory,
		private Forms\SignUpFormFactory $signUpFactory,
	) {
	}


	/**
	 * Sign-in form factory.
	 */
	protected function createComponentSignInForm(): Form
	{
		return $this->signInFactory->create(function (): void {
			$this->restoreRequest($this->backlink);
			$this->redirect('Dashboard:');
		});
	}


	/**
	 * Sign-up form factory.
	 */
	protected function createComponentSignUpForm(): Form
	{
		return $this->signUpFactory->create(function (): void {
			$this->redirect('Dashboard:');
		});
	}


	public function actionOut(): void
	{
		$this->getUser()->logout();
	}
}
