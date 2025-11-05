<?php

namespace Controllers\Router\Route;

use Controllers\MainController;
use Controllers\Router\Route;

/**
 * Route for the "Logs" page.
 */
final class RouteLogs extends Route {
	public function __construct(private readonly MainController $controller) {
	}

	/**
	 * @inheritDoc
	 */
	protected function get(array $params = []): void {
		$this->controller->displayLogs();
	}

	/**
	 * @inheritDoc
	 */
	protected function post(array $params = []) {
		throw new \RuntimeException('Method not supported');
	}
}
