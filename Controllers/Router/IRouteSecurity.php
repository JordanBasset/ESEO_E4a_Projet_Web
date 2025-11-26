<?php

namespace Controllers\Router;

/**
 * Handles route security.
 */
interface IRouteSecurity {
	/**
	 * Checks if the route needs the visitor to be logged in.
	 *
	 * @return bool True if the route is protected, false otherwise
	 */
	public function isRouteProtected(): bool;

	/**
	 * Handles route security when a visitor tries to access it.
	 */
	public function protectRoute(): void;
}
