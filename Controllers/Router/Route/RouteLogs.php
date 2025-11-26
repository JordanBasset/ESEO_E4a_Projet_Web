<?php

namespace Controllers\Router\Route;

use Controllers\MainController;
use Controllers\Router\Route;
use Exceptions\InvalidFormValueException;

/**
 * Route for the "Logs" page.
 */
final class RouteLogs extends Route {
	public function __construct(private readonly MainController $controller) {}

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
		try {
			$logFile = $this->getParameter($params, 'log_file', false);
		} catch (InvalidFormValueException $e) {
			$this->controller->displayLogs(errorMessage: $e->getMessage());
			return;
		}

		$this->controller->displayLogs($logFile);
	}
}
