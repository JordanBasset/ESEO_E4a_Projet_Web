<?php

namespace Controllers\Router\Route;

use Controllers\PersonnageController;
use Controllers\Router\Route;
use Exceptions\InvalidFormValueException;

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
		try {
			$name = $this->getParameter($params, 'name', false);
			$element = $this->getParameter($params, 'element', false);
			$unitClass = $this->getParameter($params, 'unit_class', false);
			$rarity = (int)$this->getParameter($params, 'rarity', false);
			$origin = $this->getParameter($params, 'origin', false);
			$imageUrl = $this->getParameter($params, 'image_url', false);
		} catch (InvalidFormValueException $e) {
			$this->controller->displayAddPersonnage($e->getMessage());
			return;
		}

		$this->controller->addPersonnage($name, $element, $unitClass, $rarity, $origin, $imageUrl);
	}
}
