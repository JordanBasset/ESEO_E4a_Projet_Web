<?php

namespace Controllers\Router\Route;

use Controllers\Router\Route;
use Controllers\UnitClassController;
use Exceptions\InvalidFormValueException;

/**
 * Route for the "Add Unit Class" page.
 */
final class RouteAddUnitClass extends Route {
	public function __construct(private readonly UnitClassController $controller) {}

	/**
	 * @inheritDoc
	 */
	protected function get(array $params = []): void {
		$this->controller->displayAddUnitClass();
	}

	/**
	 * @inheritDoc
	 */
	protected function post(array $params = []): void {
		try {
			$name = $this->getParameter($params, 'name', false);
			$imageUrl = $this->getParameter($params, 'image_url', false);
		} catch (InvalidFormValueException $e) {
			$this->controller->displayAddUnitClass($e->getMessage());
			return;
		}

		$this->controller->addUnitClass($name, $imageUrl);
	}
}
