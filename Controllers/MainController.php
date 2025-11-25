<?php

namespace Controllers;

use League\Plates\Engine;
use Models\PersonnageDAO;
use Services\PersonnageService;

final readonly class MainController {
	public function __construct(private Engine $plates) {}

	public function index(?string $message = null, ?string $messageType = null): void {
		// Test of the newly created DAO class
		$service = new PersonnageService(new PersonnageDAO());
		$characters = $service->getAll();
		$firstCharacter = $service->getByID('690a21938f4e03.77345231');
		$nullCharacter = $service->getByID('690a21938f4e04.77345232');

		$alertData = $message && $messageType ? ['message' => $message, 'type' => $messageType] : [];

		echo $this->plates->render('home', [
			'gameName' => 'Genshin Impact',
			'alert' => $alertData,
			// Inject the test variables into the template
			'characters' => $characters,
			'firstCharacter' => $firstCharacter,
			'nullCharacter' => $nullCharacter,
		]);
	}

	public function displayLogs(): void {
		echo $this->plates->render('logs');
	}

	public function displaySearch(): void {
		echo $this->plates->render('search');
	}
}
