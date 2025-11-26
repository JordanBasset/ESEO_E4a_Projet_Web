<?php

namespace Controllers;

use Helpers\Logger;
use League\Plates\Engine;
use Models\UnitClass;
use Models\UnitClassDAO;

/**
 * Controller that handles {@link UnitClass}-related operations.
 */
final readonly class UnitClassController {
	/**
	 * Creates a new instance of the controller.
	 *
	 * @param Engine $plates Templates engine instance
	 * @param Logger $logger Logger instance
	 */
	public function __construct(private Engine $plates, private Logger $logger) {}

	/**
	 * Handles retrieving the "Add Unit Class" form data and
	 * creating the corresponding unit class in the database.
	 *
	 * @param string $name Unit class name
	 * @param string $imageUrl Unit class image URL
	 */
	public function addUnitClass(string $name, string $imageUrl): void {
		$unitClass = new UnitClass();
		$unitClass->name = $name;
		$unitClass->urlImg = $imageUrl;

		try {
			new UnitClassDAO()->createUnitClass($unitClass);

			$this->logger->log(true, 'CREATE', 'UnitClass', 'Created unit class: ' . $name);

			$message = 'Successfully created the unit class.';
			new MainController($this->plates, $this->logger)->index($message, 'success');
		} catch (\PDOException) {
			$this->logger->log(false, 'CREATE', 'UnitClass', 'Failed to create unit class: ' . $name);

			$message = 'Error when trying to create the unit class.';
			$this->displayAddUnitClass($message);
		}
	}

	/**
	 * Displays the "Add Unit Class" page.
	 *
	 * @param ?string $errorMessage An optional error message to display on the page
	 */
	public function displayAddUnitClass(?string $errorMessage = null): void {
		$viewData = $errorMessage ? ['error' => $errorMessage] : [];
		echo $this->plates->render('add-element', [
			'editMode' => false,
			'editType' => 'unit-class',
			...$viewData,
		]);
	}
}
