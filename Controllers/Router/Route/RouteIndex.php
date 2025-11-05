<?php

namespace Controllers\Router\Route;

use Controllers\MainController;
use Controllers\Router\Route;

/**
 * Route for the homepage.
 */
final class RouteIndex extends Route {
	public function __construct(private readonly MainController $controller) {}

	/**
	 * @inheritDoc
	 */
	protected function get(array $params = []): void {
		$this->controller->index();
	}

	/**
	 * @inheritDoc
	 */
	protected function post(array $params = []): void {
		$this->controller->index();
	}
}
