<?php

namespace Controllers\Router;

use Exceptions\UnauthorizedException;
use Services\AuthService;

/**
 * Class that represents a protected route for our router.
 */
abstract class ProtectedRoute extends Route {
	/**
	 * @inheritDoc
	 */
	#[\Override]
	public function isRouteProtected(): bool {
		return true;
	}

	/**
	 * @inheritDoc
	 */
	#[\Override]
	public function protectRoute(): void {
		if (!AuthService::checkLogin()) {
			throw new UnauthorizedException('You must be logged in to access this page.');
		}
	}
}
