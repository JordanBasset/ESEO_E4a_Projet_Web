<?php

namespace Exceptions;

class InvalidFormValueException extends \RuntimeException implements IRenderableException {
	use GenericRenderExceptionTrait;

	private function __construct(string $message) {
		parent::__construct($message);
	}

	public static function missing(string $field): static {
		return new static("Missing value for field '$field'");
	}

	public static function notEmpty(string $field): static {
		return new static("Field '$field' cannot be empty");
	}
}
