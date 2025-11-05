<?php

namespace Controllers\Router;

use Controllers\MainController;
use Controllers\Router\Route\RouteIndex;
use League\Plates\Engine;

/**
 * Class that handles routing requests to the appropriate route (then controller).
 */
final class Router {
	/** @var array<string, Route> $routesList List of {@link Route routes} mapped by action value */
	private array $routesList;

	/** @var array<string,mixed> $controllersList List of controllers mapped by keys */
	private array $controllersList;

	public function __construct(
		private readonly Engine $templates,
		private readonly string $actionKey = 'action'
	) {
		$this->createControllersList();
		$this->createRoutesList();
	}

	private function createControllersList(): void {
		$this->controllersList = [
			'main' => new MainController($this->templates),
		];
	}

	private function createRoutesList(): void {
		$this->routesList = [
			'index' => new RouteIndex($this->controllersList['main']),
		];
	}

	public function routing(array $get, array $post) {
		$action = array_key_exists($this->actionKey, $get) ? $get[$this->actionKey] : 'index';
		$route = $this->routesList[$action] ?: throw new \RuntimeException('Route not found');
		$method = $_SERVER['REQUEST_METHOD'];
		$params = match ($method) {
			'GET' => $get,
			'POST' => [...$get, ...$post],
		};
		return $route->action($params, $method);
	}
}
