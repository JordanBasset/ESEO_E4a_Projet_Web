<?php

namespace Exceptions;

/**
 * Exception thrown when accessing a route with a method that is not supported.
 */
class MethodNotSupportedException extends \RuntimeException implements IRenderableException {
	use GenericRenderExceptionTrait;
}
