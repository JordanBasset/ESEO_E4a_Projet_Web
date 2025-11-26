<?php

namespace Controllers\Router\Route;

use Controllers\MainController;
use Controllers\Router\Route;
use Exceptions\MethodNotSupportedException;

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
		$logFile = $this->getParameter($params, 'log_file', false);
		$this->controller->displayLogs($logFile);
	}
}
