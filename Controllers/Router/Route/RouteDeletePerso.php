<?php

namespace Controllers\Router\Route;

use Controllers\PersonnageController;
use Controllers\Router\Route;
use Exceptions\MethodNotSupportedException;

class RouteDeletePerso extends Route {
	public function __construct(private readonly PersonnageController $controller) {}

	/**
	 * @inheritDoc
	 */
	protected function get(array $params = []) {
		$id = $this->getParameter($params, 'characterId', false);
		$this->controller->deletePersonnageAndIndex($id);
	}

	/**
	 * @inheritDoc
	 */
	protected function post(array $params = []): never {
		throw new MethodNotSupportedException("Method 'POST' is not supported for route: delete-character");
	}
}
