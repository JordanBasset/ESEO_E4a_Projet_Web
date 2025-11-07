<?php

namespace Controllers\Router;

use Exceptions\MethodNotSupportedException;

/**
 * Base class that represents a route for our router.
 */
abstract class Route {
	/**
	 * Handles the request for this route by redirecting data to the appropriate method.
	 *
	 * @param array $params Request parameters
	 * @param string $method Request method (GET or POST)
	 */
	final public function action(array $params = [], string $method = 'GET') {
		return match (mb_strtoupper($method)) {
			'GET' => $this->get($params),
			'POST' => $this->post($params),
			default => throw new MethodNotSupportedException('Method not supported: ' . $method),
		};
	}

	/**
	 * Handles a GET request for this route.
	 *
	 * @param array $params Request parameters
	 */
	abstract protected function get(array $params = []);

	/**
	 * Handles a POST request for this route.
	 *
	 * @param array $params Request parameters
	 */
	abstract protected function post(array $params = []);

	/**
	 * Retrieves a parameter from the request parameters.
	 *
	 * @param array $params Request parameters
	 * @param string $name Parameter name
	 * @param bool $canBeEmpty If the parameter can accept an empty value
	 * @return mixed Request parameter value
	 * @throws \RuntimeException If the parameter is not found, or empty and $canBeEmpty is false
	 */
	protected function getParameter(array $params, string $name, bool $canBeEmpty = true): mixed {
		if (array_key_exists($name, $params)) {
			if (!$canBeEmpty && empty($params[$name])) {
				throw new \RuntimeException('Parameter is empty');
			}

			return $params[$name];
		}

		throw new \RuntimeException('Parameter not found');
	}
}
