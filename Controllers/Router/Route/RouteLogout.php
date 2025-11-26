<?php

namespace Controllers\Router\Route;

use Controllers\AuthController;
use Controllers\Router\Route;
use Exceptions\MethodNotSupportedException;

/**
 * Route for the "Logout" page.
 */
final class RouteLogout extends Route {
	public function __construct(private readonly AuthController $controller) {}

	/**
	 * @inheritDoc
	 */
	protected function get(array $params = []): void {
		$this->controller->doLogOut();
	}

	/**
	 * @inheritDoc
	 */
	protected function post(array $params = []): void {
		throw new MethodNotSupportedException("Method 'POST' is not supported for route: logout");
	}
}
