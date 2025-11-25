<?php

namespace Controllers\Router\Route;

use Controllers\OriginController;
use Controllers\Router\Route;
use Exceptions\InvalidFormValueException;

/**
 * Route for the "Add Origin" page.
 */
final class RouteAddOrigin extends Route {
	public function __construct(private readonly OriginController $controller) {}

	/**
	 * @inheritDoc
	 */
	protected function get(array $params = []): void {
		$this->controller->displayAddOrigin();
	}

	/**
	 * @inheritDoc
	 */
	protected function post(array $params = []): void {
		try {
			$name = $this->getParameter($params, 'name', false);
			$imageUrl = $this->getParameter($params, 'image_url', false);
		} catch (InvalidFormValueException $e) {
			$this->controller->displayAddOrigin($e->getMessage());
			return;
		}

		$this->controller->addOrigin($name, $imageUrl);
	}
}
