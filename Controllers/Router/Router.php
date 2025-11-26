<?php

namespace Controllers\Router;

use Controllers\ElementController;
use Controllers\MainController;
use Controllers\OriginController;
use Controllers\PersonnageController;
use Controllers\Router\Route\RouteAddElement;
use Controllers\Router\Route\RouteAddOrigin;
use Controllers\Router\Route\RouteAddPerso;
use Controllers\Router\Route\RouteAddUnitClass;
use Controllers\Router\Route\RouteDeletePerso;
use Controllers\Router\Route\RouteEditPerso;
use Controllers\Router\Route\RouteIndex;
use Controllers\Router\Route\RouteLogs;
use Controllers\Router\Route\RouteSearch;
use Controllers\UnitClassController;
use Exceptions\NotFoundException;
use Helpers\Logger;
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
	 * @param Logger $logger Logger instance
	 * @param string $actionKey Router action key
	 */
	public function __construct(
		private readonly Engine $templates,
		private readonly Logger $logger,
		private readonly string $actionKey = 'action'
	) {
		$this->createControllersList();
		$this->createRoutesList();
	}

	private function createControllersList(): void {
		$this->controllersList = [
			'character' => new PersonnageController($this->templates, $this->logger),
			'element' => new ElementController($this->templates, $this->logger),
			'main' => new MainController($this->templates, $this->logger),
			'origin' => new OriginController($this->templates, $this->logger),
			'unit-class' => new UnitClassController($this->templates, $this->logger),
		];
	}

	private function createRoutesList(): void {
		$this->routesList = [
			'add-character' => new RouteAddPerso($this->controllersList['character']),
			'add-element' => new RouteAddElement($this->controllersList['element']),
			'add-origin' => new RouteAddOrigin($this->controllersList['origin']),
			'add-unit-class' => new RouteAddUnitClass($this->controllersList['unit-class']),
			'delete-character' => new RouteDeletePerso($this->controllersList['character']),
			'edit-character' => new RouteEditPerso($this->controllersList['character']),
			'index' => new RouteIndex($this->controllersList['main']),
			'logs' => new RouteLogs($this->controllersList['main']),
			'search' => new RouteSearch($this->controllersList['main']),
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
			: throw new NotFoundException('Route not found for action: ' . htmlspecialchars($action));
		$method = $_SERVER['REQUEST_METHOD'];
		$params = match ($method) {
			'GET' => $get,
			'POST' => [...$get, ...$post],
		};
		return $route->action($params, $method);
	}
}
