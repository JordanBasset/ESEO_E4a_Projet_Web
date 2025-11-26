<?php

namespace Exceptions;

/**
 * Exception thrown when trying to retrieve a form value that is not set or not valid.
 */
class InvalidFormValueException extends \RuntimeException implements IRenderableException {
	use GenericRenderExceptionTrait;

	private function __construct(string $message) {
		parent::__construct($message);
	}

	/**
	 * Creates a new exception for a missing form value.
	 *
	 * @param string $field The name of the missing field
	 * @return static The new exception instance
	 */
	public static function missing(string $field): static {
		return new static("Missing value for field '$field'");
	}

	/**
	 * Creates a new exception for a form value that is empty.
	 *
	 * @param string $field The name of the empty field
	 * @return static The new exception instance
	 */
	public static function notEmpty(string $field): static {
		return new static("Field '$field' cannot be empty");
	}
}
