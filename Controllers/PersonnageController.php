<?php

namespace Controllers;

use League\Plates\Engine;
use Models\Element;
use Models\ElementDAO;
use Models\Origin;
use Models\OriginDAO;
use Models\Personnage;
use Models\PersonnageDAO;
use Models\UnitClass;
use Models\UnitClassDAO;
use Services\PersonnageService;

final readonly class PersonnageController {
	public function __construct(private Engine $plates) {}

	public function addPersonnage(string $name, int $element, int $unitClass, int $rarity, int $origin, string $imageUrl): void {
		$id = uniqid(more_entropy: true);

		$objects = $this->checkForForeignParameters($element, $unitClass, $origin);
		if ($objects === null) {
			return;
		}

		$elementObject = $objects['element'];
		$unitClassObject = $objects['unitClass'];
		$originObject = $objects['origin'];

		$personnage = Personnage::fromRequestParams($id, $name, $elementObject, $unitClassObject, $rarity, $originObject, $imageUrl);
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
		$gameData = $this->getAllGameData();
		$viewData = $errorMessage ? ['error' => $errorMessage] : [];
		echo $this->plates->render('add-perso', [
			'editMode' => false,
			...$gameData,
			...$viewData,
		]);
	}

	public function displayEditPersonnage(string $id, ?string $errorMessage = null): void {
		$personnageService = new PersonnageService(new PersonnageDAO());

		$personnage = null;
		$message = null;
		try {
			$personnage = $personnageService->getByID($id);
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

		$gameData = $this->getAllGameData();
		$viewData = $errorMessage !== null ? ['error' => $errorMessage] : [];
		echo $this->plates->render('add-perso', [
			'editMode' => true,
			'personnage' => $personnage,
			...$gameData,
			...$viewData,
		]);
	}

	public function editPersonnage(string $id, string $name, int $element, int $unitClass, int $rarity, int $origin, string $urlImg): void {
		if ($this->checkForForeignParameters($element, $unitClass, $origin) === null) {
			return;
		}

		$personnageData = compact('id', 'name', 'element', 'unitClass', 'rarity', 'origin', 'urlImg');

		try {
			new PersonnageDAO()->editPersonnage($personnageData);

			$message = 'Successfully edited the character.';
			new MainController($this->plates)->index($message, 'success');
		} catch (\PDOException) {
			$this->displayEditPersonnage($id, 'Error when trying to edit the character.');
		}
	}

	/** @return ?array{element: Element, origin: Origin, unitClass: UnitClass} */
	private function checkForForeignParameters(int $element, int $unitClass, int $origin): ?array {
		try {
			$elementObject = new ElementDao()->getByID($element);
			$unitClassObject = new UnitClassDao()->getByID($unitClass);
			$originObject = new OriginDao()->getByID($origin);
		} catch (\PDOException) {
			$message = 'Error when trying to fetch the character\'s linked properties.';
			$this->displayAddPersonnage($message);
			return null;
		}

		if ($elementObject === null) {
			$message = 'The element you try to bind to this character does not exist.';
			$this->displayAddPersonnage($message);
			return null;
		}
		if ($unitClassObject === null) {
			$message = 'The unit class you try to bind to this character does not exist.';
			$this->displayAddPersonnage($message);
			return null;
		}
		if ($originObject === null) {
			$message = 'The origin you try to bind to this character does not exist.';
			$this->displayAddPersonnage($message);
			return null;
		}

		return [
			'element' => $elementObject,
			'origin' => $originObject,
			'unitClass' => $unitClassObject,
		];
	}

	/** @return array{elements: Element[], origins: Origin[], unitClasses: UnitClass[]} */
	private function getAllGameData(): array {
		return [
			'elements' => new ElementDao()->getAll(),
			'origins' => new OriginDao()->getAll(),
			'unitClasses' => new UnitClassDao()->getAll(),
		];
	}
}
