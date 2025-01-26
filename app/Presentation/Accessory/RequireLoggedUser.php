<?php

declare(strict_types=1);

namespace App\Presentation\Accessory;


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
			$user = $this->getUser();
			// If the user isn't logged in, redirect them to the sign-in page
			if ($user->isLoggedIn()) {
				return;
			} elseif ($user->getLogoutReason() === $user::LogoutInactivity) {
				$this->flashMessage('You have been signed out due to inactivity. Please sign in again.');
				$this->redirect('Sign:in', ['backlink' => $this->storeRequest()]);
			} else {
				$this->redirect('Sign:in');
			}
		};
	}
}
