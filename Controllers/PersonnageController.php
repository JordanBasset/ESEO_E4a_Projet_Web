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
			new MainController($this->plates)->index($message, 'success');
		} catch (\PDOException) {
			$message = 'Error when trying to create the character.';
			$this->displayAddPersonnage($message);
		}
	}

	public function deletePersonnageAndIndex(?string $id): void {
		if (!$id) {
			$message = 'Character ID is missing.';
			new MainController($this->plates)->index($message, 'danger');
			return;
		}

		try {
			new PersonnageDAO()->deletePersonnage($id);
			$message = 'Successfully deleted the character.';
			$messageType = 'success';
		} catch (\PDOException) {
			$message = 'Error when trying to delete the character.';
			$messageType = 'danger';
		} finally {
			new MainController($this->plates)->index($message, $messageType);
		}
	}

	public function displayAddPersonnage(?string $errorMessage = null): void {
		$viewData = $errorMessage ? ['error' => $errorMessage] : [];
		echo $this->plates->render('add-perso', [
			'editMode' => false,
			...$viewData,
		]);
	}

	public function displayEditPersonnage(string $id, ?string $errorMessage = null): void {
		$personnage = null;
		$message = null;
		try {
			$personnage = new PersonnageDAO()->getByID($id);
		} catch (\PDOException) {
			$message = 'Error when trying to fetch the character.';
		}

		if ($message === null && $personnage === null) {
			$message = 'Character not found.';
		}
		if ($message !== null) {
			$this->displayAddPersonnage($message);
			return;
		}

		$viewData = $errorMessage !== null ? ['error' => $errorMessage] : [];
		echo $this->plates->render('add-perso', [
			'editMode' => true,
			'personnage' => $personnage,
			...$viewData,
		]);
	}

	public function editPersonnage(string $id, string $name, string $element, string $unitClass, int $rarity, string $origin, string $urlImg): void {
		$personnageData = compact('id', 'name', 'element', 'unitClass', 'rarity', 'origin', 'urlImg');

		try {
			new PersonnageDAO()->editPersonnage($personnageData);

			$message = 'Successfully edited the character.';
			new MainController($this->plates)->index($message, 'success');
		} catch (\PDOException) {
			$this->displayEditPersonnage($id, 'Error when trying to edit the character.');
		}
	}
}
