<?php

namespace Controllers\Router\Route;

use Controllers\PersonnageController;
use Controllers\Router\Route;
use Exceptions\InvalidFormValueException;

class RouteEditPerso extends Route {
	public function __construct(private readonly PersonnageController $controller) {}

	/**
	 * @inheritDoc
	 */
	protected function get(array $params = []) {
		try {
			$characterId = $this->getParameter($params, 'characterId', false);
		} catch (InvalidFormValueException $e) {
			$this->controller->displayAddPersonnage($e->getMessage());
			return;
		}

		$this->controller->displayEditPersonnage($characterId);
	}

	/**
	 * @inheritDoc
	 */
	protected function post(array $params = []) {
		// TODO: Implement post() method.
	}
}
