<?php

namespace Controllers;

use Helpers\Logger;
use League\Plates\Engine;
use Models\PersonnageDAO;
use Services\PersonnageService;

/**
 * Controller that handles the main actions of the application (homepage, logs, search).
 */
final readonly class MainController {
	/**
	 * Creates a new instance of the controller.
	 *
	 * @param Engine $plates Templates engine instance
	 * @param Logger $logger Logger instance
	 */
	public function __construct(private Engine $plates, private Logger $logger) {}

	/**
	 * Displays the homepage of the application with a list of the available characters.
	 *
	 * @param ?string $message Optional message text to display on the view
	 * @param ?string $messageType Type for the optional message to display on the view
	 */
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

	/**
	 * Displays the Logs page of the application.
	 *
	 * @param ?string $logFile Optional log file to display contents
	 */
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
}
