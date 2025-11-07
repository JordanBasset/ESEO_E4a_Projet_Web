<?php

namespace Exceptions;

use League\Plates\Engine;


/**
 * Renders a generic error page.
 */
trait GenericRenderExceptionTrait {
	/**
	 * @inheritDoc
	 */
	public function render(Engine $templates): void {
		/** @var $this \RuntimeException&IRenderableException */
		echo $templates->render('errors/generic', [
			'details' => $this->getMessage(),
			'trace' => $this->getTraceAsString(),
		]);
	}
}
