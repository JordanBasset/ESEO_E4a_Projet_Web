<?php

namespace Controllers\Router\Route;

use Controllers\PersonnageController;
use Controllers\Router\Route;

/**
 * Route for the "Add Character" page.
 */
final class RouteAddPerso extends Route {
	public function __construct(private readonly PersonnageController $controller) {}

	/**
	 * @inheritDoc
	 */
	protected function get(array $params = []): void {
		$this->controller->displayAddPersonnage();
	}

	/**
	 * @inheritDoc
	 */
	protected function post(array $params = []): void {
		// TODO: Handle form submit
		$this->controller->displayAddPersonnage();
	}
}
