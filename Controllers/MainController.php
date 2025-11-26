<?php

namespace Controllers;

use Helpers\Logger;
use League\Plates\Engine;
use Models\PersonnageDAO;
use Services\PersonnageService;

final readonly class MainController {
	public function __construct(private Engine $plates, private Logger $logger) {}

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

	public function displayLogs(?string $logFile = null): void {
		$logFiles = $this->logger->getLogFiles();
		$logData = null;
		$message = null;

		if ($logFile !== null) {
			if (!in_array($logFile, $logFiles, true)) {
				$message = [
					'type' => 'danger',
					'message' => 'Cannot find the specified log file.',
				];
			} else {
				$logData = $this->logger->getLogFileContent($logFile);
			}
		}

		echo $this->plates->render('logs', [
			'logData' => $logData,
			'logFiles' => $logFiles,
			'logFile' => $logFile,
			'message' => $message,
		]);
	}

	public function displaySearch(): void {
		echo $this->plates->render('search');
	}
}
