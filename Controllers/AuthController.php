<?php

namespace Controllers;

use Exceptions\LoginException;
use League\Plates\Engine;
use Services\AuthService;

/**
 * Controller that handles authentication-related operations.
 */
class AuthController {
	/**
	 * Creates a new instance of the controller.
	 *
	 * @param Engine $plates Templates engine instance
	 */
	public function __construct(private Engine $plates) {}

	/**
	 * Displays the login page with the form.
	 *
	 * @param string|null $errorMessage Optional error message to display on the page
	 */
	public function displayLoginForm(?string $errorMessage = null): void {
		$viewData = $errorMessage ? ['error' => $errorMessage] : [];
		echo $this->plates->render('login', $viewData);
	}

	/**
	 * Handles the login form submission.
	 *
	 * @param string $username User username
	 * @param string $password User password
	 */
	public function doLogin(string $username, string $password): void {
		try {
			AuthService::login($username, $password);
		} catch (LoginException $e) {
			$this->displayLoginForm($e->getMessage());
			return;
		}

		header('Location: /');
		exit;
	}

	/**
	 * Handles logging out the user.
	 */
	public function doLogOut(): void {
		unset($_SESSION['userUID'], $_SESSION['timeout']);
		session_destroy();

		header('Location: /');
		exit;
	}
}
