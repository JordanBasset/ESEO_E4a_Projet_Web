<?php

namespace Exceptions;

class NotFoundException extends \RuntimeException implements IRenderableException {
	use GenericRenderExceptionTrait;
}
