<?php

namespace Exceptions;

use League\Plates\Engine;

/**
 * Interface to mark an exception as renderable.
 */
interface IRenderableException {
	/**
	 * Renders the exception.
	 *
	 * @param Engine $templates Templates engine
	 */
	public function render(Engine $templates): void;
}
