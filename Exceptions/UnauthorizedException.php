<?php

namespace Exceptions;

use Controllers\Router\ProtectedRoute;

/**
 * Exception thrown when the visitor tries to access a {@link ProtectedRoute} without being logged in.
 */
class UnauthorizedException extends \RuntimeException {}
