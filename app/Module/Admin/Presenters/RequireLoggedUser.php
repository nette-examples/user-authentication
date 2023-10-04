<?php

declare(strict_types=1);

namespace App\Module\Admin\Presenters;


/**
 * Trait to enforce user authentication.
 * Redirects unauthenticated users to the sign-in page.
 */
trait RequireLoggedUser
{
	/**
	 * Injects the requirement for a logged-in user.
	 * Attaches a callback to the startup event of the presenter.
	 */
	public function injectRequireLoggedUser(): void
	{
		$this->onStartup[] = function () {
			// If the user isn't logged in, redirect them to the sign-in page
			if (!$this->getUser()->isLoggedIn()) {
				$this->redirect('Sign:in', ['backlink' => $this->storeRequest()]);
			}
		};
	}
}
