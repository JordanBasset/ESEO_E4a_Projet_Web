<?php

namespace Exceptions;

/**
 * Exception thrown when accessing a route that does not exist.
 */
class NotFoundException extends \RuntimeException implements IRenderableException {
	use GenericRenderExceptionTrait;
}
