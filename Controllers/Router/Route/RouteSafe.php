<?php

namespace Controllers\Router\Route;

use Controllers\MainController;
use Controllers\Router\ProtectedRoute;
use Exceptions\MethodNotSupportedException;

/**
 * Route for the "Protected" page.
 */
class RouteSafe extends ProtectedRoute {
	public function __construct(private readonly MainController $controller) {}

	/**
	 * @inheritDoc
	 */
	#[\Override]
	protected function get(array $params = []): void {
		$this->controller->displayProtected();
	}

	/**
	 * @inheritDoc
	 */
	#[\Override]
	protected function post(array $params = []): void {
		throw new MethodNotSupportedException("Method 'POST' is not supported for route: protected");
	}
}
