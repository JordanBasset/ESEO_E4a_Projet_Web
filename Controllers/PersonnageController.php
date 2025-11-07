<?php

namespace Controllers;

use League\Plates\Engine;
use Models\Personnage;
use Models\PersonnageDAO;

final readonly class PersonnageController {
	public function __construct(private Engine $plates) {}

	public function displayAddElement(): void {
		echo $this->plates->render('add-element');
	}

	public function addPersonnage(string $name, string $element, string $unitClass, int $rarity, string $origin, string $imageUrl): void {
		$id = uniqid(more_entropy: true);
		$personnage = Personnage::fromRequestParams($id, $name, $element, $unitClass, $rarity, $origin, $imageUrl);
		try {
			new PersonnageDAO()->createPersonnage($personnage);
			$message = 'Successfully created the character.';
			new MainController($this->plates)->index($message);
		} catch (\PDOException) {
			$message = 'Error when trying to create the character.';
			$this->displayAddPersonnage($message);
		}
	}

	public function displayAddPersonnage(?string $errorMessage = null): void {
		$viewData = $errorMessage ? ['error' => $errorMessage] : [];
		echo $this->plates->render('add-perso', $viewData);
	}
}
