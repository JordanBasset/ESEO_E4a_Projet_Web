<?php

namespace Controllers;

use Helpers\Logger;
use League\Plates\Engine;
use Models\UnitClass;
use Models\UnitClassDAO;

final readonly class UnitClassController {
	public function __construct(private Engine $plates, private Logger $logger) {}

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

	public function displayAddUnitClass(?string $errorMessage = null): void {
		$viewData = $errorMessage ? ['error' => $errorMessage] : [];
		echo $this->plates->render('add-element', [
			'editMode' => false,
			'editType' => 'unit-class',
			...$viewData,
		]);
	}
}
