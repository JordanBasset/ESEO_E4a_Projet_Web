<?php

namespace Controllers\Router;

use Controllers\MainController;
use Controllers\PersonnageController;
use Controllers\Router\Route\RouteAddElement;
use Controllers\Router\Route\RouteAddPerso;
use Controllers\Router\Route\RouteIndex;
use Controllers\Router\Route\RouteLogs;
use League\Plates\Engine;

/**
 * Class that handles routing requests to the appropriate route (then controller).
 */
final class Router {
	/** @var array<string, Route> $routesList List of {@link Route routes} mapped by action value */
	private array $routesList;

	/** @var array<string,mixed> $controllersList List of controllers mapped by keys */
	private array $controllersList;

	/**
	 * Creates a new router instance.
	 *
	 * @param Engine $templates Template engine
	 * @param string $actionKey Router action key
	 */
	public function __construct(
		private readonly Engine $templates,
		private readonly string $actionKey = 'action'
	) {
		$this->createControllersList();
		$this->createRoutesList();
	}

	private function createControllersList(): void {
		$this->controllersList = [
			'add-character' => new PersonnageController($this->templates),
			'add-element' => new PersonnageController($this->templates),
			'logs' => new MainController($this->templates),
			'main' => new MainController($this->templates),
		];
	}

	private function createRoutesList(): void {
		$this->routesList = [
			'add-character' => new RouteAddPerso($this->controllersList['add-character']),
			'add-element' => new RouteAddElement($this->controllersList['add-element']),
			'index' => new RouteIndex($this->controllersList['main']),
			'logs' => new RouteLogs($this->controllersList['logs']),
		];
	}

	/**
	 * Handles routing requests to the appropriate route (then controller).
	 *
	 * @param array $get List of {@link $_GET GET} parameters
	 * @param array $post List of {@link $_POST POST} parameters
	 */
	public function routing(array $get, array $post) {
		$action = array_key_exists($this->actionKey, $get) ? $get[$this->actionKey] : 'index';
		$route = array_key_exists($action, $this->routesList)
			? $this->routesList[$action]
			: throw new \RuntimeException('Route not found');
		$method = $_SERVER['REQUEST_METHOD'];
		$params = match ($method) {
			'GET' => $get,
			'POST' => [...$get, ...$post],
		};
		return $route->action($params, $method);
	}
}
