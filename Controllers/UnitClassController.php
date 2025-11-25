<?php

namespace Controllers;

use League\Plates\Engine;
use Models\UnitClass;
use Models\UnitClassDAO;

final readonly class UnitClassController {
	public function __construct(private Engine $plates) {}

	public function addUnitClass(string $name, string $imageUrl): void {
		$unitClass = new UnitClass();
		$unitClass->name = $name;
		$unitClass->urlImg = $imageUrl;

		try {
			new UnitClassDAO()->createUnitClass($unitClass);
			$message = 'Successfully created the unit class.';
			new MainController($this->plates)->index($message, 'success');
		} catch (\PDOException) {
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
