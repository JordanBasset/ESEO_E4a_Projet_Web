<?php

namespace Services;

use Exceptions\LoginException;
use Models\UserDAO;

/**
 * A service class to handle authentication-related operations.
 */
class AuthService {
	private const int MINUTE_TIME_UNIT = 60;

	/**
	 * Tries to log a user in.
	 *
	 * @param string $username User username
	 * @param string $password User password
	 * @throws LoginException If the user provides invalid credentials
	 */
	public static function login(string $username, string $password): void {
		$userDao = new UserDAO();
		$user = $userDao->getByUsername($username);

		if ($user === null) {
			throw new LoginException('Invalid username or password.');
		}

		if (!password_verify($password, $user->hashPwd)) {
			throw new LoginException('Invalid username or password.');
		}

		$_SESSION['userUID'] = $user->id;
		$_SESSION['timeout'] = time() + 5 * self::MINUTE_TIME_UNIT;
	}
}
