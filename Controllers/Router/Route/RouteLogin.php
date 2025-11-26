<?php

namespace Controllers\Router\Route;

use Controllers\AuthController;
use Controllers\Router\Route;
use Exceptions\InvalidFormValueException;

/**
 * Route for the "Login" page.
 */
final class RouteLogin extends Route {
	public function __construct(private readonly AuthController $controller) {}

	/**
	 * @inheritDoc
	 */
	protected function get(array $params = []): void {
		$this->controller->displayLoginForm();
	}

	/**
	 * @inheritDoc
	 */
	protected function post(array $params = []): void {
		try {
			$username = $this->getParameter($params, 'username', false);
			$password = $this->getParameter($params, 'password', false);
		} catch (InvalidFormValueException $e) {
			$this->controller->displayLoginForm($e->getMessage());
			return;
		}

		$this->controller->doLogin($username, $password);
	}
}
