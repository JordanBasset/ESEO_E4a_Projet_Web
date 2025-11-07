<?php

namespace Exceptions;

class MethodNotSupportedException extends \RuntimeException implements IRenderableException {
	use GenericRenderExceptionTrait;
}
