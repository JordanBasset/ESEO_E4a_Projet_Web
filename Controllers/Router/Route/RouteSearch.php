<?php

namespace Controllers\Router\Route;

use Controllers\MainController;
use Controllers\Router\Route;

/**
 * Route for the "Search" page.
 */
class RouteSearch extends Route {
	public function __construct(private readonly MainController $controller) {
	}

	/**
	 * @inheritDoc
	 */
	protected function get(array $params = []) {
		$this->controller->displaySearch();
	}

	/**
	 * @inheritDoc
	 */
	protected function post(array $params = []) {
		$this->controller->displaySearch();
	}
}
