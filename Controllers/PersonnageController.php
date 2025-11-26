<?php

namespace Controllers;

use Helpers\Logger;
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

/**
 * Controller that handles {@link Personnage Character}-related operations.
 */
final readonly class PersonnageController {
	/**
	 * Creates a new instance of the controller.
	 *
	 * @param Engine $plates Templates engine instance
	 * @param Logger $logger Logger instance
	 */
	public function __construct(private Engine $plates, private Logger $logger) {}

	/**
	 * Handles retrieving the "Add Character" form data and
	 * creating the corresponding character in the database.
	 *
	 * @param string $name Character name
	 * @param int $element Character element ID
	 * @param int $unitClass Character unit class ID
	 * @param int $rarity Character rarity (4 or 5 stars)
	 * @param int $origin Character origin ID
	 * @param string $imageUrl Character image URL
	 */
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

			$this->logger->log(true, 'CREATE', 'Personnage', 'Created personnage: ' . $name);

			$message = 'Successfully created the character.';
			new MainController($this->plates, $this->logger)->index($message, 'success');
		} catch (\PDOException) {
			$this->logger->log(false, 'CREATE', 'Personnage', 'Failed to create personnage: ' . $name);

			$message = 'Error when trying to create the character.';
			$this->displayAddPersonnage($message);
		}
	}

	/**
	 * Deletes the given character from the database and redirects to the index page.
	 *
	 * @param ?string $id ID of the character to delete
	 */
	public function deletePersonnageAndIndex(?string $id): void {
		if (!$id) {
			$message = 'Character ID is missing.';
			new MainController($this->plates, $this->logger)->index($message, 'danger');
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
			$this->logger->log($messageType === 'success', 'DELETE', 'Personnage', $message . ' ' . $id);

			new MainController($this->plates, $this->logger)->index($message, $messageType);
		}
	}

	/**
	 * Displays the "Add Character" page.
	 *
	 * @param ?string $errorMessage An optional error message to display on the page
	 */
	public function displayAddPersonnage(?string $errorMessage = null): void {
		$gameData = $this->getAllGameData();
		$viewData = $errorMessage ? ['error' => $errorMessage] : [];
		echo $this->plates->render('add-perso', [
			'editMode' => false,
			...$gameData,
			...$viewData,
		]);
	}

	/**
	 * Displays the "Edit Character" page.
	 *
	 * @param string $id ID of the character to edit
	 * @param ?string $errorMessage An optional error message to display on the page
	 */
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

	/**
	 * Handles retrieving the "Edit Character" form data and
	 * updating the corresponding character in the database.
	 *
	 * @param string $id Character ID
	 * @param string $name Character name
	 * @param int $element Character element ID
	 * @param int $unitClass Character unit class ID
	 * @param int $rarity Character rarity (4 or 5 stars)
	 * @param int $origin Character origin ID
	 * @param string $urlImg Character image URL
	 */
	public function editPersonnage(string $id, string $name, int $element, int $unitClass, int $rarity, int $origin, string $urlImg): void {
		if ($this->checkForForeignParameters($element, $unitClass, $origin) === null) {
			return;
		}

		$personnageData = compact('id', 'name', 'element', 'unitClass', 'rarity', 'origin', 'urlImg');

		try {
			new PersonnageDAO()->editPersonnage($personnageData);

			$this->logger->log(
				true, 'EDIT', 'Personnage',
				'Edited personnage: ' . $name . ' (' . $id . ')'
			);

			$message = 'Successfully edited the character.';
			new MainController($this->plates, $this->logger)->index($message, 'success');
		} catch (\PDOException) {
			$this->logger->log(
				false, 'EDIT', 'Personnage',
				'Failed to edit personnage: ' . $name . ' (' . $id . ')'
			);

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
