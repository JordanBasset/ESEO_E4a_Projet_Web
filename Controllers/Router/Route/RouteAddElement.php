<?php

namespace Controllers\Router\Route;

use Controllers\ElementController;
use Controllers\Router\Route;
use Exceptions\InvalidFormValueException;

/**
 * Route for the "Add Element" page.
 */
final class RouteAddElement extends Route {
	public function __construct(private readonly ElementController $controller) {}

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
		try {
			$name = $this->getParameter($params, 'name', false);
			$imageUrl = $this->getParameter($params, 'image_url', false);
		} catch (InvalidFormValueException $e) {
			$this->controller->displayAddElement($e->getMessage());
			return;
		}

		$this->controller->addElement($name, $imageUrl);
	}
}
