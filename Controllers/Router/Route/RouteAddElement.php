<?php

namespace Controllers\Router\Route;

use Controllers\PersonnageController;
use Controllers\Router\Route;

/**
 * Route for the "Add Element" page.
 */
final class RouteAddElement extends Route {
	public function __construct(private readonly PersonnageController $controller) {}

	/**
	 * @inheritDoc
	 */
	protected function get(array $params = []): void {
		$this->controller->displayAddElement();
	}

	/**
	 * @inheritDoc
	 */
	protected function post(array $params = []): void {
		// TODO: Handle form submit
		$this->controller->displayAddElement();
	}
}
