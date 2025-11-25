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
		try {
			$id = $this->getParameter($params, 'id', false);
			$name = $this->getParameter($params, 'name', false);
			$element = (int)$this->getParameter($params, 'element', false);
			$unitClass = (int)$this->getParameter($params, 'unit_class', false);
			$rarity = (int)$this->getParameter($params, 'rarity', false);
			$origin = (int)$this->getParameter($params, 'origin', false);
			$imageUrl = $this->getParameter($params, 'image_url', false);
		} catch (InvalidFormValueException $e) {
			$this->controller->displayAddPersonnage($e->getMessage());
			return;
		}

		$this->controller->editPersonnage($id, $name, $element, $unitClass, $rarity, $origin, $imageUrl);
	}
}
