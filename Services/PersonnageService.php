<?php

namespace Services;

use Exceptions\NotFoundException;
use Models\ElementDAO;
use Models\OriginDAO;
use Models\Personnage;
use Models\PersonnageDAO;
use Models\UnitClassDAO;

/**
 * A service class to handle {@link Personnage characters}-related operations.
 */
readonly class PersonnageService {
	public function __construct(protected PersonnageDAO $dao) {}

	/**
	 * Retrieves all characters from the database.
	 *
	 * @return Personnage[] List of the existing characters
	 * @throws \PDOException If something went wrong while fetching the characters
	 */
	public function getAll(): array {
		$data = $this->dao->getAll();
		return array_map($this->fromDBObject(...), $data);
	}

	/**
	 * Retrieves a character from the database using its identifier.
	 *
	 * @param string $characterID The identifier of the character to retrieve
	 * @return ?Personnage The character with the given identifier, or null if not found
	 * @throws \PDOException If something went wrong while fetching the character
	 */
	public function getByID(string $characterID): ?Personnage {
		$data = $this->dao->getByID($characterID);
		return $data !== false ? $this->fromDBObject($data) : null;
	}


	/**
	 * Converts character's DB data to an instance of {@link Personnage}.
	 *
	 * @param \stdClass $data Character data from the database
	 * @return Personnage Built character instance
	 * @throws NotFoundException If one of the character's element, origin or unit class cannot be retrieved from the database
	 */
	protected function fromDBObject(\stdClass $data): Personnage {
		$element = new ElementDAO()->getByID($data->element);
		if ($element === null) {
			throw new NotFoundException('Unable to retrieve the character\'s element from the database.');
		}

		$origin = new OriginDAO()->getByID($data->origin);
		if ($origin === null) {
			throw new NotFoundException('Unable to retrieve the character\'s origin from the database.');
		}

		$unitClass = new UnitClassDAO()->getByID($data->unit_class);
		if ($unitClass === null) {
			throw new NotFoundException('Unable to retrieve the character\'s unit class from the database.');
		}

		$data->element = $element;
		$data->origin = $origin;
		$data->unit_class = $unitClass;

		return Personnage::fromDBObject($data);
	}
}
