<?php

declare(strict_types=1);

namespace App\UI\Dashboard;

use App\UI\Accessory\RequireLoggedUser;
use Nette;


/**
 * Presenter for the dashboard view.
 * Ensures the user is logged in before access.
 */
final class DashboardPresenter extends Nette\Application\UI\Presenter
{
	// Incorporates methods to check user login status
	use RequireLoggedUser;
}
