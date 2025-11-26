<?php

namespace Controllers;

use Helpers\Logger;
use League\Plates\Engine;
use Models\Origin;
use Models\OriginDAO;

/**
 * Controller that handles {@link Origin}-related operations.
 */
final readonly class OriginController {
	/**
	 * Creates a new instance of the controller.
	 *
	 * @param Engine $plates Templates engine instance
	 * @param Logger $logger Logger instance
	 */
	public function __construct(private Engine $plates, private Logger $logger) {}

	/**
	 * Handles retrieving the "Add Origin" form data and
	 * creating the corresponding origin in the database.
	 *
	 * @param string $name Origin name
	 * @param string $imageUrl Origin image URL
	 */
	public function addOrigin(string $name, string $imageUrl): void {
		$origin = new Origin();
		$origin->name = $name;
		$origin->urlImg = $imageUrl;

		try {
			new OriginDAO()->createOrigin($origin);

			$this->logger->log(true, 'CREATE', 'Origin', 'Created origin: ' . $name);

			$message = 'Successfully created the origin.';
			new MainController($this->plates, $this->logger)->index($message, 'success');
		} catch (\PDOException) {
			$this->logger->log(false, 'CREATE', 'Origin', 'Failed to create origin: ' . $name);

			$message = 'Error when trying to create the origin.';
			$this->displayAddOrigin($message);
		}
	}

	/**
	 * Displays the "Add Origin" page.
	 *
	 * @param ?string $errorMessage An optional error message to display on the page
	 */
	public function displayAddOrigin(?string $errorMessage = null): void {
		$viewData = $errorMessage ? ['error' => $errorMessage] : [];
		echo $this->plates->render('add-element', [
			'editMode' => false,
			'editType' => 'origin',
			...$viewData,
		]);
	}
}
